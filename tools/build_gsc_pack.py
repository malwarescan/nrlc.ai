import os, re, csv, io, json, zipfile, datetime, urllib.parse, glob

# Use project-relative paths
PROJECT_ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
GSC_DIR = os.path.join(PROJECT_ROOT, "gsc_data")
OUT_DIR = os.path.join(PROJECT_ROOT, "website")
ZIP_PATH = os.path.join(OUT_DIR, "gsc-remediation-pack.zip")

os.makedirs(OUT_DIR, exist_ok=True)

# 1) Collect CSVs
candidates = []
for base in ("Chart", "Metadata", "Table"):
    candidates.extend(glob.glob(os.path.join(GSC_DIR, f"{base}*.csv")))

def read_csv_any(path, cap=5000):
    try:
        with open(path, "r", encoding="utf-8", errors="ignore") as f:
            data = f.read()
        try:
            dialect = csv.Sniffer().sniff(data[:4096])
        except Exception:
            dialect = csv.excel
        reader = csv.reader(io.StringIO(data), dialect)
        rows = []
        header = None
        for i, row in enumerate(reader):
            if i == 0:
                header = [c.strip() for c in row]
            else:
                rows.append(row)
            if len(rows) >= cap:
                break
        return header or [], rows
    except Exception:
        return [], []

url_cols  = {"url","page","page url","canonical","link","address","location"}
logo_cols = {"logo","image","logo_url"}
brand_cols= {"brand","site name","site","organization","org","publisher","brand_name"}

urls, logos, brands = set(), set(), set()

def harvest(header, rows):
    hl = [h.lower() for h in header]
    for r in rows:
        m = {hl[i]: r[i] for i in range(min(len(hl), len(r)))}
        for k, v in m.items():
            if not isinstance(v, str): continue
            v = v.strip()
            if not v: continue
            lk = k.lower()
            if lk in url_cols or ("url" in lk and len(lk) <= 12):
                if v.startswith("http://") or v.startswith("https://"):
                    urls.add(v)
            if lk in logo_cols or "logo" in lk:
                if v.startswith("http://") or v.startswith("https://"):
                    logos.add(v)
            if lk in brand_cols and v:
                brands.add(v)

for p in candidates:
    h, r = read_csv_any(p)
    if h:
        harvest(h, r)

def ensure_https(u: str) -> str:
    if not u: return u
    try:
        p = urllib.parse.urlparse(u)
        if p.scheme == "https": return u
        if p.scheme == "http":
            return urllib.parse.urlunparse(("https", p.netloc, p.path, p.params, p.query, p.fragment))
    except Exception:
        pass
    return u

def infer_base(urls_set):
    for u in sorted(urls_set):
        try:
            p = urllib.parse.urlparse(u)
            if p.scheme in ("http","https") and p.netloc:
                return f"https://{p.netloc}"
        except Exception:
            continue
    return "https://example.com"

BASE_URL = infer_base(urls) if urls else "https://example.com"
ROBOTS_HOST = urllib.parse.urlparse(BASE_URL).netloc or "example.com"
SITEMAP_URL = f"{BASE_URL.rstrip('/')}/sitemap.xml"

# 2) Locales
locale_re = re.compile(r"/([a-z]{2}(?:-[a-z]{2})?)(?:/|$)", re.IGNORECASE)
locales = set()
for u in urls:
    try:
        p = urllib.parse.urlparse(u)
        for m in locale_re.finditer(p.path):
            locales.add(m.group(1).lower())
        qs = urllib.parse.parse_qs(p.query)
        if "hl" in qs:
            for v in qs["hl"]:
                if re.fullmatch(r"[a-z]{2}(?:-[a-z]{2})?", v, re.IGNORECASE):
                    locales.add(v.lower())
    except Exception:
        pass
if not locales:
    locales = {"en"}
DEFAULT_LOCALE = sorted(locales)[0]

# 3) Canonicals (https normalized)
def to_https_canonical(u):
    try:
        p = urllib.parse.urlparse(u)
        netloc = p.netloc or urllib.parse.urlparse(BASE_URL).netloc
        path = p.path or "/"
        return urllib.parse.urlunparse(("https", netloc, path, "", "", ""))
    except Exception:
        return None

canonicals, seen = [], set()
for u in sorted(urls):
    cu = to_https_canonical(u)
    if cu and cu not in seen:
        seen.add(cu)
        canonicals.append(cu)
canonicals = canonicals[:5000]
ORG_LOGO = ensure_https(next(iter(logos)) if logos else "")

SITE_NAME = (next(iter(brands)) if brands else "Your Site").replace("\n"," ").strip()

# 4) Build ZIP
with zipfile.ZipFile(ZIP_PATH, "w", compression=zipfile.ZIP_DEFLATED) as z:
    # .env.suggested
    env_text = "\n".join([
        "# Suggested environment variables extracted from GSC CSVs",
        f"BASE_URL={BASE_URL}",
        f"DEFAULT_LOCALE={DEFAULT_LOCALE}",
        f"LOCALES={','.join(sorted(locales))}",
        f"SITE_NAME={SITE_NAME}",
        f"ORG_URL={BASE_URL}",
        f"ORG_LOGO={ORG_LOGO or (BASE_URL.rstrip('/') + '/logo.png')}",
        "ORG_SAME_AS=",
        "SCHEMA_PUBLISHER_NAME=",
        "SCHEMA_PUBLISHER_LOGO=",
        f"SITEMAP_INDEX={SITEMAP_URL}",
        f"ROBOTS_HOST={ROBOTS_HOST}",
        ""
    ])
    z.writestr(".env.suggested", env_text)

    # robots.txt
    robots = f"User-agent: *\nAllow: /\nHost: {ROBOTS_HOST}\nSitemap: {SITEMAP_URL}\n"
    z.writestr("robots.txt", robots)

    # sitemap.xml
    now_iso = datetime.datetime.utcnow().strftime("%Y-%m-%dT%H:%M:%SZ")
    if not canonicals:
        canonicals = [BASE_URL]
    urls_xml = "\n".join([f"  <url><loc>{u}</loc><lastmod>{now_iso}</lastmod></url>" for u in canonicals])
    site_xml = f'<?xml version="1.0" encoding="UTF-8"?>\n<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">\n{urls_xml}\n</urlset>\n'
    z.writestr("sitemap.xml", site_xml)

    # schema/SchemaFixes.php
    schema_php = """<?php
declare(strict_types=1);
namespace NRLC\\Schema;

final class SchemaFixes
{
    public static function normalizeExperienceRequirements(?string $raw)
    {
        $raw = trim((string)$raw);
        if ($raw === '' || preg_match('/\\b(no|none|n\\/a|entry[-\\s]?level)\\b/i', $raw)) {
            return ['@type'=>'OccupationalExperienceRequirements','monthsOfExperience'=>0];
        }
        if (preg_match('/(\\d+)\\s*months?/i', $raw, $m)) {
            return ['@type'=>'OccupationalExperienceRequirements','monthsOfExperience'=>max(0,(int)$m[1])];
        }
        if (preg_match('/(\\d+)\\s*(?:\\+|-\\s*\\d+)?\\s*years?/i', $raw, $m)) {
            return ['@type'=>'OccupationalExperienceRequirements','monthsOfExperience'=>max(0, (int)$m[1]*12)];
        }
        if (preg_match('/(\\d+)\\s*\\+?\\s*(yrs?|y\\.?)/i', $raw, $m)) {
            return ['@type'=>'OccupationalExperienceRequirements','monthsOfExperience'=>max(0, (int)$m[1]*12)];
        }
        $text = preg_replace('/\\s+/u', ' ', $raw);
        return trim($text);
    }

    public static function normalizeEducationRequirements(?string $raw): ?string
    {
        $raw = trim((string)$raw);
        if ($raw === '') return null;
        $canon = [
            '/\\b(no\\s*degree|none|n\\/a)\\b/i'          => 'No degree required',
            '/\\b(high\\s*school|hs\\s*diploma)\\b/i'     => 'High school diploma',
            '/\\b(associate(\\'?s)?|aa|as)\\b/i'          => "Associate's degree",
            '/\\b(bachelor(\\'?s)?|ba|bs|bsc)\\b/i'       => "Bachelor's degree",
            '/\\b(master(\\'?s)?|ma|ms|msc)\\b/i'         => "Master's degree",
            '/\\b(doctorate|ph\\.?d|md|dphil)\\b/i'       => "Doctorate"
        ];
        foreach ($canon as $re => $val) {
            if (preg_match($re, $raw)) return $val;
        }
        $text = preg_replace('/\\s+/u', ' ', $raw);
        return trim($text);
    }

    public static function jsonLdOnce($jsonOrArray, string $idKey='@id'): ?string
    {
        static $seen=[];
        $decoded = is_array($jsonOrArray) ? $jsonOrArray : json_decode((string)$jsonOrArray, true);
        if (!is_array($decoded)) return null;
        $items = self::isAssoc($decoded) ? [$decoded] : $decoded;
        foreach ($items as $obj) {
            if (isset($obj[$idKey])) {
                $id = (string)$obj[$idKey];
                if (isset($seen[$id])) return null;
                $seen[$id] = true;
            }
        }
        return json_encode($decoded, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_INVALID_UTF8_SUBSTITUTE);
    }

    public static function ensureHttps(?string $url): ?string
    {
        if (!$url) return $url;
        if (stripos($url, 'https://') === 0) return $url;
        if (stripos($url, 'http://') === 0) {
            return 'https://' . substr($url, 7);
        }
        return $url;
    }

    private static function isAssoc(array $arr): bool
    {
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}
"""
    z.writestr("schema/SchemaFixes.php", schema_php)

    # schema/schema-examples.json
    examples = {
        "@graph": [
            {
                "@context": "https://schema.org",
                "@type": "Organization",
                "@id": f"{BASE_URL.rstrip('/')}/#organization",
                "name": SITE_NAME or "Your Organization",
                "url": BASE_URL,
                "logo": ORG_LOGO or f"{BASE_URL.rstrip('/')}/logo.png",
                "sameAs": []
            },
            {
                "@context": "https://schema.org",
                "@type": "WebSite",
                "@id": f"{BASE_URL.rstrip('/')}/#website",
                "url": BASE_URL,
                "name": SITE_NAME or "Website",
                "publisher": {"@id": f"{BASE_URL.rstrip('/')}/#organization"}
            },
            {
                "@context": "https://schema.org",
                "@type": "WebPage",
                "@id": f"{BASE_URL.rstrip('/')}/#webpage",
                "url": BASE_URL,
                "name": "Home",
                "isPartOf": {"@id": f"{BASE_URL.rstrip('/')}/#website"},
                "breadcrumb": {"@id": f"{BASE_URL.rstrip('/')}/#breadcrumb"}
            },
            {
                "@context": "https://schema.org",
                "@type": "BreadcrumbList",
                "@id": f"{BASE_URL.rstrip('/')}/#breadcrumb",
                "itemListElement": [
                    {"@type": "ListItem", "position": 1, "name": "Home", "item": BASE_URL}
                ]
            }
        ]
    }
    z.writestr("schema/schema-examples.json", json.dumps(examples, indent=2))

    # hreflang/hreflang-template.csv
    lines = ["canonical_url,locale,href"]
    sample = canonicals[:20] or [BASE_URL]
    locs = sorted(locales)
    for u in sample:
        parsed = urllib.parse.urlparse(u)
        for loc in locs:
            path = parsed.path or "/"
            parts = [p for p in path.split("/") if p]
            # insert or replace first segment with locale
            if parts and re.fullmatch(r"[a-z]{2}(?:-[a-z]{2})?", parts[0], re.IGNORECASE):
                parts[0] = loc
                new_path = "/" + "/".join(parts)
            else:
                new_path = "/" + loc + ("" if path == "/" else path)
            href = urllib.parse.urlunparse(("https", parsed.netloc, new_path, "", "", ""))
            lines.append(f"{u},{loc},{href}")
    z.writestr("hreflang/hreflang-template.csv", "\n".join(lines))

    # patches/https-normalize.md
    host = urllib.parse.urlparse(BASE_URL).netloc or "example.com"
    patch = f"""HTTPS Normalization Runbook
1) Replace http:// with https:// for org URLs and logos in templates.
2) Ensure canonical URLs use https. Base host: {host}.
3) Update sitemap.xml and robots.txt to reference https.
Regex examples:
- Search: \\bhttp://{re.escape(host)}\\b
- Replace: https://{host}
"""
    z.writestr("patches/https-normalize.md", patch)

    # README.txt
    readme = f"""Google Search Console Remediation Pack
Generated: {datetime.datetime.utcnow().isoformat()}Z

Contents
- .env.suggested
- robots.txt
- sitemap.xml
- schema/SchemaFixes.php
- schema/schema-examples.json
- hreflang/hreflang-template.csv
- patches/https-normalize.md

Quick Start
1) Review .env.suggested and apply values.
2) Place robots.txt at site root; verify at /robots.txt.
3) Deploy sitemap.xml at /sitemap.xml; submit in Search Console.
4) Integrate schema/SchemaFixes.php in JSON-LD emitters (normalize experienceRequirements, educationRequirements; prevent duplicates; enforce https).
5) Complete hreflang-template.csv if multilingual; add <link rel="alternate" hreflang="..."> in templates.
6) Revalidate in Search Console (Structured Data, Sitemaps, Page indexing).

Detected
- Base URL guess: {BASE_URL}
- Locales: {', '.join(sorted(locales))}
- Canonical URLs included: {len(canonicals)}
"""
    z.writestr("README.txt", readme)

# 5) Extract ZIP into /website without overwriting existing files
with zipfile.ZipFile(ZIP_PATH, "r") as z:
    for member in z.infolist():
        target = os.path.join(OUT_DIR, member.filename)
        if os.path.exists(target):
            continue  # skip to avoid clobbering
        os.makedirs(os.path.dirname(target), exist_ok=True)
        with z.open(member) as src, open(target, "wb") as dst:
            dst.write(src.read())

print(ZIP_PATH)


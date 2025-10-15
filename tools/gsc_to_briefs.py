import os, re, csv, io, json, glob, datetime, urllib.parse
from collections import defaultdict

# Use project-relative paths
PROJECT_ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
BASE_GSC = os.path.join(PROJECT_ROOT, "gsc_data")
OUT_DIR  = os.path.join(PROJECT_ROOT, "website", "seo-briefs")
os.makedirs(OUT_DIR, exist_ok=True)

def read_csv(name):
    p = os.path.join(BASE_GSC, name)
    if not os.path.exists(p):
        print(f"Warning: {name} not found, skipping")
        return [], []
    for enc in ("utf-8","utf-8-sig","latin-1"):
        try:
            with open(p,"r",encoding=enc,errors="ignore") as f:
                data=f.read()
            # naive split to support odd delimiters
            dialect = csv.Sniffer().sniff(data[:4096]) if len(data)>0 else csv.excel
            rows=list(csv.reader(io.StringIO(data), dialect))
            hdr=[h.strip() for h in rows[0]] if rows else []
            items=[dict(zip(hdr,r)) for r in rows[1:]]
            return hdr, items
        except Exception as e:
            continue
    return [], []

def num(x):
    try: return float(str(x).replace('%','').replace(',','').strip())
    except: return None

# Load
print(f"Reading GSC data from: {BASE_GSC}")
q_hdr, q_rows = read_csv("Queries.csv")
p_hdr, p_rows = read_csv("Pages.csv")
c_hdr, c_rows = read_csv("Countries.csv")
d_hdr, d_rows = read_csv("Devices.csv")

print(f"Loaded {len(q_rows)} queries, {len(p_rows)} pages")

# Normalize fields
for r in q_rows:
    r["Query"]  = r.get("Top queries", r.get("Query","")).strip()
    r["Impressions"] = num(r.get("Impressions"))
    r["Position"]    = num(r.get("Position"))
for r in p_rows:
    r["Page"]  = r.get("Top pages", r.get("Page","")).strip()
    r["Impressions"] = num(r.get("Impressions"))
    r["Position"]    = num(r.get("Position"))

# Heuristics
def locale_of(url):
    try:
        path = urllib.parse.urlparse(url).path
        seg = [s for s in path.split("/") if s]
        if seg and re.fullmatch(r"[a-z]{2}(?:-[a-z]{2})?", seg[0], re.I):
            return seg[0].lower()
    except: pass
    return None

def tokens(url):
    path = urllib.parse.urlparse(url).path.lower()
    return set([t for t in re.split(r"[^a-z0-9]+", path) if t])

# 1) Candidate pages: strike zone + top impressions
pages = [r for r in p_rows if r.get("Page")]
for r in pages:
    r["Locale"] = locale_of(r["Page"])
    r["Tokens"] = tokens(r["Page"])
    r["is_http"] = r["Page"].startswith("http://")

strike_pages = [r for r in pages if r["Position"] and 5 <= r["Position"] <= 15]
top_pages    = sorted(pages, key=lambda x: (-(x["Impressions"] or 0), x["Position"] or 999))[:50]

print(f"Strike zone pages (pos 5-15): {len(strike_pages)}")
print(f"Top impression pages: {len(top_pages)}")

# 2) Query → page assignment (fuzzy: token overlap + locale)
queries = [r for r in q_rows if r.get("Query")]
for r in queries:
    r["q_tokens"] = set([t for t in re.split(r"[^a-z0-9]+", r["Query"].lower()) if t])
    r["Impressions"] = r["Impressions"] or 0
    r["Position"]    = r["Position"] or 999

def score(q, p):
    # locale preference if language code appears in path
    loc_bonus = 0.5 if (p["Locale"] and p["Locale"] in p["Page"]) else 0
    overlap = len(q["q_tokens"] & p["Tokens"])
    return overlap + loc_bonus

assignments = defaultdict(list)
# Deduplicate by page URL
seen_pages = {}
for p in (strike_pages + top_pages):
    if p["Page"] not in seen_pages:
        seen_pages[p["Page"]] = p
candidate_pool = list(seen_pages.values())
for q in queries:
    if q["Impressions"] < 2 or not (5 <= q["Position"] <= 20):
        continue
    best = max(candidate_pool, key=lambda p: score(q,p)) if candidate_pool else None
    if best:
        assignments[best["Page"]].append(q)

print(f"Query-to-page assignments: {len(assignments)} pages with matched queries")

# 3) Build briefs
NOW = datetime.datetime.utcnow().strftime("%Y-%m-%d")
def cap(s, n):
    s = re.sub(r"\s+", " ", s).strip()
    return (s[:n-1]+"…") if len(s)>n else s

def https_url(u):
    if not isinstance(u,str): return u
    if u.startswith("https://"): return u
    if u.startswith("http://"): return "https://" + u[7:]
    return u

def make_brief(page, page_row, qs):
    kw_primary = sorted(qs, key=lambda x: (-x["Impressions"], x["Position"]))[0]["Query"] if qs else None
    kws_support = [x["Query"] for x in sorted(qs, key=lambda x: (-x["Impressions"], x["Position"]))[1:4]]
    # Title, H1, Meta
    base = kw_primary or "Update"
    netloc = urllib.parse.urlparse(page).netloc or "NRLC.ai"
    title = cap(f"{base} | {netloc}", 60)
    h1    = cap(base.title(), 70)
    meta  = cap(f"{base} — solutions, pricing, and FAQs. Updated {NOW}.", 160)

    # Subheads (expand sub-intents)
    subs = []
    for k in ([kw_primary] + kws_support) if kw_primary else kws_support:
        if not k: continue
        subs.append(f"{k} benefits and use cases")
    while len(subs) < 3: subs.append("Capabilities and pricing")
    subs = subs[:5]

    # FAQs
    faqs = []
    for k in ([kw_primary] + kws_support) if kw_primary else []:
        q1 = f"What is {k}?"
        a1 = f"{k} is explained in practical terms for decision-makers. This page covers fundamentals, implementation steps, and expected outcomes."
        q2 = f"How does {k} improve results?"
        a2 = f"It addresses common bottlenecks and aligns with measurable KPIs. See our implementation notes and case-style examples."
        faqs += [(q1,a1),(q2,a2)]
    if not faqs:
        faqs = [("How do we engage?", "Contact us for an assessment. We align scope to outcomes and timeline.")]
    faqs = faqs[:6]

    # Internal links (simple heuristic)
    parsed = urllib.parse.urlparse(page)
    hub = f"https://{parsed.netloc}/services/"
    links = [hub]
    if "/insights/" in page: links.append(f"https://{parsed.netloc}/services/consulting/")

    # JSON-LD FAQ
    faq_ld = {
      "@context": "https://schema.org",
      "@type": "FAQPage",
      "mainEntity": [{"@type":"Question","name":q,"acceptedAnswer":{"@type":"Answer","text":a}} for q,a in faqs]
    }

    # Assemble brief
    return f"""# Page SEO Brief
URL: {https_url(page)}
Locale: {page_row.get('Locale') or 'n/a'}
Avg Position: {page_row.get('Position')}
Impressions: {page_row.get('Impressions')}

## Primary Keyword
{kw_primary or 'TBD from assignments'}

## Supporting Keywords
{", ".join(kws_support) if kws_support else "—"}

## Title (<=60)
{title}

## H1
{h1}

## Meta Description (150–160)
{meta}

## Intro Paragraph
Explain {kw_primary or 'the topic'} in one crisp paragraph focused on user intent. Mention outcome, timeline, and proof signals.

## Suggested Subheads
- {subs[0]}
- {subs[1]}
- {subs[2]}

## Internal Links
- {links[0]}
{("- " + links[1]) if len(links)>1 else ""}

## HTTPS Normalization
- Canonical should be https
- All schema URLs/logo should be https
{"- WARNING: Page currently http — fix templates/canonicals" if page_row.get("is_http") else ""}

## FAQ (also output as JSON-LD)
```json
{json.dumps(faq_ld, ensure_ascii=False, indent=2)}
```
"""

# Write briefs
targets = set(assignments.keys())
# Always include pages near pos 5–10 even if no queries matched
targets.update([r["Page"] for r in strike_pages])

print(f"Generating briefs for {len(targets)} target pages...")

for page in sorted(targets):
    row = next((r for r in pages if r["Page"]==page), {})
    brief = make_brief(page, row, assignments.get(page, []))
    fname = os.path.join(OUT_DIR, re.sub(r"[^a-z0-9]+","-", urllib.parse.urlparse(page).path.strip("/").lower()) or "home")
    with open(fname + ".md", "w", encoding="utf-8") as f:
        f.write(brief)

# Summary index
index = {
  "generated_at": datetime.datetime.utcnow().isoformat()+"Z",
  "pages_with_briefs": len([f for f in os.listdir(OUT_DIR) if f.endswith('.md')]),
  "notes": [
    "Briefs prioritize striking-distance pages and queries with impressions >=2, position 5–20.",
    "Titles under 60 chars, meta ~155 chars, H1 aligned to primary keyword.",
    "Includes HTTPS checks, internal links, and FAQPage JSON-LD."
  ]
}
with open(os.path.join(OUT_DIR, "_index.json"), "w", encoding="utf-8") as f:
    json.dump(index, f, indent=2)

print(f"\n✅ OK: wrote {index['pages_with_briefs']} briefs to {OUT_DIR}")
print(f"   Index: {os.path.join(OUT_DIR, '_index.json')}")


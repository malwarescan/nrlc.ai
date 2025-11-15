import argparse, os, re, json, time, pathlib, math, textwrap, csv
from collections import defaultdict, Counter
from urllib.parse import urlparse
import requests
import pandas as pd
from bs4 import BeautifulSoup
from slugify import slugify
from readability import Document
from rapidfuzz import fuzz

UA = "Mozilla/5.0 (compatible; SERP-Intel/0.1; +https://n/a)"
TIMEOUT = 12

# ---------- Helpers ----------
def read_csv_any(path):
    return pd.read_csv(path, dtype=str).fillna("")

def to_int(x, default=0):
    try: return int(float(x))
    except: return default

def to_float(x, default=0.0):
    try: return float(x)
    except: return default

def safe_get(url):
    try:
        r = requests.get(url, headers={"User-Agent": UA}, timeout=TIMEOUT, allow_redirects=True)
        return r
    except Exception:
        return None

def extract_meta(soup, name=None, prop=None):
    if name:
        tag = soup.find("meta", attrs={"name": name})
        if tag and tag.get("content"): return tag["content"].strip()
    if prop:
        tag = soup.find("meta", attrs={"property": prop})
        if tag and tag.get("content"): return tag["content"].strip()
    return ""

def get_ldjson_types(soup):
    types = []
    for s in soup.find_all("script", {"type":"application/ld+json"}):
        try:
            data = json.loads(s.string or "")
            def collect(d):
                if isinstance(d, dict):
                    t = d.get("@type")
                    if isinstance(t, str): types.append(t)
                    elif isinstance(t, list): types.extend([str(x) for x in t])
                    for v in d.values(): collect(v)
                elif isinstance(d, list):
                    for v in d: collect(v)
            collect(data)
        except Exception:
            continue
    return sorted(set(types))

def text_len_words(txt): 
    return len(re.findall(r"\w+", txt or ""))

def meta_len(s): 
    return len((s or "").strip())

def has_kw(s, kw): 
    return kw and s and fuzz.partial_ratio(kw.lower(), s.lower()) >= 80

def pick_primary_kw(queries_for_url):
    # choose highest-impressions query as primary
    if not queries_for_url: return ""
    queries_for_url = sorted(queries_for_url, key=lambda q: (-q.get("impressions",0), q["query"]))
    return queries_for_url[0]["query"]

def clamp(v, lo, hi): 
    return max(lo, min(hi, v))

def score_title(title, primary_kw):
    l = meta_len(title)
    length_ok = 40 <= l <= 65
    includes = has_kw(title, primary_kw)
    return 0.5*(1 if length_ok else 0) + 0.5*(1 if includes else 0)

def score_desc(desc, primary_kw):
    l = meta_len(desc)
    length_ok = 120 <= l <= 160
    includes = has_kw(desc, primary_kw)
    return 0.5*(1 if length_ok else 0) + 0.5*(1 if includes else 0)

def score_headings(h1s, h2s, primary_kw):
    h1_ok = any(has_kw(h, primary_kw) for h in h1s) if h1s else False
    h2_ok = any(has_kw(h, primary_kw) for h in h2s) if h2s else False
    return 0.6*(1 if h1_ok else 0) + 0.4*(1 if h2_ok else 0)

def score_depth(word_count):
    # heuristic: 800+ words gets full
    return clamp(word_count/800.0, 0, 1)

def score_schema(types):
    # any rich result types present?
    rr = {"FAQPage","HowTo","Product","JobPosting","LocalBusiness","Service","Article","Course","SoftwareApplication","Review","Event","Dataset"}
    return 1.0 if rr.intersection(set(types)) else 0.0

def composite_score(parts):
    # weights tuned for practical impact
    return round( 0.25*parts["title"] + 0.2*parts["desc"] + 0.2*parts["headings"] + 0.2*parts["depth"] + 0.15*parts["schema"], 3)

def ensure_dir(p): pathlib.Path(p).mkdir(parents=True, exist_ok=True)

def semantic_predictions(queries_for_url, top_n=12):
    # derive related terms from co-occurring queries
    bag = Counter()
    for q in queries_for_url:
        for token in re.findall(r"[a-z0-9]+", q["query"].lower()):
            if token in {"the","and","or","to","for","in","of","a","an","on","near","with","from","by"}: 
                continue
            bag[token]+=q.get("impressions",0)
    return [w for w,_ in bag.most_common(top_n)]

def detect_robots_noindex(soup):
    robots = extract_meta(soup, name="robots").lower()
    return "noindex" in robots if robots else False

def detect_canonical(soup):
    link = soup.find("link", rel=lambda x: x and "canonical" in x.lower())
    return (link.get("href") or "").strip() if link else ""

def try_readability(html):
    try:
        d = Document(html)
        txt = BeautifulSoup(d.summary(html_partial=True), "lxml").get_text(" ", strip=True)
        return txt
    except Exception:
        return ""

# ---------- Core ----------
def build(data_dir, out_dir):
    ensure_dir(out_dir)
    ensure_dir(os.path.join(out_dir,"url_cards"))

    # Load CSVs (GSC standard: adjust columns if needed)
    q = read_csv_any(os.path.join(data_dir,"Queries.csv"))
    p = read_csv_any(os.path.join(data_dir,"Pages.csv"))
    c = read_csv_any(os.path.join(data_dir,"Countries.csv"))

    # Normalize column names to standard format
    # Queries.csv: "Top queries" -> "Query", "Page" column missing, needs mapping
    if "Top queries" in q.columns:
        q.rename(columns={"Top queries": "Query"}, inplace=True)
    if "Top pages" in p.columns:
        p.rename(columns={"Top pages": "Page"}, inplace=True)
    
    # Normalize expected columns for all CSVs
    for df in (q,p,c):
        for col in ["Clicks","Impressions","Position"]:
            if col in df.columns:
                df[col] = df[col].apply(to_float)
        if "CTR" in df.columns:
            df["CTR"] = df["CTR"].astype(str).str.replace("%","", regex=False).apply(to_float)
    
    # Handle missing Page column in Queries.csv - skip for now
    if "Page" not in q.columns:
        print("WARNING: Queries.csv missing 'Page' column, skipping query-to-page mapping")
        q_top = pd.DataFrame()
    else:
        # Filter Queries to top-10 average position
        if not q.empty and "Position" in q.columns:
            q_top = q[q["Position"] <= 10]
        else:
            q_top = q.copy()

    # Group queries by URL (from Pages.csv since Queries.csv doesn't have Page column)
    queries_by_url = defaultdict(list)
    if not q_top.empty and "Page" in q_top.columns:
        for _,row in q_top.iterrows():
            url = row.get("Page","").strip()
            qry = row.get("Query","").strip()
            if not url or not qry: continue
            queries_by_url[url].append({
                "query": qry,
                "clicks": to_float(row.get("Clicks",0)),
                "impressions": to_float(row.get("Impressions",0)),
                "ctr": to_float(row.get("CTR",0)),
                "position": to_float(row.get("Position",0))
            })

    # Country intent by URL (sum top-10 only)
    country_by_url = defaultdict(lambda: defaultdict(float))
    if not c.empty:
        c_top = c[c["Position"] <= 10] if "Position" in c.columns else c
        for _,row in c_top.iterrows():
            url = row.get("Page","").strip()
            cc = row.get("Country","").strip()
            if not url or not cc: continue
            country_by_url[url][cc] += to_float(row.get("Impressions",0))

    # Pages baseline metrics
    page_metrics = {}
    for _,row in p.iterrows():
        url = row.get("Page","").strip()
        if not url: continue
        page_metrics[url] = {
            "page_clicks": to_float(row.get("Clicks",0)),
            "page_impressions": to_float(row.get("Impressions",0)),
            "page_ctr": to_float(row.get("CTR",0)),
            "page_pos": to_float(row.get("Position",0))
        }

    # Fallback: use Pages.csv URLs if no query-to-page mapping
    if not queries_by_url:
        print("No query-to-page mapping found, using Pages.csv URLs directly")
        for _,row in p.iterrows():
            url = row.get("Page","").strip()
            if url:
                queries_by_url[url] = [{"query": url, "impressions": 1}]
    
    rows = []
    schema_ndjson = []
    for url, qlist in queries_by_url.items():
        primary_kw = pick_primary_kw(qlist)
        sem_preds = semantic_predictions(qlist)

        r = safe_get(url)
        status = r.status_code if r else None
        final_url = r.url if r else url
        html = r.text if (r and r.text) else ""
        soup = BeautifulSoup(html, "lxml") if html else BeautifulSoup("", "lxml")

        title = (soup.title.string or "").strip() if soup.title else ""
        meta_desc = extract_meta(soup, "description")
        og_title = extract_meta(soup, prop="og:title")
        og_desc  = extract_meta(soup, prop="og:description")
        h1s = [t.get_text(" ", strip=True) for t in soup.select("h1")] or []
        h2s = [t.get_text(" ", strip=True) for t in soup.select("h2")] or []
        canon = detect_canonical(soup)
        noindex = detect_robots_noindex(soup)
        ld_types = get_ldjson_types(soup)

        # Word count (readability fallback)
        body_text = try_readability(html) if html else ""
        if not body_text:
            body_text = soup.get_text(" ", strip=True)
        wc = text_len_words(body_text)

        scores = {
            "title": score_title(title or og_title, primary_kw),
            "desc":  score_desc(meta_desc or og_desc, primary_kw),
            "headings": score_headings(h1s, h2s, primary_kw),
            "depth": score_depth(wc),
            "schema": score_schema(ld_types),
        }
        total_score = composite_score(scores)

        countries = country_by_url.get(url, {})
        top_countries = ", ".join([f"{k}:{int(v)}" for k,v in sorted(countries.items(), key=lambda kv: -kv[1])[:5]])

        pm = page_metrics.get(url, {})
        clicks = pm.get("page_clicks", 0)
        imp    = pm.get("page_impressions", 0)
        ctr    = pm.get("page_ctr", 0)
        pos    = pm.get("page_pos", 0)

        # Recommendations
        recs = []
        if scores["title"] < 1:
            if not has_kw(title, primary_kw):
                recs.append(f"Add primary keyword to <title> (primary: \"{primary_kw}\").")
            l = meta_len(title)
            if l < 40: recs.append("Title too short (<40 chars). Expand with value props.")
            if l > 65: recs.append("Title too long (>65). Tighten to avoid truncation.")
        if scores["desc"] < 1:
            if not meta_desc:
                recs.append("Add a meta description (120–160 chars) with primary + value CTA.")
            else:
                l = meta_len(meta_desc)
                if l < 120: recs.append("Meta description too short; expand benefits + entities.")
                if l > 160: recs.append("Meta description too long; tighten to 120–160.")
                if not has_kw(meta_desc, primary_kw):
                    recs.append("Add primary keyword to meta description naturally.")
        if not h1s: recs.append("Missing H1.")
        elif not any(has_kw(h, primary_kw) for h in h1s):
            recs.append("Add primary keyword to H1 (keep human-readable).")
        if wc < 800:
            recs.append(f"Thin content ({wc} words). Target 1000–1500 with semantic coverage: {', '.join(sem_preds[:6])}.")
        if not canon:
            recs.append("Add <link rel='canonical'> to stable preferred URL.")
        if noindex:
            recs.append("Page has noindex; remove if it should rank.")
        # Schema suggestions
        if "FAQPage" not in ld_types and len(qlist) >= 6 and wc >= 700:
            recs.append("Add FAQPage JSON-LD for common objections and how-to steps.")
            schema_ndjson.append({"@context":"https://schema.org","@type":"FAQPage","about":primary_kw,"mainEntity":[
                {"@type":"Question","name":f"{primary_kw}: what to know?","acceptedAnswer":{"@type":"Answer","text":"Answer concisely with specifics, costs, time, and caveats."}}
            ], "_target": url})
        # Service/Product/Article heuristics
        if ("Service" not in ld_types) and any(t in url.lower() for t in ["service","services","/products/","/pricing/"]):
            recs.append("Add Service schema with areaServed, offers, and provider.")
            schema_ndjson.append({"@context":"https://schema.org","@type":"Service","name":title or primary_kw,"areaServed": list(countries.keys()) or None,"provider": {"@type":"Organization"}, "_target": url})
        if ("Article" not in ld_types) and any(seg in url.lower() for seg in ["/blog/","/news/","/guide/","/learn/"]):
            recs.append("Add Article schema with headline, datePublished, author, image.")
            schema_ndjson.append({"@context":"https://schema.org","@type":"Article","headline": title or primary_kw, "_target": url})
        if ("LocalBusiness" not in ld_types) and any(seg in url.lower() for seg in ["/locations/","/naples","/fl/","/th/","/kr/","/zh/"]):
            recs.append("Add LocalBusiness schema (address, geo, phone, hours).")

        rows.append({
            "url": url,
            "final_url": final_url,
            "http_status": status,
            "primary_kw": primary_kw,
            "co_occurrence_terms": "|".join(sem_preds),
            "title": title,
            "title_len": meta_len(title),
            "meta_desc_len": meta_len(meta_desc),
            "h1_count": len(h1s),
            "h2_count": len(h2s),
            "word_count": wc,
            "canonical": canon,
            "robots_noindex": noindex,
            "ld_types": ",".join(ld_types),
            "score_title": scores["title"],
            "score_desc": scores["desc"],
            "score_headings": scores["headings"],
            "score_depth": scores["depth"],
            "score_schema": scores["schema"],
            "score_total": total_score,
            "page_clicks": clicks,
            "page_impressions": imp,
            "page_ctr": ctr,
            "page_position": pos,
            "top_countries": top_countries,
            "recommendations": " | ".join(recs)
        })

        # Per-URL fix card
        card = f"""# {title or url}
URL: {url}
Primary keyword: {primary_kw}
Average position (page): {pos} | CTR: {ctr:.2f}% | Clicks/Impr: {int(clicks)}/{int(imp)}

## On-page snapshot
- Title ({meta_len(title)}): {title or "—"}
- Meta description ({meta_len(meta_desc)}): {meta_desc or "—"}
- H1s ({len(h1s)}): {h1s or "—"}
- H2s ({len(h2s)}): {(h2s[:6]) if h2s else "—"}
- Word count: {wc}
- Canonical: {canon or "—"}
- Robots noindex: {noindex}
- Detected schema: {", ".join(ld_types) or "—"}

## Semantic predictions
{", ".join(sem_preds) or "—"}

## Recommended fixes (priority order)
1. {recs[0] if recs else "No critical issues detected."}
{''.join([f"{i+2}. {r}\n" for i,r in enumerate(recs[1:])])}
"""
        with open(os.path.join(out_dir,"url_cards", f"{slugify(url)}.md"), "w", encoding="utf-8") as f:
            f.write(card)

    # Write CSV
    audit_path = os.path.join(out_dir,"serp_intel_audit.csv")
    pd.DataFrame(rows).sort_values(["score_total","page_position"], ascending=[True, True]).to_csv(audit_path, index=False, quoting=csv.QUOTE_MINIMAL)

    # Write NDJSON
    nd_path = os.path.join(out_dir,"schema_suggestions.ndjson")
    with open(nd_path, "w", encoding="utf-8") as f:
        for obj in schema_ndjson:
            f.write(json.dumps(obj, ensure_ascii=False) + "\n")

    # Write summary + recommendations.md
    df = pd.DataFrame(rows)
    summary = {
        "urls_audited": int(len(df)),
        "avg_total_score": float(df["score_total"].mean()) if not df.empty else 0.0,
        "thin_content_count": int((df["word_count"] < 800).sum()) if not df.empty else 0,
        "missing_canonical": int((df["canonical"]=="").sum()) if not df.empty else 0,
        "noindex_count": int((df["robots_noindex"]==True).sum()) if not df.empty else 0,
        "missing_faq_candidates": int(sum("FAQPage" not in (t or "") for t in df["ld_types"])) if not df.empty else 0
    }
    with open(os.path.join(out_dir,"summary.json"), "w", encoding="utf-8") as f:
        json.dump(summary, f, indent=2)

    # Prioritized across site
    todo = df.copy()
    todo["priority"] = (
        (todo["score_total"] < 0.7).astype(int)*3 +
        (todo["word_count"] < 800).astype(int)*2 +
        (todo["meta_desc_len"]==0).astype(int) +
        (todo["canonical"]=="").astype(int) +
        (todo["page_position"]<=5).astype(int)  # high-leverage pages
    )
    todo = todo.sort_values(["priority","page_position","score_total"], ascending=[False, True, True])

    md = ["# SERP Intelligence — Recommendations\n"]
    for _,r in todo.iterrows():
        md.append(f"## {r['url']}\n- Primary: **{r['primary_kw']}**\n- Avg pos: **{r['page_position']}** | CTR: **{r['page_ctr']:.2f}%** | Words: **{int(r['word_count'])}**\n- Score: **{r['score_total']}** ({r['score_title']}/{r['score_desc']}/{r['score_headings']}/{r['score_depth']}/{r['score_schema']})\n- Issues: {r['recommendations'] or '—'}\n")
    with open(os.path.join(out_dir,"recommendations.md"), "w", encoding="utf-8") as f:
        f.write("\n".join(md))

def cli():
    ap = argparse.ArgumentParser(description="SERP Intelligence scan from GSC exports")
    ap.add_argument("--data-dir", default=".", help="Directory containing Queries.csv, Pages.csv, Countries.csv")
    ap.add_argument("--out-dir", default="out", help="Directory to write outputs")
    args = ap.parse_args()
    ensure_dir(args.out_dir)
    build(args.data_dir, args.out_dir)

if __name__ == "__main__":
    cli()


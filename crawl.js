const fs = require("fs");
const path = require("path");
const { chromium } = require("playwright");
const cheerio = require("cheerio");
const TurndownService = require("turndown");

const INPUT_MD = path.join(process.cwd(), "docs/AI_SERVICES_LINKS.md");

const OUT_DIR = path.join(process.cwd(), "crawl-out");
const RAW_DIR = path.join(OUT_DIR, "raw-html");
const LINE_DIR = path.join(OUT_DIR, "line-html");
const JSON_DIR = path.join(OUT_DIR, "page-json");

for (const p of [OUT_DIR, RAW_DIR, LINE_DIR, JSON_DIR]) fs.mkdirSync(p, { recursive: true });

function extractUrls(md) {
  const re = /https?:\/\/[^\s)>\]]+/g;
  const urls = (md.match(re) || []).map(u => u.replace(/[`'",.>\]]+$/g, ""));
  // unique, preserve order
  return [...new Set(urls)];
}

function slugify(url) {
  return url
    .replace(/^https?:\/\//, "")
    .replace(/\/+$/, "")
    .replace(/[^\w]+/g, "-")
    .replace(/-+/g, "-")
    .replace(/^-|-$/g, "")
    .slice(0, 180) || "root";
}

function lineNumberHtml(html) {
  const lines = html.split(/\r?\n/);
  return lines.map((l, i) => `${String(i + 1).padStart(5, "0")}: ${l}`).join("\n");
}

function safeText(s) {
  return (s || "").replace(/\s+/g, " ").trim();
}

function pickMeta($, nameOrProp) {
  // try name=, then property=
  const byName = $(`meta[name="${nameOrProp}"]`).attr("content");
  if (byName) return safeText(byName);
  const byProp = $(`meta[property="${nameOrProp}"]`).attr("content");
  if (byProp) return safeText(byProp);
  return "";
}

function parseJsonLd($) {
  const blocks = [];
  $('script[type="application/ld+json"]').each((_, el) => {
    const raw = $(el).contents().text() || "";
    const trimmed = raw.trim();
    if (!trimmed) return;
    try {
      const parsed = JSON.parse(trimmed);
      blocks.push(parsed);
    } catch (e) {
      blocks.push({ _parse_error: String(e), _raw: trimmed.slice(0, 2000) });
    }
  });
  return blocks;
}

function headingOutline($) {
  const out = [];
  ["h1","h2","h3","h4"].forEach(tag => {
    $(tag).each((_, el) => {
      const t = safeText($(el).text());
      if (t) out.push({ tag, text: t });
    });
  });
  return out;
}

function internalLinks($, originHost) {
  const links = [];
  $("a[href]").each((_, el) => {
    const href = ($(el).attr("href") || "").trim();
    if (!href) return;
    // normalize
    if (href.startsWith("#")) return;
    if (href.startsWith("mailto:") || href.startsWith("tel:")) return;

    let abs = href;
    try {
      abs = new URL(href, `https://${originHost}`).toString();
    } catch {}
    try {
      const u = new URL(abs);
      if (u.host === originHost) links.push(u.toString());
    } catch {}
  });
  return [...new Set(links)];
}

function detectIssues(data) {
  const issues = [];

  // status
  if (data.status !== 200) issues.push(`HTTP status ${data.status}`);

  // title/meta
  if (!data.title) issues.push("Missing <title>");
  if (!data.meta.description) issues.push("Missing meta description");

  // H1
  const h1s = data.headings.filter(h => h.tag === "h1");
  if (h1s.length === 0) issues.push("Missing H1");
  if (h1s.length > 1) issues.push(`Multiple H1 (${h1s.length})`);

  // canonicals
  if (!data.canonical) issues.push("Missing canonical link tag");

  // schema presence (not "required" everywhere, but you asked for structure)
  if (!data.jsonld || data.jsonld.length === 0) issues.push("No JSON-LD detected");

  // thin page heuristic
  if ((data.textLength || 0) < 1200) issues.push(`Likely thin content (textLength=${data.textLength})`);

  return issues;
}

(async () => {
  if (!fs.existsSync(INPUT_MD)) {
    console.error(`Missing input: ${INPUT_MD}`);
    process.exit(1);
  }

  const md = fs.readFileSync(INPUT_MD, "utf8");
  const urls = extractUrls(md);
  if (urls.length === 0) {
    console.error("No URLs found in AI_SERVICES_LINKS.md");
    process.exit(1);
  }

  console.log(`Found ${urls.length} URLs to crawl`);

  const browser = await chromium.launch({ headless: true });
  const context = await browser.newContext({
    userAgent: "NRLC-Crawler/1.0 (+structure-audit)",
    locale: "en-US"
  });

  const page = await context.newPage();

  const turndown = new TurndownService({ headingStyle: "atx" });

  const rollup = {
    crawledAt: new Date().toISOString(),
    urlCount: urls.length,
    pages: [],
    failures: []
  };

  for (let i = 0; i < urls.length; i++) {
    const url = urls[i];
    const slug = slugify(url);

    console.log(`[${i+1}/${urls.length}] ${url}`);

    const pageData = {
      url,
      slug,
      status: null,
      finalUrl: null,
      title: "",
      canonical: "",
      meta: {
        description: "",
        robots: "",
        ogTitle: "",
        ogDescription: "",
        ogUrl: ""
      },
      headings: [],
      jsonld: [],
      internalLinks: [],
      textLength: 0,
      wordCount: 0,
      structureMarkdown: "",
      issues: [],
      timingsMs: null
    };

    const start = Date.now();
    try {
      const resp = await page.goto(url, { waitUntil: "domcontentloaded", timeout: 60000 });
      pageData.status = resp ? resp.status() : null;
      pageData.finalUrl = page.url();

      // Let client-side rendering settle a bit if needed
      await page.waitForTimeout(800);

      const html = await page.content();
      const rawPath = path.join(RAW_DIR, `${slug}.html`);
      fs.writeFileSync(rawPath, html, "utf8");

      const lined = lineNumberHtml(html);
      const linePath = path.join(LINE_DIR, `${slug}.lines.html`);
      fs.writeFileSync(linePath, lined, "utf8");

      const $ = cheerio.load(html);

      pageData.title = safeText($("title").first().text());
      pageData.canonical = ($('link[rel="canonical"]').attr("href") || "").trim();

      pageData.meta.description = pickMeta($, "description");
      pageData.meta.robots = pickMeta($, "robots");
      pageData.meta.ogTitle = pickMeta($, "og:title");
      pageData.meta.ogDescription = pickMeta($, "og:description");
      pageData.meta.ogUrl = pickMeta($, "og:url");

      pageData.headings = headingOutline($);
      pageData.jsonld = parseJsonLd($);

      let host = "";
      try { host = new URL(pageData.finalUrl || url).host; } catch {}
      pageData.internalLinks = host ? internalLinks($, host) : [];

      const bodyText = safeText($("body").text());
      pageData.textLength = bodyText.length;
      pageData.wordCount = bodyText ? bodyText.split(" ").filter(Boolean).length : 0;

      // Build a structure markdown section that is "line by line" friendly:
      // - Headings outline
      // - Canonical/meta summary
      // - JSON-LD types present
      // - Internal link count
      const jsonldTypes = [];
      for (const b of pageData.jsonld) {
        if (!b) continue;
        if (Array.isArray(b)) {
          b.forEach(x => x && x["@type"] && jsonldTypes.push(x["@type"]));
        } else {
          if (b["@type"]) jsonldTypes.push(b["@type"]);
          // handle @graph
          if (b["@graph"] && Array.isArray(b["@graph"])) {
            b["@graph"].forEach(x => x && x["@type"] && jsonldTypes.push(x["@type"]));
          }
        }
      }

      const uniqTypes = [...new Set(jsonldTypes.map(String))];

      const outlineLines = pageData.headings.map(h => `${h.tag.toUpperCase()}: ${h.text}`).join("\n");
      pageData.structureMarkdown = [
        `## ${url}`,
        ``,
        `Final URL: ${pageData.finalUrl || ""}`,
        `HTTP: ${pageData.status}`,
        ``,
        `Title: ${pageData.title || "(missing)"}`,
        `Meta description: ${pageData.meta.description || "(missing)"}`,
        `Meta robots: ${pageData.meta.robots || "(missing)"}`,
        `Canonical: ${pageData.canonical || "(missing)"}`,
        ``,
        `JSON-LD types: ${uniqTypes.length ? uniqTypes.join(", ") : "(none detected)"}`,
        `Internal links (same host): ${pageData.internalLinks.length}`,
        ``,
        `### Heading outline`,
        outlineLines || "(no headings detected)",
        ``,
        `### Files`,
        `Raw HTML: crawl-out/raw-html/${slug}.html`,
        `Line-numbered HTML: crawl-out/line-html/${slug}.lines.html`,
        `Structured JSON: crawl-out/page-json/${slug}.json`,
        ``
      ].join("\n");

      pageData.issues = detectIssues(pageData);
      pageData.timingsMs = Date.now() - start;

      const jsonPath = path.join(JSON_DIR, `${slug}.json`);
      fs.writeFileSync(jsonPath, JSON.stringify(pageData, null, 2), "utf8");

      rollup.pages.push(pageData);
    } catch (e) {
      pageData.timingsMs = Date.now() - start;
      rollup.failures.push({
        url,
        slug,
        error: String(e)
      });
      console.error(`  FAIL: ${url} -> ${String(e)}`);
    }
  }

  await browser.close();

  // Build REPORT.md
  const issueIndex = {};
  for (const p of rollup.pages) {
    for (const iss of (p.issues || [])) {
      issueIndex[iss] = issueIndex[iss] || [];
      issueIndex[iss].push(p.url);
    }
  }

  const reportMd = [];
  reportMd.push(`# NRLC Crawl Report`);
  reportMd.push(`Crawled at: ${rollup.crawledAt}`);
  reportMd.push(`URLs found: ${rollup.urlCount}`);
  reportMd.push(`Pages crawled: ${rollup.pages.length}`);
  reportMd.push(`Failures: ${rollup.failures.length}`);
  reportMd.push(``);

  reportMd.push(`## Issue Summary`);
  const issueKeys = Object.keys(issueIndex).sort((a,b) => issueIndex[b].length - issueIndex[a].length);
  if (issueKeys.length === 0) {
    reportMd.push(`No issues detected by current heuristics.`);
  } else {
    for (const k of issueKeys) {
      reportMd.push(`- ${k} (${issueIndex[k].length})`);
    }
  }
  reportMd.push(``);

  if (rollup.failures.length) {
    reportMd.push(`## Failures`);
    for (const f of rollup.failures) reportMd.push(`- ${f.url} :: ${f.error}`);
    reportMd.push(``);
  }

  reportMd.push(`## Per-Page Structure`);
  for (const p of rollup.pages) {
    reportMd.push(p.structureMarkdown);
    if (p.issues && p.issues.length) {
      reportMd.push(`### Detected issues`);
      for (const iss of p.issues) reportMd.push(`- ${iss}`);
      reportMd.push(``);
    }
    reportMd.push(`---`);
    reportMd.push(``);
  }

  fs.writeFileSync(path.join(OUT_DIR, "REPORT.md"), reportMd.join("\n"), "utf8");
  fs.writeFileSync(path.join(OUT_DIR, "REPORT.json"), JSON.stringify(rollup, null, 2), "utf8");

  console.log(`\nDone.`);
  console.log(`- ${path.join(OUT_DIR, "REPORT.md")}`);
  console.log(`- ${path.join(OUT_DIR, "REPORT.json")}`);
})();


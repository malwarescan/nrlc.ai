#!/usr/bin/env node
/**
 * insights_lint_and_fix.js
 * Usage:
 *   node scripts/insights_lint_and_fix.js --root ./pages/insights --fix
 *   node scripts/insights_lint_and_fix.js --root ./pages/insights --check
 *
 * Notes:
 * - Safe auto-fix: removes inline styles from headings only.
 * - Fake table conversion is not safe to auto-fix; we flag it.
 */

const fs = require("fs");
const path = require("path");

const args = process.argv.slice(2);
const ROOT = getArg("--root") || process.cwd();
const DO_FIX = args.includes("--fix");
const DO_CHECK = args.includes("--check") || !DO_FIX;

const REQUIRED_H2 = [
  "Definition",
  "Mechanism",
  "Operational Implications",
  "Checklist",
  "Failure Modes",
  "FAQ"
];

const TARGET_EXT = new Set([".php", ".html", ".htm"]);

let violations = [];

walk(ROOT).forEach((file) => {
  const ext = path.extname(file).toLowerCase();
  if (!TARGET_EXT.has(ext)) return;

  let src = fs.readFileSync(file, "utf8");
  const original = src;

  // 1) Remove inline styles from headings only
  const headingStyleRegex = /(<h[1-6]\b[^>]*?)\sstyle="[^"]*"\s*([^>]*>)/gi;
  let headingStyleCount = 0;
  src = src.replace(headingStyleRegex, (m, a, b) => {
    headingStyleCount++;
    return `${a} ${b}`.replace(/\s+/g, " ");
  });

  if (headingStyleCount > 0) {
    if (DO_FIX) {
      logFix(file, `Removed ${headingStyleCount} inline heading style attribute(s)`);
    } else {
      violations.push({
        file,
        type: "INLINE_STYLE_IN_HEADING",
        detail: `Found ${headingStyleCount} inline style attribute(s) in headings`
      });
    }
  }

  // 2) Flag fake tables (not auto-fix)
  const fakeTableRegex = /<div[^>]*class="[^"]*(table|row|col)[^"]*"[^>]*>/gi;
  const fakeTables = (src.match(fakeTableRegex) || []).length;
  if (fakeTables > 0) {
    violations.push({
      file,
      type: "FAKE_TABLE_DETECTED",
      detail: `Found ${fakeTables} div-based table-like element(s). Convert to real <table>.`
    });
  }

  // 3) Check H1 count
  const h1Count = (src.match(/<h1\b/gi) || []).length;
  if (h1Count !== 1) {
    violations.push({
      file,
      type: "H1_COUNT",
      detail: `Expected exactly 1 <h1>, found ${h1Count}`
    });
  }

  // 4) Check required H2 section presence by heading text (best-effort)
  // We match common formats: "Definition:", "Definition -", etc.
  const h2Texts = extractHeadingTexts(src, 2).map(normalizeHeading);
  const missing = REQUIRED_H2.filter((req) => {
    const n = normalizeHeading(req);
    return !h2Texts.some((t) => t.startsWith(n));
  });

  if (missing.length > 0) {
    violations.push({
      file,
      type: "MISSING_REQUIRED_H2",
      detail: `Missing H2 sections: ${missing.join(", ")}`
    });

    // Optional placeholder inject is intentionally off by default
    // because content injection must be done intentionally.
  }

  // Write back if changed and in fix mode
  if (DO_FIX && src !== original) {
    fs.writeFileSync(file, src, "utf8");
  }
});

if (DO_CHECK && violations.length > 0) {
  console.error("\nINSIGHTS LINT FAILED\n");
  for (const v of violations) {
    console.error(`- ${v.type}: ${v.file}\n  ${v.detail}`);
  }
  console.error(`\nTotal violations: ${violations.length}\n`);
  process.exit(1);
}

console.log("INSIGHTS LINT PASSED");
process.exit(0);

// Helpers

function getArg(name) {
  const idx = args.indexOf(name);
  if (idx === -1) return null;
  return args[idx + 1] || null;
}

function walk(dir) {
  let out = [];
  for (const entry of fs.readdirSync(dir, { withFileTypes: true })) {
    const p = path.join(dir, entry.name);
    if (entry.isDirectory()) out = out.concat(walk(p));
    else out.push(p);
  }
  return out;
}

function extractHeadingTexts(html, level) {
  const re = new RegExp(`<h${level}\\b[^>]*>([\\s\\S]*?)<\\/h${level}>`, "gi");
  let m;
  const texts = [];
  while ((m = re.exec(html)) !== null) {
    const inner = stripTags(m[1]).trim();
    if (inner) texts.push(inner);
  }
  return texts;
}

function stripTags(s) {
  return s
    .replace(/<script[\s\S]*?<\/script>/gi, "")
    .replace(/<style[\s\S]*?<\/style>/gi, "")
    .replace(/<\/?[^>]+>/g, " ")
    .replace(/\s+/g, " ")
    .trim();
}

function normalizeHeading(s) {
  return s
    .toLowerCase()
    .replace(/[\u2013\u2014:-]/g, " ")
    .replace(/\s+/g, " ")
    .trim();
}

function logFix(file, msg) {
  console.log(`[FIX] ${file}: ${msg}`);
}


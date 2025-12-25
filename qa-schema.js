import fetch from "node-fetch";
import { JSDOM } from "jsdom";

const COURSE_ID =
  "https://nrlc.ai/en-us/docs/prechunking-seo/course/#course";

const COURSE_HUB =
  "http://localhost:8000/en-us/docs/prechunking-seo/course/";

const MODULE_URLS = [
  "http://localhost:8000/en-us/docs/prechunking-seo/course/how-llms-chunk-content/",
  "http://localhost:8000/en-us/docs/prechunking-seo/course/chunk-atomicity-inference-cost/",
  "http://localhost:8000/en-us/docs/prechunking-seo/course/vectorization-semantic-collisions/",
  "http://localhost:8000/en-us/docs/prechunking-seo/course/data-structuring-beyond-pages/",
  "http://localhost:8000/en-us/docs/prechunking-seo/course/cross-page-consistency/",
  "http://localhost:8000/en-us/docs/prechunking-seo/course/prompt-reverse-engineering/",
  "http://localhost:8000/en-us/docs/prechunking-seo/course/citation-eligibility-engineering/",
  "http://localhost:8000/en-us/docs/prechunking-seo/course/measuring-prechunking-success/",
  "http://localhost:8000/en-us/docs/prechunking-seo/course/failure-modes-why-chunks-die/"
];

const FORBIDDEN_TYPES = [
  "Product",
  "Offer",
  "AggregateRating",
  "Review",
  "HowTo",
  "EducationalOccupationalProgram"
];

async function extractJSONLD(url) {
  const res = await fetch(url);
  if (!res.ok) throw new Error(`HTTP ${res.status}: ${url}`);
  const html = await res.text();
  const dom = new JSDOM(html);
  const scripts = [...dom.window.document.querySelectorAll(
    'script[type="application/ld+json"]'
  )];

  if (!scripts.length) {
    throw new Error(`NO JSON-LD FOUND: ${url}`);
  }

  return scripts.flatMap(s => {
    try {
      const parsed = JSON.parse(s.textContent);
      return Array.isArray(parsed) ? parsed : [parsed];
    } catch (e) {
      throw new Error(`INVALID JSON-LD: ${url} - ${e.message}`);
    }
  });
}

function assert(condition, message) {
  if (!condition) throw new Error(message);
}

function hasType(data, type) {
  return data.some(d => d["@type"] === type);
}

function findType(data, type) {
  return data.find(d => d["@type"] === type);
}

function ensureForbiddenAbsent(data, url) {
  FORBIDDEN_TYPES.forEach(type => {
    if (hasType(data, type)) {
      throw new Error(`FORBIDDEN SCHEMA FOUND: ${type} on ${url}`);
    }
  });
}

async function qaCourseHub() {
  console.log("\n✅ QA: COURSE HUB");
  console.log(`   URL: ${COURSE_HUB}`);
  const data = await extractJSONLD(COURSE_HUB);

  ensureForbiddenAbsent(data, COURSE_HUB);

  assert(hasType(data, "Course"), "MISSING Course schema");
  assert(hasType(data, "LearningResource"), "MISSING LearningResource");
  assert(hasType(data, "WebPage"), "MISSING WebPage");
  assert(hasType(data, "BreadcrumbList"), "MISSING BreadcrumbList");

  const course = findType(data, "Course");

  assert(course["@id"] === COURSE_ID, `Course @id mismatch. Expected: ${COURSE_ID}, Got: ${course["@id"]}`);
  assert(course.teaches?.length, "Course.teaches missing or empty");
  assert(!course.offers, "Course must NOT include offers");
  assert(course.educationalLevel === "Advanced", "Course.educationalLevel must be Advanced");

  const learningResource = findType(data, "LearningResource");
  assert(learningResource, "LearningResource schema not found");
  assert(learningResource.learningResourceType === "Course", "LearningResource.learningResourceType must be Course");

  console.log("   ✅ PASS: Course hub schema valid");
}

async function qaModule(url) {
  const moduleName = url.split('/').slice(-2, -1)[0];
  console.log(`\n✅ QA: MODULE → ${moduleName}`);
  console.log(`   URL: ${url}`);
  const data = await extractJSONLD(url);

  ensureForbiddenAbsent(data, url);

  assert(hasType(data, "TechArticle"), "MISSING TechArticle");
  assert(hasType(data, "BreadcrumbList"), "MISSING BreadcrumbList");

  const article = findType(data, "TechArticle");

  assert(
    article.isPartOf?.["@id"] === COURSE_ID || article.isPartOf?.["@type"] === "Course",
    `TechArticle.isPartOf does not reference Course. Expected @id: ${COURSE_ID}, Got: ${JSON.stringify(article.isPartOf)}`
  );

  // Check if isPartOf has @id that matches COURSE_ID
  if (article.isPartOf?.["@id"]) {
    assert(
      article.isPartOf["@id"] === COURSE_ID,
      `TechArticle.isPartOf.@id mismatch. Expected: ${COURSE_ID}, Got: ${article.isPartOf["@id"]}`
    );
  }

  assert(
    article.proficiencyLevel === "Advanced",
    `proficiencyLevel must be Advanced. Got: ${article.proficiencyLevel}`
  );

  assert(article.about?.length, "TechArticle.about missing or empty");
  assert(article.headline, "TechArticle.headline missing");
  assert(article.description, "TechArticle.description missing");

  const author = article.author;
  assert(author, "TechArticle.author missing");
  assert(author["@type"] === "Organization", "TechArticle.author must be Organization");

  console.log(`   ✅ PASS: Module schema valid`);
}

async function run() {
  console.log("=".repeat(60));
  console.log("PRECHUNKING SEO COURSE — SCHEMA VALIDATION");
  console.log("=".repeat(60));
  
  try {
    await qaCourseHub();

    for (const url of MODULE_URLS) {
      await qaModule(url);
    }

    console.log("\n" + "=".repeat(60));
    console.log("✅ SCHEMA QA PASSED — NO REGRESSIONS");
    console.log("=".repeat(60));
    console.log(`\nValidated:`);
    console.log(`  • Course Hub: 1 page`);
    console.log(`  • Module Pages: ${MODULE_URLS.length} pages`);
    console.log(`  • Total Schemas Checked: ${MODULE_URLS.length + 1} pages`);
    console.log(`\nAll schema types are correct and forbidden types are absent.`);
  } catch (err) {
    console.error("\n" + "=".repeat(60));
    console.error("❌ SCHEMA QA FAILED");
    console.error("=".repeat(60));
    console.error(`\nError: ${err.message}`);
    console.error(`\nStack trace:`);
    console.error(err.stack);
    process.exit(1);
  }
}

run();


<?php declare(strict_types=1);
require __DIR__ . '/../bootstrap.php';

$options = getopt('', ['base:', 'max::']);
$base = $options['base'] ?? '';
$max = isset($options['max']) ? (int)$options['max'] : 300;

if (!$base || !preg_match('~^https?://~i', $base)) {
  fwrite(STDERR, "Usage: php scripts/discover.php --base=https://yourdomain.tld [--max=300]\n");
  exit(1);
}
@mkdir(__DIR__.'/../output', 0775, true);

echo "Starting discovery of {$base}...\n";

$disc = new Discover($base, $max);
$rows = $disc->crawl();

echo "Crawled ".count($rows)." pages.\n";

// Aggregate facts
$locales = [];
$canonicals = 0;
$orgName = '';
$orgLogo = '';
$orgUrl = '';
$sameAs = [];
$publisherName = '';
$publisherLogo = '';
$jsonldTypes = [];
$images = [];

foreach ($rows as $r) {
  if ($r['canonical']) $canonicals++;
  if ($r['locale_guess']) $locales[$r['locale_guess']] = true;
  if ($r['org_name'] && !$orgName) $orgName = $r['org_name'];
  if ($r['org_logo'] && !$orgLogo) $orgLogo = $r['org_logo'];
  if ($r['org_id'] && !$orgUrl) $orgUrl = $r['org_id'];
  foreach ($r['org_sameAs'] as $s) $sameAs[$s] = true;
  if ($r['publisher_name'] && !$publisherName) $publisherName = $r['publisher_name'];
  if ($r['publisher_logo'] && !$publisherLogo) $publisherLogo = $r['publisher_logo'];
  foreach ($r['jsonld_types'] as $t) $jsonldTypes[$t] = true;
  foreach ($r['images'] as $img) $images[$img] = true;
}

// Decide BASE_URL (verified)
$baseUrl = rtrim($base,'/');
$defaultLocale = '';
$localeList = implode(',', array_keys($locales));

// Prepare detected_env.json
$detected = [
  'BASE_URL' => $baseUrl,
  'DEFAULT_LOCALE' => $defaultLocale,           // leave blank: cannot be proven from DOM reliably
  'LOCALES' => $localeList,                    // derived from URL prefixes
  'SITE_NAME' => $publisherName ?: $orgName,   // prefer WebSite.publisher, else Organization.name
  'ORG_LEGAL_NAME' => $orgName,
  'ORG_URL' => $orgUrl ?: $baseUrl,
  'ORG_LOGO' => $orgLogo,
  'ORG_SAME_AS' => array_keys($sameAs),
  'SCHEMA_PUBLISHER_NAME' => $publisherName ?: ($orgName ?: ''),
  'SCHEMA_PUBLISHER_LOGO' => $publisherLogo ?: $orgLogo,
  'SITEMAP_CANDIDATES' => \Sitemap::discover($baseUrl),
  'ROBOTS_PRESENT' => (function($u){ $r = Http::get(rtrim($u,'/').'/robots.txt'); return $r['code']===200; })($baseUrl),
  'JSONLD_TYPES' => array_keys($jsonldTypes),
  'CANONICAL_TAGS_FOUND' => $canonicals,
  'CRAWLED_URLS' => count($rows),
];

// Write JSON
file_put_contents(__DIR__.'/../output/detected_env.json', Json::pretty($detected));

// Write .env.suggested with comments where unknown
$envLines = [];
$envLines[] = 'APP_ENV=production';
$envLines[] = 'BASE_URL='.$detected['BASE_URL'];
$envLines[] = 'DEFAULT_LOCALE=' . ($detected['DEFAULT_LOCALE'] ?: ''); // leave blank; user must confirm
$envLines[] = 'LOCALES=' . $detected['LOCALES'];
$envLines[] = 'SITE_NAME=' . ($detected['SITE_NAME'] ?? '');
$envLines[] = 'ORG_LEGAL_NAME=' . ($detected['ORG_LEGAL_NAME'] ?? '');
$envLines[] = 'ORG_URL=' . ($detected['ORG_URL'] ?? '');
$envLines[] = 'ORG_LOGO=' . ($detected['ORG_LOGO'] ?? '');
$envLines[] = 'ORG_SAME_AS=' . implode('|', $detected['ORG_SAME_AS'] ?? []);
$envLines[] = 'SCHEMA_PUBLISHER_NAME=' . ($detected['SCHEMA_PUBLISHER_NAME'] ?? '');
$envLines[] = 'SCHEMA_PUBLISHER_LOGO=' . ($detected['SCHEMA_PUBLISHER_LOGO'] ?? '');
$envLines[] = 'SITEMAP_BASE='; // left blank intentionally: needs server path, not URL
$envLines[] = 'ROBOTS_HOST=' . parse_url($detected['BASE_URL'], PHP_URL_HOST);

$envOut = implode("\n", $envLines) . "\n";
file_put_contents(__DIR__.'/../output/.env.suggested', $envOut);

// Write audit_report.csv
$csv = fopen(__DIR__.'/../output/audit_report.csv', 'w');
fputcsv($csv, ['URL','Status','Title','MetaDescription','Canonical','HreflangCount','JSONLD_Types','LocaleGuess','OrgName','OrgLogo','PublisherName','PublisherLogo'], ',', '"', '');
foreach ($rows as $r) {
  fputcsv($csv, [
    $r['url'], $r['status'], $r['title'], $r['meta_description'],
    $r['canonical'], count($r['hreflang']), implode('|',$r['jsonld_types']),
    $r['locale_guess'], $r['org_name'], $r['org_logo'], $r['publisher_name'], $r['publisher_logo']
  ], ',', '"', '');
}
fclose($csv);

echo "Discovery complete.\n";
echo " - output/detected_env.json\n";
echo " - output/.env.suggested\n";
echo " - output/audit_report.csv\n";


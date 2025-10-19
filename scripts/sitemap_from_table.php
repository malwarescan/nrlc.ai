<?php
declare(strict_types=1);
/**
 * Builds two shards from ./Table.csv or ./data/Table.csv:
 *   - sitemap-services.xml (priority 0.9)
 *   - sitemap-insights.xml (priority 0.8)
 * And an index sitemap.xml referencing both.
 * Usage: php scripts/sitemap_from_table.php 2025-10-18 https://nrlc.ai
 */
$lastmod = $argv[1] ?? date('Y-m-d');
$base    = rtrim($argv[2] ?? (getenv('BASE_ORIGIN') ?: 'https://nrlc.ai'),'/');

$csv = is_file('./Table.csv') ? './Table.csv' : (is_file('./data/Table.csv') ? './data/Table.csv' : '');
if ($csv==='') { fwrite(STDERR, "Missing Table.csv (./Table.csv or ./data/Table.csv)\n"); exit(1); }

$fh = fopen($csv,'r'); $hdr=fgetcsv($fh, 0, ',', '"', '\\'); if(!$hdr){fwrite(STDERR,"Empty Table.csv\n");exit(1);} $map=array_flip(array_map('trim',$hdr));
if (!isset($map['URL'])) { fwrite(STDERR,"Table.csv must have URL column\n"); exit(1); }

$services=[]; $insights=[];
while(($r=fgetcsv($fh, 0, ',', '"', '\\'))!==false){
  $u = trim($r[$map['URL']] ?? ''); if($u==='') continue;
  $path = parse_url($u, PHP_URL_PATH) ?? '';
  if (preg_match('#^/services/#i',$path)) $services[$u]=true;
  elseif (preg_match('#^/insights/#i',$path)) $insights[$u]=true;
}
fclose($fh);

$outDir = __DIR__.'/../public'; if(!is_dir($outDir)) @mkdir($outDir,0775,true);
function xh(){return '<?xml version="1.0" encoding="UTF-8"?>' . "\n";}
function open_set(){return '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";}
function close_set(){return "</urlset>\n";}
function write_set($path,$urls,$lastmod,$prio){$xml=xh().open_set();foreach(array_keys($urls) as $u){$xml.="  <url>\n    <loc>".htmlspecialchars($u,ENT_XML1)."</loc>\n    <lastmod>$lastmod</lastmod>\n    <changefreq>weekly</changefreq>\n    <priority>$prio</priority>\n  </url>\n";} $xml.=close_set(); file_put_contents($path,$xml);} 

write_set($outDir.'/sitemap-services.xml',$services,$lastmod,'0.9');
write_set($outDir.'/sitemap-insights.xml',$insights,$lastmod,'0.8');

$index = xh().'<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
foreach (['sitemap-services.xml','sitemap-insights.xml'] as $f) {
  $index .= "  <sitemap>\n    <loc>$base/$f</loc>\n    <lastmod>$lastmod</lastmod>\n  </sitemap>\n";
}
$index .= "</sitemapindex>\n";
file_put_contents($outDir.'/sitemap.xml', $index);
echo "Wrote public/sitemap.xml + shards (services, insights)\n";



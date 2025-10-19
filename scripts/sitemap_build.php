<?php
declare(strict_types=1);
/**
 * Sitemap Builder (index + posts + pages) from ./data/Table.csv
 * Usage: php scripts/sitemap_build.php ./data/Table.csv 2025-10-18 https://example.com
 */
if (php_sapi_name()!=='cli'){fwrite(STDERR,"CLI only\n");exit(1);} 
$csv     = $argv[1] ?? './data/Table.csv';
$lastmod = $argv[2] ?? date('Y-m-d');
$base    = rtrim($argv[3] ?? (getenv('BASE_ORIGIN') ?: 'https://example.com'),'/');

if (!is_file($csv)){fwrite(STDERR,"CSV not found: $csv\n");exit(1);} 

function is_post(string $url): bool {
  return (bool)preg_match('#/(blog|articles?|research|insights|news)/#i', parse_url($url, PHP_URL_PATH) ?? '');
}

$urls=[]; if(($fh=fopen($csv,'r'))!==false){$hdr=fgetcsv($fh, 0, ',', '"', '\\');$map=array_flip(array_map('trim',$hdr));
if(!isset($map['URL']) && isset($map['Url'])) $map['URL']=$map['Url'];
if(!isset($map['URL'])){fwrite(STDERR,"CSV must have URL column\n");exit(1);} 
while(($r=fgetcsv($fh, 0, ',', '"', '\\'))!==false){$u=trim($r[$map['URL']]??'');if($u!=='')$urls[$u]=true;} fclose($fh);} 
$posts=[];$pages=[];foreach(array_keys($urls) as $u)(is_post($u)?$posts[]=$u:$pages[]=$u);

$outDir=__DIR__.'/../public'; if(!is_dir($outDir))@mkdir($outDir,0775,true);
function xh(){return '<?xml version="1.0" encoding="UTF-8"?>' . "\n";}
function open_urlset(){return '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";}
function close_urlset(){return "</urlset>\n";}
function write_set($path,$list,$lastmod){$xml=xh().open_urlset();foreach($list as $u){$xml.="  <url>\n    <loc>".htmlspecialchars($u,ENT_XML1)."</loc>\n    <lastmod>$lastmod</lastmod>\n    <changefreq>weekly</changefreq>\n    <priority>".(is_post($u)?'0.9':'0.7')."</priority>\n  </url>\n";}$xml.=close_urlset();file_put_contents($path,$xml);} 

write_set($outDir.'/sitemap-posts.xml',$posts,$lastmod);
write_set($outDir.'/sitemap-pages.xml',$pages,$lastmod);

$index = xh().'<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
foreach (['sitemap-posts.xml','sitemap-pages.xml'] as $f) {
  $index.="  <sitemap>\n    <loc>$base/$f</loc>\n    <lastmod>$lastmod</lastmod>\n  </sitemap>\n";
}
$index.="</sitemapindex>\n";
file_put_contents($outDir.'/sitemap.xml',$index);
echo "Wrote: public/sitemap.xml, sitemap-posts.xml, sitemap-pages.xml\n";



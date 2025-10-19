<?php
declare(strict_types=1);
/**
 * Optional News sitemap from ./data/News.csv (URL,Title,PubDate,Section?)
 * Only includes items within last 48 hours.
 * Usage: php scripts/sitemap_news.php ./data/News.csv https://example.com
 */
if (php_sapi_name()!=='cli'){fwrite(STDERR,"CLI only\n");exit(1);} 
$csv  = $argv[1] ?? './data/News.csv';
$base = rtrim($argv[2] ?? (getenv('BASE_ORIGIN') ?: 'https://example.com'),'/');
if(!is_file($csv)){echo "No News.csv; skipping\n";exit(0);} 
$rows=[]; if(($fh=fopen($csv,'r'))!==false){$hdr=fgetcsv($fh, 0, ',', '"', '\\');$map=array_flip(array_map('trim',$hdr));$req=['URL','Title','PubDate'];foreach($req as $k)if(!isset($map[$k])){fwrite(STDERR,"News.csv missing $k\n");exit(1);}while(($r=fgetcsv($fh, 0, ',', '"', '\\'))!==false){$u=trim($r[$map['URL']]??'');$t=trim($r[$map['Title']]??'');$d=trim($r[$map['PubDate']]??'');$s=isset($map['Section'])?trim($r[$map['Section']]??''):'';$age=(time()-strtotime($d))/3600;if($u!==''&&$t!==''&&$d!==''&&$age<=48)$rows[]=['u'=>$u,'t'=>$t,'d'=>$d,'s'=>$s];}fclose($fh);} 
if(!$rows){echo "No recent news (<=48h). Skipping.\n";exit(0);} 
$outDir=__DIR__.'/../public'; if(!is_dir($outDir))@mkdir($outDir,0775,true);
$xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">' . "\n";
foreach($rows as $it){$xml.="  <url>\n    <loc>".htmlspecialchars($it['u'],ENT_XML1)."</loc>\n    <news:news>\n      <news:publication>\n        <news:name>".htmlspecialchars((brand_cfg()['name']??'Brand'),ENT_XML1)."</news:name>\n        <news:language>en</news:language>\n      </news:publication>\n      <news:publication_date>{$it['d']}</news:publication_date>\n      <news:title>".htmlspecialchars($it['t'],ENT_XML1)."</news:title>\n".($it['s']!==''?"      <news:genres>".htmlspecialchars($it['s'],ENT_XML1)."</news:genres>\n":'')."    </news:news>\n  </url>\n";} 
$xml.="</urlset>\n";
file_put_contents($outDir.'/sitemap-news.xml',$xml);
echo "Wrote: public/sitemap-news.xml\n";



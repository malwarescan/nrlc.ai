<?php
declare(strict_types=1);
$csv=__DIR__.'/../data/ai_manifest_seed.csv'; $out=__DIR__.'/../public/sitemaps/sitemap-ai.ndjson';
if(!is_file($csv)){ @mkdir(dirname($csv),0775,true); file_put_contents($csv,"url,name,type,lang,lastmod,keywords\nhttps://nrlc.ai/,NRLC.ai — Home,WebPage,en,".date('Y-m-d').",brand\n"); }
$fp=fopen($csv,'r'); $hdr=fgetcsv($fp); @mkdir(dirname($out),0775,true); $fo=fopen($out,'w');
while(($row=fgetcsv($fp))!==false){ $rec=array_combine($hdr,$row);
  $obj=["@context"=>"https://schema.org","@type"=>$rec['type']?:'WebPage',"url"=>$rec['url'],"name"=>$rec['name'],"inLanguage"=>$rec['lang']?:'en',"dateModified"=>$rec['lastmod']?:date('Y-m-d')];
  if(!empty($rec['keywords'])){ $obj['keywords']=array_values(array_filter(array_map('trim',explode('|',$rec['keywords'])))); }
  fwrite($fo,json_encode($obj,JSON_UNESCAPED_SLASHES)."\n");
} fclose($fp); fclose($fo); echo "WROTE: $out\n";


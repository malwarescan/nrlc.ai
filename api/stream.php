<?php
declare(strict_types=1);
header('Content-Type: application/x-ndjson; charset=utf-8');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('X-Accel-Buffering: no');
@ini_set('output_buffering','off'); @ini_set('zlib.output_compression','0'); @ob_implicit_flush(true); while (ob_get_level()>0) ob_end_flush();
$domain='https://nrlc.ai'; $limit=isset($_GET['limit'])?max(1,min(500,(int)$_GET['limit'])):10;
$rows=[
 ["@context"=>"https://schema.org","@type"=>"WebPage","url"=>$domain."/","name"=>"NRLC.ai — Home","inLanguage"=>"en","dateModified"=>date('Y-m-d')],
 ["@context"=>"https://schema.org","@type"=>"CreativeWork","url"=>$domain."/promptware/","name"=>"Promptware","about"=>["NDJSON","AI manifest","RAG","LLMO"],"dateModified"=>date('Y-m-d')],
 ["@context"=>"https://schema.org","@type"=>"HowTo","url"=>$domain."/promptware/json-stream-seo-ai/","name"=>"JSON Stream + SEO AI","totalTime"=>"PT20M","dateModified"=>date('Y-m-d')],
];
$c=0; foreach($rows as $r){ if($c>=$limit) break; echo json_encode($r,JSON_UNESCAPED_SLASHES)."\n"; $c++; usleep(150000);} exit;

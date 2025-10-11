<?php
// Greps rendered HTML for JSON-LD blocks; for dev verification.
$path = $argv[1] ?? '/';
$host = 'http://localhost'; // adjust for local dev proxy
$url = rtrim($host,'/').$path;

$ctx = stream_context_create(['http'=>['method'=>'GET','header'=>"User-Agent: JSONLD-Check\n"]]);
$html = @file_get_contents($url, false, $ctx);
if ($html === false) { fwrite(STDERR,"Failed to fetch $url\n"); exit(1); }

preg_match_all('#<script type="application/ld\+json">(.*?)</script>#si', $html, $m);
echo "Found ".count($m[1])." JSON-LD blocks at $url\n";


<?php
declare(strict_types=1);
require_once __DIR__.'/../includes/jsonld_auto.php';
ob_start();
jsonld_for_request(['url'=>'https://nrlc.ai/insights/test-post-123/','emitCanonical'=>true]);
$o = (string)ob_get_clean();
if (strpos($o, 'application/ld+json') === false) {
  fwrite(STDERR, "JSON-LD not emitted\n");
  exit(1);
}
echo "✅ JSON-LD emitted OK\n";


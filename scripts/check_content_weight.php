<?php
declare(strict_types=1);
function wc_html(string $html): int {
  $txt = strip_tags(preg_replace('/\s+/', ' ', $html));
  return str_word_count($txt);
}
$paths = array_slice($argv,1);
if (!$paths) { fwrite(STDERR, "Usage: php scripts/check_content_weight.php /services/... [/services/...]\n"); exit(2); }
foreach ($paths as $p) {
  $_SERVER['REQUEST_URI'] = $p;
  ob_start(); include __DIR__.'/../public/index.php'; $html = (string)ob_get_clean();
  $wc = wc_html($html);
  echo "$p -> $wc words\n";
  if ($wc < 900) echo "WARN: content < 900 words\n";
}
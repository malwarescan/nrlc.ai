<?php
declare(strict_types=1);
function wc_html(string $html): int { return str_word_count(strip_tags(preg_replace('/\s+/',' ', $html))); }
$paths = array_slice($argv,1);
if (!$paths) { fwrite(STDERR,"Usage: php scripts/assert_content_weight.php /services/... [/services/...]\n"); exit(2); }
$fail = false;
foreach ($paths as $p) {
  $_SERVER['REQUEST_URI'] = $p;
  ob_start(); include __DIR__.'/../public/index.php'; $html = (string)ob_get_clean();
  $wc = wc_html($html);
  $ok = ($wc >= 900 && $wc <= 1500);
  echo sprintf("%s -> %d words %s\n", $p, $wc, $ok ? "OK" : "OUT_OF_RANGE");
  if (!$ok) $fail = true;
}
exit($fail ? 1 : 0);

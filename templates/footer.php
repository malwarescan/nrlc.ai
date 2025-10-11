<?php
$blocks = $GLOBALS['__jsonld'] ?? [];
foreach ($blocks as $b) {
  echo '<script type="application/ld+json">'.json_encode($b, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE).'</script>'."\n";
}
?>
<footer>
  <p>© <?=date('Y')?> NRLC.ai</p>
</footer>
</body></html>


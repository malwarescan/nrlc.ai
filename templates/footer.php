<?php
$blocks = $GLOBALS['__jsonld'] ?? [];
foreach ($blocks as $b) {
  echo '<script type="application/ld+json">'.json_encode($b, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE).'</script>'."\n";
}
?>
<footer class="footer">
  <small>© <?= date('Y') ?> NRLC.ai — "Agentic SEO / LLM Seeding / Crawl Clarity"</small>
  <br><small>Built with 98.css nostalgia + modern structured data</small>
  <script defer src="<?= asset_url('/assets/js/ripple.min.js') ?>"></script>
  <script defer src="<?= asset_url('/assets/js/app.min.js') ?>"></script>
</footer>
</body></html>


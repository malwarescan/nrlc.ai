<?php
$blocks = $GLOBALS['__jsonld'] ?? [];
foreach ($blocks as $b) {
  echo '<script type="application/ld+json">'.json_encode($b, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE).'</script>'."\n";
}
?>
<footer class="footer">
  <small>© <?= date('Y') ?> NRLC.ai — "Agentic SEO / LLM Seeding / Crawl Clarity"</small>
  <br><small>Built with 98.css nostalgia + modern structured data</small>
  <div class="footer-links">
    <a href="https://nrlcmd.com" target="_blank" rel="noopener">NRL CMD</a>
    <a href="https://neuralcommandllc.com" target="_blank" rel="noopener">Neural Command LLC</a>
    <a href="https://www.crunchbase.com/organization/neural-command" target="_blank" rel="noopener">Crunchbase</a>
    <a href="https://share.google/vAJ5zksUOr1wELBXp" target="_blank" rel="noopener">Google Business</a>
    <a href="https://www.linkedin.com/company/neural-command/" target="_blank" rel="noopener">LinkedIn</a>
  </div>
  <script defer src="<?= asset_url('/assets/js/ripple.min.js') ?>"></script>
  <script defer src="<?= asset_url('/assets/js/app.min.js') ?>"></script>
  <script defer src="<?= asset_url('/assets/js/grid-bg.js') ?>"></script>
</footer>
</body></html>


<?php
declare(strict_types=1);

if (!function_exists('absolute_url')) {
  require_once __DIR__ . '/../../lib/helpers.php';
}

$isUnlocked = (bool)($GLOBALS['__ai_search_bible_unlocked'] ?? false);
?>

<main role="main" class="container">
  <section class="section">
    <div class="section__content">
      <div class="content-block module">
        <div class="content-block__header">
          <h1 class="content-block__title heading-1">AI Search Bible Dataset</h1>
        </div>
        <div class="content-block__body">
          <?php if (!$isUnlocked): ?>
            <p>This dataset is included with AI Search Bible access.</p>
            <p><a href="<?= htmlspecialchars(absolute_url('/ai-search-bible/full/')) ?>">Unlock access on the full AI Search Bible page.</a></p>
          <?php else: ?>
            <p>Bonus dataset access enabled.</p>
            <p>Download packages will be attached here:</p>
            <ul>
              <li>Fan-Out Query Dataset</li>
              <li>Crouton Knowledge Templates</li>
              <li>AI Retrieval Architecture Diagrams</li>
              <li>NDJSON Knowledge Streams</li>
            </ul>
            <p>No files are attached yet. Upload pipeline can be connected in a follow-up task.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>
</main>

<?php
declare(strict_types=1);

function ai_bible_render_tldr_block(array $items): void {
  ?>
  <div class="content-block module" style="background: #f7f9fc; border-left: 4px solid #12355e;">
    <div class="content-block__header">
      <h2 class="content-block__title heading-2">TLDR</h2>
    </div>
    <div class="content-block__body">
      <ul>
        <?php foreach ($items as $item): ?>
          <li><?= htmlspecialchars($item) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
  <?php
}

function ai_bible_render_crouton_block(string $fact, string $context, string $application, string $source): void {
  ?>
  <article class="content-block module" style="border: 1px solid #dce3ef; border-radius: 6px;">
    <div class="content-block__header">
      <h3 class="content-block__title heading-3">Crouton Block</h3>
    </div>
    <div class="content-block__body">
      <p><strong>Fact:</strong> <?= htmlspecialchars($fact) ?></p>
      <p><strong>Context:</strong> <?= htmlspecialchars($context) ?></p>
      <p><strong>Application:</strong> <?= htmlspecialchars($application) ?></p>
      <p><strong>Source:</strong> <?= htmlspecialchars($source) ?></p>
    </div>
  </article>
  <?php
}

function ai_bible_build_faq_schema(string $canonicalUrl, array $faqItems): array {
  return [
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    '@id' => $canonicalUrl . '#faq',
    'mainEntity' => array_map(function ($item) {
      return [
        '@type' => 'Question',
        'name' => $item['question'],
        'acceptedAnswer' => [
          '@type' => 'Answer',
          'text' => $item['answer']
        ]
      ];
    }, $faqItems),
  ];
}

function ai_bible_render_faq_accordion(array $faqItems): void {
  ?>
  <div class="content-block module">
    <div class="content-block__header">
      <h2 class="content-block__title heading-2">FAQ</h2>
    </div>
    <div class="content-block__body">
      <?php foreach ($faqItems as $faq): ?>
        <details style="margin-bottom: var(--spacing-md); border: 1px solid #dce3ef; border-radius: 6px; padding: 0.75rem;">
          <summary class="heading-3" style="cursor: pointer;"><?= htmlspecialchars($faq['question']) ?></summary>
          <p style="margin-top: 0.75rem;"><?= htmlspecialchars($faq['answer']) ?></p>
        </details>
      <?php endforeach; ?>
    </div>
  </div>
  <?php
}

function ai_bible_render_entities_glossary(array $entities): void {
  ?>
  <div class="content-block module">
    <div class="content-block__header">
      <h2 class="content-block__title heading-2">Entities & Glossary</h2>
    </div>
    <div class="content-block__body">
      <?php foreach ($entities as $entity): ?>
        <h3 class="heading-3"><?= htmlspecialchars($entity['term']) ?></h3>
        <p><?= htmlspecialchars($entity['definition']) ?></p>
      <?php endforeach; ?>
    </div>
  </div>
  <?php
}

function ai_bible_render_references(array $references): void {
  ?>
  <div class="content-block module">
    <div class="content-block__header">
      <h2 class="content-block__title heading-2">References</h2>
    </div>
    <div class="content-block__body">
      <ol>
        <?php foreach ($references as $reference): ?>
          <li><?= htmlspecialchars($reference) ?></li>
        <?php endforeach; ?>
      </ol>
    </div>
  </div>
  <?php
}

function ai_bible_render_ndjson_link_area(?string $downloadUrl): void {
  ?>
  <div class="content-block module">
    <div class="content-block__header">
      <h2 class="content-block__title heading-2">Data Export</h2>
    </div>
    <div class="content-block__body">
      <?php if ($downloadUrl): ?>
        <a href="<?= htmlspecialchars($downloadUrl) ?>">Download NDJSON</a>
      <?php else: ?>
        <p>Download NDJSON link will be enabled in a future release.</p>
      <?php endif; ?>
    </div>
  </div>
  <?php
}

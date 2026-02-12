<?php
/**
 * Videos hub — index of all watch pages. Linked from header/nav; each watch page linked here.
 */
require_once __DIR__ . '/../../lib/helpers.php';
require_once __DIR__ . '/../../lib/videos.php';
require_once __DIR__ . '/../../lib/schema_builders.php';

$locale = current_locale();
$canonicalUrl = absolute_url("/{$locale}/videos/");
$domain = 'https://nrlc.ai';

$GLOBALS['__page_slug'] = 'videos/index';
$videos = get_all_videos();

if (!isset($GLOBALS['__page_meta']) || !is_array($GLOBALS['__page_meta'])) {
  $GLOBALS['__page_meta'] = [];
}
$GLOBALS['__page_meta']['canonicalPath'] = "/{$locale}/videos/";
$GLOBALS['__page_meta']['title'] = $GLOBALS['__page_meta']['title'] ?? 'Video guides | AI SEO & Bing AI Citations | NRLC.ai';
$GLOBALS['__page_meta']['description'] = $GLOBALS['__page_meta']['description'] ?? 'Watch walkthroughs on Bing AI Citations, grounding queries, and turning citation data into citeable content. Neural Command video guides for AI search optimization.';

$GLOBALS['__jsonld'] = [
  [
    '@context' => 'https://schema.org',
    '@type' => 'CollectionPage',
    '@id' => $canonicalUrl . '#collection',
    'name' => 'Video guides',
    'description' => 'Walkthroughs and guides for AI SEO, Bing AI Citations, and turning citation data into citeable content.',
    'url' => $canonicalUrl,
    'isPartOf' => ['@id' => $domain . '#website'],
    'inLanguage' => 'en-US',
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
      ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => $domain . '/en-us/'],
      ['@type' => 'ListItem', 'position' => 2, 'name' => 'Videos', 'item' => $canonicalUrl],
    ],
  ],
];
?>

<main role="main" class="container">
  <section class="section">
    <h1 class="content-block__title">Video guides</h1>
    <p class="lead">Walkthroughs on Bing AI Citations, grounding queries, and turning AI Performance data into citeable content.</p>

    <?php if (empty($videos)) : ?>
      <p>No videos yet. Check back soon.</p>
    <?php else : ?>
      <ul class="video-list" style="list-style: none; padding: 0; display: grid; gap: 1.5rem;">
        <?php foreach ($videos as $v) : ?>
        <li class="video-card" style="border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; padding: 0;">
          <a href="<?php echo absolute_url("/{$locale}/videos/{$v['slug']}/"); ?>" style="display: block; text-decoration: none; color: inherit;">
            <?php if (!empty($v['thumbnailUrl'])) : ?>
            <img src="<?php echo htmlspecialchars($v['thumbnailUrl']); ?>" alt="" width="640" height="360" loading="lazy" style="width: 100%; height: auto; display: block;">
            <?php endif; ?>
            <div style="padding: 1rem;">
              <h2 class="content-block__title" style="font-size: 1.15rem; margin: 0 0 0.5rem;"><?php echo htmlspecialchars($v['title']); ?></h2>
              <p style="margin: 0; font-size: 0.95rem; color: var(--text-muted, #555);"><?php echo htmlspecialchars($v['summary'] ?? substr($v['description'] ?? '', 0, 160)); ?></p>
              <?php if (!empty($v['duration']) || !empty($v['uploadDate'])) : ?>
              <p style="margin: 0.5rem 0 0; font-size: 0.85rem; color: var(--text-muted, #666);">
                <?php if (!empty($v['duration'])) echo htmlspecialchars($v['duration']); ?>
                <?php if (!empty($v['duration']) && !empty($v['uploadDate'])) echo ' · '; ?>
                <?php if (!empty($v['uploadDate'])) echo htmlspecialchars($v['uploadDate']); ?>
              </p>
              <?php endif; ?>
            </div>
          </a>
        </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </section>
</main>

<?php
/**
 * Video watch page — one URL per video. Video-first for Google discovery.
 * Expects $GLOBALS['__video'] set by router (from data/videos.json).
 */
require_once __DIR__ . '/../../lib/helpers.php';
require_once __DIR__ . '/../../lib/videos.php';
require_once __DIR__ . '/../../lib/schema_builders.php';

$video = $GLOBALS['__video'] ?? null;
if (!$video) {
  return;
}

$locale = current_locale();
$slug = $video['slug'];
$canonicalUrl = absolute_url("/{$locale}/videos/{$slug}/");
$domain = 'https://nrlc.ai';

$GLOBALS['__page_slug'] = 'videos/watch';

// Ensure meta is set (router may have set title/description/canonicalPath)
if (!isset($GLOBALS['__page_meta']) || !is_array($GLOBALS['__page_meta'])) {
  $GLOBALS['__page_meta'] = [];
}
$GLOBALS['__page_meta']['canonicalPath'] = "/{$locale}/videos/{$slug}/";
$GLOBALS['__page_meta']['title'] = $GLOBALS['__page_meta']['title'] ?? ($video['title'] . ' | NRLC.ai');
$GLOBALS['__page_meta']['description'] = $GLOBALS['__page_meta']['description'] ?? ($video['summary'] ?? substr($video['description'] ?? '', 0, 160));

// VideoObject + WebPage + BreadcrumbList
$jsonld = [
  [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => $canonicalUrl . '#webpage',
    'url' => $canonicalUrl,
    'name' => $video['title'],
    'description' => $video['summary'] ?? $video['description'],
    'isPartOf' => ['@id' => $domain . '#website'],
    'inLanguage' => 'en-US',
    'primaryImageOfPage' => !empty($video['thumbnailUrl']) ? $video['thumbnailUrl'] : null,
  ],
  [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => [
      ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => $domain . '/en-us/'],
      ['@type' => 'ListItem', 'position' => 2, 'name' => 'Videos', 'item' => $domain . '/en-us/videos/'],
      ['@type' => 'ListItem', 'position' => 3, 'name' => $video['title'], 'item' => $canonicalUrl],
    ],
  ],
  ld_video_object($video, $canonicalUrl),
];
$GLOBALS['__jsonld'] = array_filter($jsonld);

// Related: resolve slugs to video data for links
$relatedSlugs = $video['related'] ?? [];
$relatedVideos = [];
foreach ($relatedSlugs as $s) {
  $v = get_video_by_slug($s);
  if ($v) {
    $relatedVideos[] = $v;
  }
}
// If no related, show up to 3 others (exclude current)
if (empty($relatedVideos)) {
  foreach (get_all_videos() as $v) {
    if (($v['slug'] ?? '') !== $slug && count($relatedVideos) < 6) {
      $relatedVideos[] = $v;
    }
  }
}

$chapters = $video['chapters'] ?? [];
$transcript = $video['transcript'] ?? '';
$duration = $video['duration'] ?? '';
$uploadDate = $video['uploadDate'] ?? '';
?>

<main role="main" class="container">
  <article class="video-watch" itemscope itemtype="https://schema.org/VideoObject">
    <header class="section">
      <h1 class="content-block__title" itemprop="name"><?php echo htmlspecialchars($video['title']); ?></h1>
      <p class="lead" style="margin-bottom: 1rem;"><?php echo htmlspecialchars($video['summary'] ?? ''); ?></p>

      <div class="video-embed" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width: 100%; margin: 1rem 0;">
        <iframe width="560" height="315" src="<?php echo htmlspecialchars($video['embedUrl'] ?? ''); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;"></iframe>
      </div>

      <p class="video-meta" style="color: var(--text-muted, #666); font-size: 0.9rem;">
        <?php if ($duration) : ?>
          <span>Duration: <?php echo htmlspecialchars($duration); ?></span>
          <span style="margin: 0 0.5rem;">·</span>
        <?php endif; ?>
        <?php if ($uploadDate) : ?>
          <span>Uploaded: <?php echo htmlspecialchars($uploadDate); ?></span>
        <?php endif; ?>
      </p>
    </header>

    <?php if (!empty($chapters)) : ?>
    <section class="section content-block module">
      <h2 class="content-block__title">Chapters</h2>
      <ul class="video-chapters" style="list-style: none; padding: 0;">
        <?php foreach ($chapters as $ch) : ?>
        <li style="margin-bottom: 0.5rem;">
          <a href="<?php echo $canonicalUrl; ?>?t=<?php echo (string)(chapter_start_to_seconds($ch['start'] ?? '0')); ?>" style="text-decoration: none;">
            <strong><?php echo htmlspecialchars($ch['start'] ?? ''); ?></strong> — <?php echo htmlspecialchars($ch['title'] ?? ''); ?>
          </a>
        </li>
        <?php endforeach; ?>
      </ul>
    </section>
    <?php endif; ?>

    <?php if ($transcript !== '') : ?>
    <section class="section content-block module">
      <h2 class="content-block__title">Transcript</h2>
      <div class="video-transcript content-block__body">
        <?php echo nl2br(htmlspecialchars($transcript)); ?>
      </div>
    </section>
    <?php endif; ?>

    <?php if (!empty($relatedVideos)) : ?>
    <section class="section content-block module">
      <h2 class="content-block__title">Related videos</h2>
      <ul class="related-videos" style="list-style: none; padding: 0;">
        <?php foreach (array_slice($relatedVideos, 0, 6) as $rv) : ?>
        <li style="margin-bottom: 0.75rem;">
          <a href="<?php echo absolute_url("/{$locale}/videos/{$rv['slug']}/"); ?>"><?php echo htmlspecialchars($rv['title']); ?></a>
        </li>
        <?php endforeach; ?>
      </ul>
    </section>
    <?php endif; ?>
  </article>
</main>

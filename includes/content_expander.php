<?php
declare(strict_types=1);
/**
 * Thin-content helper (optional): wrap page body through this.
 * echo maybe_expand_content($htmlBody);
 */
function wc_plain(string $html): int { $t=strip_tags($html); $t=preg_replace('/\s+/', ' ', $t); return str_word_count((string)$t); }
function maybe_expand_content(string $html, array $opts=[]): string {
  if (wc_plain($html) >= (int)($opts['minWords'] ?? 300)) return $html;
  $faq = $opts['faq'] ?? [
    ['q'=>'What causes “Discovered – currently not indexed”?','a'=>'Low perceived value, thin content, poor internal links, or canonical/robots issues.'],
    ['q'=>'How do I fix it?','a'=>'Strengthen content, add schema, ensure self-canonical, update sitemaps, and request indexing.']
  ];
  $related = $opts['related'] ?? [];
  ob_start(); ?>
  <?= $html ?>
  <section class="seo-faq"><h2>Frequently Asked Questions</h2><dl>
    <?php foreach ($faq as $f): ?><dt><?= htmlspecialchars($f['q']) ?></dt><dd><?= htmlspecialchars($f['a']) ?></dd><?php endforeach; ?>
  </dl></section>
  <?php if ($related): ?><section class="related"><h2>Related Articles</h2><ul>
    <?php foreach ($related as $r): ?><li><a href="<?= htmlspecialchars($r['url']) ?>"><?= htmlspecialchars($r['label'] ?? $r['url']) ?></a></li><?php endforeach; ?>
  </ul></section><?php endif; ?>
  <?php return (string)ob_get_clean();
}



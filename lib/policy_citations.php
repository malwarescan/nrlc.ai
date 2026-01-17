<?php
/**
 * Policy Citations Helper
 * Standardized format for Google Search Central policy citations
 * Used across Local Pack Engineering resources
 */

/**
 * Render standardized policy citations block
 * 
 * @param array $options Optional configuration:
 *   - 'include_doorway' (bool): Include doorway pages citation (default: true)
 *   - 'include_scaled' (bool): Include scaled content abuse citation (default: true)
 *   - 'include_updates' (bool): Include spam updates page citation (default: true)
 *   - 'class' (string): Additional CSS classes for the container
 * @return string HTML for policy citations block
 */
function render_policy_citations(array $options = []): string {
  $include_doorway = $options['include_doorway'] ?? true;
  $include_scaled = $options['include_scaled'] ?? true;
  $include_updates = $options['include_updates'] ?? true;
  $class = $options['class'] ?? '';
  
  $citations = [];
  
  if ($include_doorway) {
    $citations[] = [
      'label' => 'Doorway pages',
      'url' => 'https://developers.google.com/search/docs/essentials/spam-policies#doorway-pages',
      'description' => 'Pages made to rank for specific, similar queries without adding unique value.'
    ];
  }
  
  if ($include_scaled) {
    $citations[] = [
      'label' => 'Scaled content abuse',
      'url' => 'https://developers.google.com/search/docs/essentials/spam-policies#scaled-content-abuse',
      'description' => 'Many pages generated primarily to manipulate rankings and not help users, typically unoriginal.'
    ];
  }
  
  if ($include_updates) {
    $citations[] = [
      'label' => 'Google spam updates',
      'url' => 'https://developers.google.com/search/updates/spam-updates',
      'description' => 'Official documentation on Google\'s spam policy updates and enforcement.'
    ];
  }
  
  if (empty($citations)) {
    return '';
  }
  
  ob_start();
  ?>
  <div class="content-block module policy-citations<?= $class ? ' ' . htmlspecialchars($class) : '' ?>" style="background: var(--color-background-alt, #f5f5f5); border-left: 4px solid var(--color-brand, #12355e); padding: var(--spacing-lg); margin: var(--spacing-xl) 0;">
    <div class="content-block__header">
      <h2 class="content-block__title heading-2">Policy Citations</h2>
    </div>
    <div class="content-block__body">
      <p>Google's spam policies explicitly cover the patterns described in this article:</p>
      <ul style="margin-top: var(--spacing-md);">
        <?php foreach ($citations as $citation): ?>
        <li style="margin-bottom: var(--spacing-sm);">
          <strong><a href="<?= htmlspecialchars($citation['url']) ?>" target="_blank" rel="noopener noreferrer"><?= htmlspecialchars($citation['label']) ?></a></strong>
          <?php if (!empty($citation['description'])): ?>
            <span style="display: block; margin-top: 0.25rem; color: var(--color-text-secondary, #666); font-size: 0.9em;"><?= htmlspecialchars($citation['description']) ?></span>
          <?php endif; ?>
        </li>
        <?php endforeach; ?>
      </ul>
      <p style="margin-top: var(--spacing-md); font-size: 0.9em; color: var(--color-text-secondary, #666);">
        If your approach depends on thin variants at scale, you are operating inside the exact territory these policies describe.
      </p>
    </div>
  </div>
  <?php
  return ob_get_clean();
}

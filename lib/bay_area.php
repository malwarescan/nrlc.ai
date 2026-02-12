<?php
/**
 * Bay Area local SEO helpers
 * Used for nearby-cities linking and future per-city uniqueness (local problem, who we help).
 */

if (!function_exists('bay_area_city_slugs')) {
  function bay_area_city_slugs(): array {
    return [
      'san-francisco', 'san-jose', 'oakland', 'palo-alto', 'mountain-view',
      'sunnyvale', 'santa-clara', 'cupertino', 'menlo-park', 'redwood-city',
      'san-mateo', 'burlingame', 'foster-city', 'millbrae', 'daly-city',
      'south-san-francisco', 'berkeley', 'fremont', 'hayward'
    ];
  }
}

if (!function_exists('is_bay_area_city')) {
  function is_bay_area_city(string $citySlug): bool {
    return in_array(strtolower($citySlug), bay_area_city_slugs(), true);
  }
}

if (!function_exists('nearby_bay_area_cities')) {
  /**
   * Return nearby Bay Area city slugs for internal linking (excluding current city).
   * Order: same county/region first, then by priority (SF, San Jose, Oakland, Palo Alto, etc.).
   *
   * @param string $citySlug Current city slug
   * @param int $max Max number of links to return (default 6)
   * @return array [['slug' => 'san-jose', 'name' => 'San Jose'], ...]
   */
  function nearby_bay_area_cities(string $citySlug, int $max = 6): array {
    $all = bay_area_city_slugs();
    $citySlug = strtolower($citySlug);
    $priority = ['san-francisco', 'san-jose', 'oakland', 'palo-alto', 'mountain-view', 'sunnyvale', 'santa-clara', 'san-mateo', 'berkeley', 'fremont'];
    $out = [];
    foreach ($priority as $slug) {
      if ($slug === $citySlug) continue;
      if (!in_array($slug, $all, true)) continue;
      $out[] = ['slug' => $slug, 'name' => ucwords(str_replace('-', ' ', $slug))];
      if (count($out) >= $max) break;
    }
    foreach ($all as $slug) {
      if (count($out) >= $max) break;
      if ($slug === $citySlug) continue;
      if (in_array($slug, array_column($out, 'slug'), true)) continue;
      $out[] = ['slug' => $slug, 'name' => ucwords(str_replace('-', ' ', $slug))];
    }
    return $out;
  }
}

if (!function_exists('bay_area_city_override')) {
  /**
   * Get optional per-city override (local_problem, who_we_help) from data/bay_area_city_overrides.json.
   * Returns array with keys local_problem, who_we_help or empty array if not found.
   */
  function bay_area_city_override(string $citySlug): array {
    static $data = null;
    if ($data === null) {
      $path = __DIR__ . '/../data/bay_area_city_overrides.json';
      if (!file_exists($path)) return [];
      $json = @file_get_contents($path);
      if ($json === false) return [];
      $data = json_decode($json, true);
      if (!is_array($data)) return [];
    }
    $citySlug = strtolower($citySlug);
    $out = $data[$citySlug] ?? [];
    return is_array($out) ? $out : [];
  }
}

if (!function_exists('nearby_bay_area_cities_html')) {
  /**
   * Render "Nearby cities we serve" block for Bay Area city pages.
   * Returns HTML string or empty string if not a Bay Area city.
   */
  function nearby_bay_area_cities_html(string $serviceSlug, string $citySlug, string $locale = 'en-us'): string {
    if (!is_bay_area_city($citySlug)) return '';
    $nearby = nearby_bay_area_cities($citySlug, 8);
    if (empty($nearby)) return '';
    $base = function_exists('absolute_url') ? absolute_url("/{$locale}/services/{$serviceSlug}/") : "https://nrlc.ai/{$locale}/services/{$serviceSlug}/";
    $hubUrl = function_exists('absolute_url') ? absolute_url("/{$locale}/bay-area/") : "https://nrlc.ai/{$locale}/bay-area/";
    $html = '<p><strong>Nearby cities we serve:</strong></p><ul style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 0.25rem 1rem; margin: 0.5rem 0;">';
    $html .= '<li><a href="' . htmlspecialchars($hubUrl) . '">San Francisco Bay Area</a></li>';
    foreach ($nearby as $c) {
      $html .= '<li><a href="' . htmlspecialchars($base . $c['slug'] . '/') . '">' . htmlspecialchars($c['name']) . '</a></li>';
    }
    $html .= '</ul>';
    return $html;
  }
}

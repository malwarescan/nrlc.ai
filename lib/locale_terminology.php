<?php
/**
 * Locale-Aware Terminology System
 * 
 * Provides locale-specific terminology for different English variants
 * Critical for UK traffic (uses "optimisation" not "optimization")
 */

/**
 * Get locale-specific terminology
 * 
 * @param string $locale Locale code (e.g., 'en-gb', 'en-us', 'en-sg', 'en-au')
 * @return array Array of terminology mappings
 */
function get_locale_terminology(string $locale): array {
  $terminology = [
    'en-us' => [
      'optimization' => 'optimization',
      'optimize' => 'optimize',
      'specialist' => 'specialist',
      'consultant' => 'consultant',
      'expert' => 'expert',
      'service' => 'service',
      'services' => 'services',
    ],
    'en-gb' => [
      'optimization' => 'optimisation',
      'optimize' => 'optimise',
      'specialist' => 'specialist',
      'consultant' => 'consultant',
      'expert' => 'expert',
      'service' => 'service',
      'services' => 'services',
    ],
    'en-sg' => [
      'optimization' => 'optimisation', // Singapore uses UK spelling
      'optimize' => 'optimise',
      'specialist' => 'specialist',
      'consultant' => 'consultant',
      'expert' => 'expert',
      'service' => 'service',
      'services' => 'services',
    ],
    'en-au' => [
      'optimization' => 'optimisation', // Australia uses UK spelling
      'optimize' => 'optimise',
      'specialist' => 'specialist',
      'consultant' => 'consultant',
      'expert' => 'expert',
      'service' => 'service',
      'services' => 'services',
    ],
  ];
  
  return $terminology[$locale] ?? $terminology['en-us'];
}

/**
 * Apply locale-specific terminology to a string
 * 
 * @param string $text Text to localize
 * @param string $locale Locale code
 * @return string Localized text
 */
function localize_terminology(string $text, string $locale): string {
  $terms = get_locale_terminology($locale);
  
  // Replace US terms with locale-appropriate terms
  foreach ($terms as $usTerm => $localTerm) {
    if ($usTerm !== $localTerm) {
      // Case-insensitive replacement, preserving case
      $text = preg_replace_callback(
        '/\b' . preg_quote($usTerm, '/') . '\b/i',
        function($matches) use ($localTerm, $usTerm) {
          // Preserve original case
          if (ctype_upper($matches[0])) {
            return strtoupper($localTerm);
          } elseif (ctype_upper(substr($matches[0], 0, 1))) {
            return ucfirst($localTerm);
          } else {
            return $localTerm;
          }
        },
        $text
      );
    }
  }
  
  return $text;
}

/**
 * Get current locale terminology (from GLOBALS or detect)
 * 
 * @return array Terminology array for current locale
 */
function current_locale_terminology(): array {
  $locale = $GLOBALS['locale'] ?? (function_exists('current_locale') ? current_locale() : 'en-us');
  return get_locale_terminology($locale);
}

/**
 * Localize a string using current locale terminology
 * 
 * @param string $text Text to localize
 * @return string Localized text
 */
function localize_text(string $text): string {
  $locale = $GLOBALS['locale'] ?? (function_exists('current_locale') ? current_locale() : 'en-us');
  return localize_terminology($text, $locale);
}

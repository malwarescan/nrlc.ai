<?php
// lib/SchemaNormalizers.php
declare(strict_types=1);

namespace App\Schema;

final class SchemaNormalizers
{
    /** Normalize "experienceRequirements" into either:
     *  A) OccupationalExperienceRequirements object (preferred by Google) when months/years detected
     *  B) Clean Text fallback
     *
     * Accepted raw inputs examples:
     *  - "0-1 years", "1+ year", "2 years", "36 months", "no experience", "entry level"
     * Returns:
     *  - ['@type'=>'OccupationalExperienceRequirements','monthsOfExperience'=>int]  OR  'Text string'
     */
    public static function normalizeExperienceRequirements(?string $raw)
    {
        $raw = trim((string)$raw);

        if ($raw === '' || preg_match('/\b(no|none|n\/a|entry[-\s]?level)\b/i', $raw)) {
            // 0 months object signals "no prior experience required" without tripping enum validators
            return [
                '@type' => 'OccupationalExperienceRequirements',
                'monthsOfExperience' => 0
            ];
        }

        // Try explicit months
        if (preg_match('/(\d+)\s*months?/i', $raw, $m)) {
            $months = max(0, (int)$m[1]);
            return [
                '@type' => 'OccupationalExperienceRequirements',
                'monthsOfExperience' => $months
            ];
        }

        // Try years (supports ranges and 1+)
        // Examples: "1 year", "2 years", "1-3 years", "3+ years"
        if (preg_match('/(\d+)\s*(?:\+|-\s*\d+)?\s*years?/i', $raw, $m)) {
            $years = (int)$m[1];
            $months = max(0, $years * 12);
            return [
                '@type' => 'OccupationalExperienceRequirements',
                'monthsOfExperience' => $months
            ];
        }

        // Catch "x+ years" with no space ("2+yrs") or abbreviated forms
        if (preg_match('/(\d+)\s*\+?\s*(yrs?|y\.?)/i', $raw, $m)) {
            $years = (int)$m[1];
            $months = max(0, $years * 12);
            return [
                '@type' => 'OccupationalExperienceRequirements',
                'monthsOfExperience' => $months
            ];
        }

        // If we cannot confidently coerce, return plain text (valid for Schema.org & Google)
        // Also strip emojis/symbols and collapse whitespace
        $text = preg_replace('/[^\PC\s]/u', '', $raw); // remove non-printing/control
        $text = preg_replace('/\s+/u', ' ', (string)$text);
        return trim($text);
    }

    /** Normalize "educationRequirements" to clean Text.
     * Examples: maps noisy values into readable text. Leaves unknowns as text.
     */
    public static function normalizeEducationRequirements(?string $raw): ?string
    {
        $raw = trim((string)$raw);
        if ($raw === '') return null;

        $canon = [
            '/\b(no\s*degree|none|n\/a)\b/i'          => 'No degree required',
            '/\b(high\s*school|hs\s*diploma)\b/i'     => 'High school diploma',
            '/\b(associate(\'?s)?|aa|as)\b/i'         => "Associate's degree",
            '/\b(bachelor(\'?s)?|ba|bs|bsc)\b/i'      => "Bachelor's degree",
            '/\b(master(\'?s)?|ma|ms|msc)\b/i'        => "Master's degree",
            '/\b(doctorate|ph\.?d|md|dphil)\b/i'      => "Doctorate"
        ];
        foreach ($canon as $re => $val) {
            if (preg_match($re, $raw)) return $val;
        }

        // fallback: clean text
        $text = preg_replace('/\s+/u', ' ', $raw);
        return trim($text);
    }

    /** Prevent duplicate JSON-LD blocks (same @id emitted twice on multi-include renders) */
    public static function jsonLdOnce(string $json, string $idKey = '@id'): ?string
    {
        static $seen = [];
        $decoded = json_decode($json, true);
        if (!is_array($decoded)) return $json;

        // Support array or single object
        $items = is_assoc($decoded) ? [$decoded] : $decoded;
        foreach ($items as $obj) {
            if (isset($obj[$idKey])) {
                $id = (string)$obj[$idKey];
                if (isset($seen[$id])) return null;
                $seen[$id] = true;
            }
        }
        return $json;
    }
}

// tiny helper to detect assoc arrays if not already defined in project
if (!function_exists('is_assoc')) {
    function is_assoc(array $arr): bool {
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}

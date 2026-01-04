<?php
declare(strict_types=1);
namespace NRLC\Schema;

final class SchemaFixes
{
    public static function normalizeExperienceRequirements(?string $raw)
    {
        $raw = trim((string)$raw);
        if ($raw === '' || preg_match('/\b(no|none|n\/a|entry[-\s]?level)\b/i', $raw)) {
            return ['@type'=>'OccupationalExperienceRequirements','monthsOfExperience'=>0];
        }
        if (preg_match('/(\d+)\s*months?/i', $raw, $m)) {
            return ['@type'=>'OccupationalExperienceRequirements','monthsOfExperience'=>max(0,(int)$m[1])];
        }
        if (preg_match('/(\d+)\s*(?:\+|-\s*\d+)?\s*years?/i', $raw, $m)) {
            return ['@type'=>'OccupationalExperienceRequirements','monthsOfExperience'=>max(0, (int)$m[1]*12)];
        }
        if (preg_match('/(\d+)\s*\+?\s*(yrs?|y\.?)/i', $raw, $m)) {
            return ['@type'=>'OccupationalExperienceRequirements','monthsOfExperience'=>max(0, (int)$m[1]*12)];
        }
        $text = preg_replace('/\s+/u', ' ', $raw);
        return trim($text);
    }

    public static function normalizeEducationRequirements(?string $raw): ?string
    {
        $raw = trim((string)$raw);
        if ($raw === '') return null;
        $canon = [
            '/\b(no\s*degree|none|n\/a)\b/i'          => 'No degree required',
            '/\b(high\s*school|hs\s*diploma)\b/i'     => 'High school diploma',
            '/\b(associate(\'?s)?|aa|as)\b/i'          => "Associate's degree",
            '/\b(bachelor(\'?s)?|ba|bs|bsc)\b/i'       => "Bachelor's degree",
            '/\b(master(\'?s)?|ma|ms|msc)\b/i'         => "Master's degree",
            '/\b(doctorate|ph\.?d|md|dphil)\b/i'       => "Doctorate"
        ];
        foreach ($canon as $re => $val) {
            if (preg_match($re, $raw)) return $val;
        }
        $text = preg_replace('/\s+/u', ' ', $raw);
        return trim($text);
    }

    public static function jsonLdOnce($jsonOrArray, string $idKey='@id'): ?string
    {
        static $seen=[];
        $decoded = is_array($jsonOrArray) ? $jsonOrArray : json_decode((string)$jsonOrArray, true);
        if (!is_array($decoded)) return null;
        $items = self::isAssoc($decoded) ? [$decoded] : $decoded;
        foreach ($items as $obj) {
            if (isset($obj[$idKey])) {
                $id = (string)$obj[$idKey];
                if (isset($seen[$id])) return null;
                $seen[$id] = true;
            }
        }
        return json_encode($decoded, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_INVALID_UTF8_SUBSTITUTE);
    }

    public static function ensureHttps(?string $url): ?string
    {
        if (!$url) return $url;
        if (stripos($url, 'https://') === 0) return $url;
        if (stripos($url, 'http://') === 0) {
            return 'https://' . substr($url, 7);
        }
        return $url;
    }

    private static function isAssoc(array $arr): bool
    {
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}

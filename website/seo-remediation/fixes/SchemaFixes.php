<?php
declare(strict_types=1);
namespace NRLC\Schema;

/**
 * Schema Normalization Helpers
 * Fixes common GSC schema issues
 */
final class SchemaFixes {
    
    /**
     * Ensure URLs use HTTPS
     */
    public static function ensureHttps(?string $url): ?string {
        if (!$url) return $url;
        if (stripos($url, 'https://') === 0) return $url;
        if (stripos($url, 'http://') === 0) return 'https://' . substr($url, 7);
        return $url;
    }
    
    /**
     * Prevent duplicate JSON-LD blocks with same @id
     * Usage: echo SchemaFixes::jsonLdOnce($schema_array);
     */
    public static function jsonLdOnce($jsonOrArray, string $idKey = '@id'): ?string {
        static $seen = [];
        
        $decoded = is_array($jsonOrArray) 
            ? $jsonOrArray 
            : json_decode((string)$jsonOrArray, true);
        
        if (!is_array($decoded)) return null;
        
        // Handle both single objects and arrays of objects
        $items = (array_keys($decoded) !== range(0, count($decoded) - 1)) 
            ? [$decoded] 
            : $decoded;
        
        foreach ($items as $obj) {
            if (isset($obj[$idKey])) {
                $id = (string)$obj[$idKey];
                if (isset($seen[$id])) {
                    // Already output, skip
                    return null;
                }
                $seen[$id] = true;
            }
        }
        
        return json_encode($decoded, 
            JSON_UNESCAPED_SLASHES | 
            JSON_UNESCAPED_UNICODE | 
            JSON_INVALID_UTF8_SUBSTITUTE
        );
    }
    
    /**
     * Reset seen IDs (for testing)
     */
    public static function resetSeen(): void {
        static $seen = [];
        $seen = [];
    }
}

<?php
declare(strict_types=1);
namespace NRLC\Schema;

final class SchemaFixes {
    public static function ensureHttps(?string $url): ?string {
        if (!$url) return $url;
        if (stripos($url, 'https://')===0) return $url;
        if (stripos($url, 'http://')===0) return 'https://'.substr($url, 7);
        return $url;
    }
    
    public static function jsonLdOnce($jsonOrArray, string $idKey='@id'): ?string {
        static $seen=[];
        $decoded = is_array($jsonOrArray) ? $jsonOrArray : json_decode((string)$jsonOrArray, true);
        if (!is_array($decoded)) return null;
        $items = (array_keys($decoded) !== range(0, count($decoded)-1)) ? [$decoded] : $decoded;
        foreach ($items as $obj) {
            if (isset($obj[$idKey])) {
                $id = (string)$obj[$idKey];
                if (isset($seen[$id])) return null;
                $seen[$id] = true;
            }
        }
        return json_encode($decoded, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_INVALID_UTF8_SUBSTITUTE);
    }
}

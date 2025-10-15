<?php declare(strict_types=1);

final class Json {
  public static function tryDecode(string $json): array {
    $json = trim($json);
    if ($json === '') return [];
    $data = json_decode($json, true);
    if (json_last_error() !== JSON_ERROR_NONE) return [];
    return is_array($data) ? $data : [];
  }

  public static function pretty(array $a): string {
    return json_encode($a, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) ?: "{}";
  }
}


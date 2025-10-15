<?php declare(strict_types=1);

final class Robots {
  public static function allowed(string $base, string $path): bool {
    $robotsUrl = rtrim($base,'/').'/robots.txt';
    static $rules = null;
    if ($rules === null) {
      $res = Http::get($robotsUrl);
      $rules = self::parse($res['body'] ?? '');
    }
    $u = parse_url($path, PHP_URL_PATH) ?: '/';
    foreach ($rules['disallow'] as $prefix) {
      if ($prefix !== '' && str_starts_with($u, $prefix)) return false;
    }
    return true;
  }

  public static function parse(string $txt): array {
    $disallow = [];
    foreach (preg_split("/\r\n|\n|\r/", $txt) as $line) {
      $line = trim(preg_replace('~#.*$~','',$line));
      if (stripos($line,'Disallow:')===0) {
        $v = trim(substr($line,9));
        $disallow[] = $v;
      }
    }
    return ['disallow'=>$disallow];
  }
}


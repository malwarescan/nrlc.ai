<?php declare(strict_types=1);

final class Http {
  public static function get(string $url, int $timeout=15): array {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_FOLLOWLOCATION => false, // we control redirects manually
      CURLOPT_TIMEOUT => $timeout,
      CURLOPT_USERAGENT => 'NRLC-SiteDiscovery/1.0',
      CURLOPT_HEADER => true,
    ]);
    $res = curl_exec($ch);
    $err = curl_error($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE) ?: 0;
    $hLen = curl_getinfo($ch, CURLINFO_HEADER_SIZE) ?: 0;
    curl_close($ch);
    if ($res === false) return ['code'=>0,'headers'=>[],'body'=>'','error'=>$err];
    $rawHeaders = substr($res, 0, $hLen);
    $body = substr($res, $hLen);
    $headers = self::parseHeaders($rawHeaders);
    return ['code'=>$code,'headers'=>$headers,'body'=>$body,'error'=>null];
  }

  private static function parseHeaders(string $raw): array {
    $lines = preg_split("/\r\n|\n|\r/", trim($raw)) ?: [];
    $out = [];
    foreach ($lines as $line) {
      if (stripos($line, 'HTTP/') === 0) continue;
      if (strpos($line, ':') !== false) {
        [$k,$v] = array_map('trim', explode(':', $line, 2));
        $out[strtolower($k)] = $v;
      }
    }
    return $out;
  }
}


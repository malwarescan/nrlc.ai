<?php
declare(strict_types=1);

function nrlc_pdo(): ?PDO {
  static $pdo = null;
  static $attempted = false;
  if ($attempted) {
    return $pdo;
  }
  $attempted = true;

  $databaseUrl = $_ENV['DATABASE_URL'] ?? getenv('DATABASE_URL') ?: '';
  if ($databaseUrl === '') {
    return null;
  }

  $parsed = parse_url($databaseUrl);
  if (!is_array($parsed) || !isset($parsed['scheme'])) {
    error_log('DB init failed: invalid DATABASE_URL');
    return null;
  }

  try {
    if ($parsed['scheme'] === 'postgres' || $parsed['scheme'] === 'postgresql') {
      $host = $parsed['host'] ?? 'localhost';
      $port = $parsed['port'] ?? 5432;
      $user = $parsed['user'] ?? '';
      $pass = $parsed['pass'] ?? '';
      $dbName = ltrim($parsed['path'] ?? '', '/');
      $query = [];
      if (!empty($parsed['query'])) {
        parse_str($parsed['query'], $query);
      }
      $sslmode = $query['sslmode'] ?? 'require';
      $dsn = "pgsql:host={$host};port={$port};dbname={$dbName};sslmode={$sslmode}";
      $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      ]);
      return $pdo;
    }
  } catch (Throwable $e) {
    error_log('DB init failed: ' . $e->getMessage());
    return null;
  }

  return null;
}

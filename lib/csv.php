<?php
declare(strict_types=1);

/**
 * csv_read(string $absPath, ?string $delimiter = null): array[]
 * - Robust CSV loader for Unix/Windows line endings, optional BOM, auto-delimiter detection, quoted fields.
 * - Returns array of associative rows using normalized lowercase snake_case headers.
 * - Skips empty rows and rows with all-empty fields.
 * - Converts to UTF-8 if necessary (best-effort).
 */
function csv_read(string $absPath, ?string $delimiter = null): array {
  if (!is_file($absPath) || !is_readable($absPath)) return [];
  $bytes = file_get_contents($absPath);
  if ($bytes === false) return [];

  // Normalize newlines and trim BOM
  $bytes = preg_replace("/\r\n?/", "\n", $bytes) ?? $bytes;
  if (strncmp($bytes, "\xEF\xBB\xBF", 3) === 0) { $bytes = substr($bytes, 3); }

  // Heuristic delimiter detection if not provided
  if ($delimiter === null) {
    $sample = substr($bytes, 0, 8192);
    $cands = [",", ";", "\t", "|"];
    $best = ","; $bestScore = -1;
    foreach ($cands as $d) {
      $lines = preg_split("/\n/", $sample, -1, PREG_SPLIT_NO_EMPTY);
      $scores = 0; $count = 0;
      foreach (array_slice($lines, 0, 10) as $ln) { $scores += substr_count($ln, $d); $count++; }
      $avg = $count ? $scores / $count : 0;
      if ($avg > $bestScore) { $bestScore = $avg; $best = $d; }
    }
    $delimiter = $best;
  }

  // Ensure UTF-8 (best effort)
  if (!mb_check_encoding($bytes, 'UTF-8')) {
    $enc = mb_detect_encoding($bytes, ['UTF-8','UTF-16','UTF-32','ISO-8859-1','Windows-1252'], true);
    if ($enc && $enc !== 'UTF-8') $bytes = mb_convert_encoding($bytes, 'UTF-8', $enc);
  }

  $lines = preg_split("/\n/", $bytes);
  if (!$lines) return [];

  // Parse with str_getcsv to control escape and enclosure explicitly (prevents deprec warnings)
  $rows = [];
  $headers = null;
  foreach ($lines as $ln) {
    if ($ln === '' || trim($ln) === '') continue;
    $fields = str_getcsv($ln, $delimiter, '"', "\\");
    if ($fields === null) continue;

    if ($headers === null) {
      // Normalize headers → snake_case
      $headers = array_map(function($h){
        $h = trim((string)$h);
        $h = preg_replace('/[^\p{L}\p{N}]+/u', '_', mb_strtolower($h)); // non-alnum → _
        $h = preg_replace('/_+/', '_', $h);
        return trim($h, '_');
      }, $fields);
      continue;
    }

    // Skip lines with no columns
    if (count(array_filter($fields, fn($v)=>trim((string)$v) !== '')) === 0) continue;

    // Align columns
    $cols = count($headers);
    if (count($fields) < $cols) $fields = array_pad($fields, $cols, '');
    if (count($fields) > $cols) $fields = array_slice($fields, 0, $cols);

    $assoc = [];
    foreach ($headers as $i => $k) { $assoc[$k] = trim((string)$fields[$i]); }
    $rows[] = $assoc;
  }
  return $rows;
}

/** Convenience loader relative to /data */
function csv_read_data(string $relName, ?string $delimiter = null): array {
  $abs = __DIR__ . '/../data/' . ltrim($relName, '/');
  return csv_read($abs, $delimiter);
}

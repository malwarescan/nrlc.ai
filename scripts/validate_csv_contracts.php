<?php
declare(strict_types=1);
require_once __DIR__ . '/../lib/csv.php';

$schema = json_decode(file_get_contents(__DIR__ . '/../data/schema/headers.json'), true);
if(!$schema){ fwrite(STDERR,"ERR: headers.json missing/invalid\n"); exit(2); }

$fail = false;
foreach ($schema as $file => $expected) {
  $rows = csv_read(__DIR__ . '/../data/' . $file);
  if (!$rows) { echo "WARN: $file empty or unreadable\n"; continue; }
  $got = array_keys($rows[0]);
  if ($got !== array_map(fn($h)=>strtolower(str_replace('-','_', $h)), $expected)) {
    $fail = true;
    echo "FAIL: $file headers mismatch\n  expected: [" . implode(',', $expected) . "]\n  got:      [" . implode(',', $got) . "]\n";
  } else {
    echo "OK: $file headers match\n";
  }
}
exit($fail ? 1 : 0);

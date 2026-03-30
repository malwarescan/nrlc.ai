#!/usr/bin/env php
<?php
declare(strict_types=1);

/**
 * Run `php -l` on every *.php under pages/. Exit 1 if any file fails parse.
 * Use before deploy so route includes never throw from syntax errors.
 *
 *   php scripts/verify_pages_syntax.php
 */

$root = realpath(__DIR__ . '/../pages');
if ($root === false) {
  fwrite(STDERR, "pages/ not found\n");
  exit(1);
}

$it = new RecursiveIteratorIterator(
  new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS)
);
$failed = [];
$n = 0;
foreach ($it as $f) {
  if (!$f->isFile() || strtolower($f->getExtension()) !== 'php') {
    continue;
  }
  $n++;
  $path = $f->getPathname();
  $out = shell_exec('php -l ' . escapeshellarg($path) . ' 2>&1');
  if ($out === null || strpos($out, 'No syntax errors') === false) {
    $failed[] = trim((string)$out);
  }
}

fwrite(STDOUT, "Checked {$n} PHP files under pages/\n");
if ($failed !== []) {
  fwrite(STDERR, implode("\n---\n", $failed) . "\n");
  exit(1);
}
exit(0);

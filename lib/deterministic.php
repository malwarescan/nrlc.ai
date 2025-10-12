<?php
declare(strict_types=1);

/** Deterministic PRNG seeded by a string (e.g., request path). */
function det_seed(string $key): void {
  $h = crc32($key);
  mt_srand($h);
}
function det_pick(array $items, int $count = 1): array {
  if (empty($items) || $count <= 0) return [];
  $copy = $items;
  for ($i = count($copy) - 1; $i > 0; $i--) { $j = mt_rand(0, $i); [$copy[$i], $copy[$j]] = [$copy[$j], $copy[$i]]; }
  return array_slice($copy, 0, min($count, count($copy)));
}
function det_int(int $min, int $max): int { return mt_rand($min, $max); }
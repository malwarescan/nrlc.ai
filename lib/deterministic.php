<?php
/**
 * Deterministic shuffling/choice based on URL path.
 */
function det_seed(string $path): int {
  return abs(crc32($path));
}
function det_shuffle(array $arr, int $seed): array {
  mt_srand($seed);
  $copy = $arr;
  $n = count($copy);
  for ($i=$n-1; $i>0; $i--) {
    $j = mt_rand(0,$i);
    [$copy[$i], $copy[$j]] = [$copy[$j], $copy[$i]];
  }
  mt_srand(); // reset
  return $copy;
}
function det_pick(array $arr, int $seed, int $count): array {
  $shuf = det_shuffle($arr,$seed);
  return array_slice($shuf,0,min($count,count($shuf)));
}


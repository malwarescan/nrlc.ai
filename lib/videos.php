<?php
/**
 * Video watch page data — load from data/videos.json.
 * Used by watch page template, router, and video sitemap.
 */
declare(strict_types=1);

function videos_data(): array {
  static $data = null;
  if ($data === null) {
    $path = __DIR__ . '/../data/videos.json';
    if (!is_file($path)) {
      return ['videos' => []];
    }
    $json = file_get_contents($path);
    $data = json_decode($json, true);
    if (!is_array($data) || !isset($data['videos'])) {
      $data = ['videos' => []];
    }
  }
  return $data;
}

/** @return array|null Video by slug or null if not found */
function get_video_by_slug(string $slug): ?array {
  $data = videos_data();
  foreach ($data['videos'] as $v) {
    if (isset($v['slug']) && $v['slug'] === $slug) {
      return $v;
    }
  }
  return null;
}

/** @return list<array> All videos (order preserved) */
function get_all_videos(): array {
  $data = videos_data();
  return $data['videos'];
}

/** @return list<array> Videos that have the given topic */
function get_videos_by_topic(string $topic): array {
  $out = [];
  foreach (get_all_videos() as $v) {
    if (isset($v['topic']) && $v['topic'] === $topic) {
      $out[] = $v;
    }
  }
  return $out;
}

/**
 * Convert ISO 8601 duration (e.g. PT7M32S) to seconds for video sitemap.
 * Google video sitemap expects duration as integer seconds.
 */
function video_duration_to_seconds(string $duration): int {
  $seconds = 0;
  if (preg_match('/PT(?:(\d+)H)?(?:(\d+)M)?(?:(\d+)S)?/i', $duration, $m)) {
    $seconds = (int)($m[1] ?? 0) * 3600 + (int)($m[2] ?? 0) * 60 + (int)($m[3] ?? 0);
  }
  return $seconds;
}

/**
 * Convert chapter start timestamp (e.g. "1:23" or "0:00") to seconds for SeekToAction.
 */
function chapter_start_to_seconds(string $start): int {
  $parts = array_map('intval', explode(':', trim($start)));
  if (count($parts) === 1) {
    return $parts[0];
  }
  if (count($parts) === 2) {
    return $parts[0] * 60 + $parts[1];
  }
  if (count($parts) === 3) {
    return $parts[0] * 3600 + $parts[1] * 60 + $parts[2];
  }
  return 0;
}

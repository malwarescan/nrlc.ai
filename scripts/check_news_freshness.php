<?php
declare(strict_types=1);
require_once __DIR__ . '/../lib/csv.php';
$rows = csv_read(__DIR__ . '/../data/insights.csv');
$now = new DateTimeImmutable('now', new DateTimeZone('UTC'));
$recent = 0;
foreach ($rows as $r) {
  $d = isset($r['publication_date']) ? new DateTimeImmutable($r['publication_date']) : null;
  if ($d && $now->getTimestamp() - $d->getTimestamp() <= 48*3600) $recent++;
}
echo "Recent news (≤48h): $recent\n";
exit($recent > 0 ? 0 : 1);

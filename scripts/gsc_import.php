<?php
declare(strict_types=1);
/**
 * GSC CSV Importer — normalizes arbitrary GSC "Pages" exports into ./data/Table.csv
 * - Place CSV(s) in ./gsc/
 * - Detects URL column: URL|Page|Address
 * - Detects Last crawled column (if present)
 * - Optional ISSUE filter via env ISSUE="Discovered - currently not indexed"
 * Usage: php scripts/gsc_import.php ./gsc ./data/Table.csv
 */
if (php_sapi_name()!=='cli'){fwrite(STDERR,"CLI only\n");exit(1);} 
$inDir = $argv[1] ?? './gsc';
$out   = $argv[2] ?? './data/Table.csv';
$issueFilter = getenv('ISSUE') ?: '';

if (!is_dir($inDir)) { fwrite(STDERR,"Input dir not found: $inDir\n"); exit(1); }
@mkdir(dirname($out), 0775, true);

$files = array_values(array_filter(scandir($inDir), fn($f)=>preg_match('/\.csv$/i',$f)));
if (!$files) { fwrite(STDERR,"No CSV files in $inDir. Export from GSC and drop them here.\n"); exit(1); }

$rows = [];
foreach ($files as $f) {
  $path = rtrim($inDir,'/').'/'.$f;
  if (($fh=fopen($path,'r'))===false) continue;
  $hdr = fgetcsv($fh, 0, ',', '"', '\\');
  if (!$hdr) { fclose($fh); continue; }
  $map = array_change_key_case(array_flip(array_map('trim',$hdr)), CASE_LOWER);

  $colUrl = $map['url'] ?? ($map['page'] ?? ($map['address'] ?? null));
  if ($colUrl===null) { fclose($fh); continue; }

  // Last crawled column variants:
  $colCrawled = $map['last crawled'] ?? ($map['last_crawled'] ?? ($map['last crawl'] ?? null));
  // Reason column (for ISSUE filtering)
  $colReason  = $map['reason'] ?? ($map['issue'] ?? null);

  while (($r=fgetcsv($fh, 0, ',', '"', '\\'))!==false) {
    $url = trim($r[$colUrl] ?? '');
    if ($url==='') continue;

    $reason = $colReason!==null ? trim($r[$colReason] ?? '') : '';
    if ($issueFilter && stripos($reason, $issueFilter)===false) {
      // skip if filtering by issue and this row doesn't match
      continue;
    }

    $lc  = $colCrawled!==null ? trim($r[$colCrawled] ?? '') : '';
    // Normalize impossible/unset dates to 1970-01-01
    if ($lc==='' || !preg_match('/^\d{4}-\d{2}-\d{2}$/',$lc)) $lc='1970-01-01';
    $rows[$url] = ['URL'=>$url,'Last crawled'=>$lc];
  }
  fclose($fh);
}
if (!$rows) { fwrite(STDERR,"No rows parsed. Check ISSUE filter or CSV format.\n"); exit(1); }

$fh = fopen($out,'w'); fputcsv($fh,['URL','Last crawled'], ',', '"', '\\');
foreach ($rows as $row) fputcsv($fh,[$row['URL'],$row['Last crawled']], ',', '"', '\\');
fclose($fh);
echo "Wrote: $out (".count($rows)." URLs)\n";



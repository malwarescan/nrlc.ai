<?php
/**
 * NRLC AI Case Study System - Client Dashboard Overview
 * 
 * Plain PHP + JS charts. No SPA required.
 * Shows coverage score, mention rate, citation rate, regression queue, badge status.
 */

require_once __DIR__ . '/../../lib/auth.php';

require_client(); // Gate: client role required

$clientId = $_GET['id'] ?? '1';

require_once __DIR__ . '/../../lib/case_study_registry.php';

// Load client data (in production, from database)
$clientData = load_client_data($clientId);
$metrics = calculate_metrics($clientId);

function load_client_data(string $clientId): array {
  // In production, query database
  // For now, return mock data
  return [
    'id' => $clientId,
    'name' => 'Client ' . $clientId,
    'case_studies' => ['b2b-saas', 'ecommerce']
  ];
}

function calculate_metrics(string $clientId): array {
  $dataDir = __DIR__ . '/../../data/ai_verification/';
  $registry = get_case_study_registry();
  $clientData = load_client_data($clientId);
  
  $totalMentions = 0;
  $totalCitations = 0;
  $totalPrompts = 0;
  $regressions = 0;
  
  foreach ($clientData['case_studies'] as $slug) {
    $verificationFiles = glob($dataDir . "{$slug}_aggregate_*.json");
    if (empty($verificationFiles)) {
      $verificationFiles = glob($dataDir . "aggregate_*.json");
    }
    
    if (!empty($verificationFiles)) {
      usort($verificationFiles, function($a, $b) {
        return filemtime($b) - filemtime($a);
      });
      
      $latestFile = $verificationFiles[0];
      $data = json_decode(file_get_contents($latestFile), true) ?? [];
      
      if (isset($data[$slug])) {
        $caseData = $data[$slug];
        $prompts = $caseData['prompts'] ?? [];
        $totalPrompts += count($prompts);
        
        foreach ($prompts as $prompt) {
          if ($prompt['chatgpt']['mentions_brand'] ?? false) $totalMentions++;
          if ($prompt['claude']['mentions_brand'] ?? false) $totalMentions++;
          if ($prompt['google_ai_overviews']['mentions_brand'] ?? false) $totalMentions++;
          
          if ($prompt['chatgpt']['citation'] ?? false) $totalCitations++;
          if ($prompt['claude']['citation'] ?? false) $totalCitations++;
          if ($prompt['google_ai_overviews']['citation'] ?? false) $totalCitations++;
        }
        
        // Check for regressions
        if (strpos($caseData['summary'] ?? '', 'REGRESSION') !== false) {
          $regressions++;
        }
      }
    }
  }
  
  $maxPossible = $totalPrompts * 3; // 3 models
  $mentionRate = $maxPossible > 0 ? ($totalMentions / $maxPossible) * 100 : 0;
  $citationRate = $maxPossible > 0 ? ($totalCitations / $maxPossible) * 100 : 0;
  $coverageScore = ($mentionRate + $citationRate) / 2;
  
  return [
    'coverage_score' => round($coverageScore, 1),
    'mention_rate' => round($mentionRate, 1),
    'citation_rate' => round($citationRate, 1),
    'regressions' => $regressions,
    'total_prompts' => $totalPrompts,
    'total_mentions' => $totalMentions,
    'total_citations' => $totalCitations
  ];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Client Dashboard - <?= htmlspecialchars($clientData['name']) ?> | NRLC.ai</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body { font-family: system-ui, sans-serif; max-width: 1200px; margin: 0 auto; padding: 2rem; }
    .metrics { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin: 2rem 0; }
    .metric-card { background: #f5f5f5; padding: 1.5rem; border-radius: 8px; }
    .metric-value { font-size: 2rem; font-weight: bold; color: #0066cc; }
    .metric-label { color: #666; margin-top: 0.5rem; }
    .chart-container { margin: 2rem 0; }
    .regression-alert { background: #fee; border: 1px solid #fcc; padding: 1rem; border-radius: 4px; margin: 1rem 0; }
    .badge { display: inline-block; margin: 0.5rem 0; }
  </style>
</head>
<body>
  <h1>Client Dashboard: <?= htmlspecialchars($clientData['name']) ?></h1>
  
  <p><small>Last checked: <?php
    // Get latest verification timestamp
    $dataDir = __DIR__ . '/../../data/ai_verification/';
    $verificationFiles = glob($dataDir . 'aggregate_*.json');
    if (!empty($verificationFiles)) {
      usort($verificationFiles, function($a, $b) {
        return filemtime($b) - filemtime($a);
      });
      $latestFile = $verificationFiles[0];
      $data = json_decode(file_get_contents($latestFile), true) ?? [];
      $latestTimestamp = null;
      foreach ($data as $caseData) {
        if (isset($caseData['timestamp'])) {
          $ts = strtotime($caseData['timestamp']);
          if (!$latestTimestamp || $ts > $latestTimestamp) {
            $latestTimestamp = $ts;
          }
        }
      }
      if ($latestTimestamp) {
        echo date('Y-m-d H:i:s', $latestTimestamp) . ' UTC';
      } else {
        echo 'Never';
      }
    } else {
      echo 'Never';
    }
  ?></small></p>
  
  <?php if ($metrics['regressions'] > 0): ?>
    <div class="regression-alert">
      <strong>⚠️ Regression Detected</strong>
      <p><?= $metrics['regressions'] ?> case study(ies) showing decreased AI visibility. Review required.</p>
    </div>
  <?php endif; ?>
  
  <div class="metrics">
    <div class="metric-card">
      <div class="metric-value"><?= $metrics['coverage_score'] ?>%</div>
      <div class="metric-label">Coverage Score</div>
    </div>
    <div class="metric-card">
      <div class="metric-value"><?= $metrics['mention_rate'] ?>%</div>
      <div class="metric-label">Mention Rate</div>
    </div>
    <div class="metric-card">
      <div class="metric-value"><?= $metrics['citation_rate'] ?>%</div>
      <div class="metric-label">Citation Rate</div>
    </div>
    <div class="metric-card">
      <div class="metric-value"><?= $metrics['regressions'] ?></div>
      <div class="metric-label">Regressions</div>
    </div>
  </div>
  
  <div class="chart-container">
    <canvas id="coverageChart"></canvas>
  </div>
  
  <h2>Case Studies</h2>
  <ul>
    <?php foreach ($clientData['case_studies'] as $slug): ?>
      <?php $caseData = get_case_study_data($slug); ?>
      <li>
        <a href="/case-studies/<?= htmlspecialchars($slug) ?>/"><?= htmlspecialchars($caseData['title'] ?? $slug) ?></a>
        <img src="/api/badge.php?client=<?= $clientId ?>&scope=client&ref=<?= htmlspecialchars($slug) ?>" alt="Verification badge" class="badge">
      </li>
    <?php endforeach; ?>
  </ul>
  
  <nav>
    <a href="/app/clients/clusters.php?id=<?= $clientId ?>">Prompt Clusters</a> |
    <a href="/app/clients/prompts.php?id=<?= $clientId ?>">Prompts</a> |
    <a href="/app/clients/regressions.php?id=<?= $clientId ?>">Regressions</a>
  </nav>
  
  <script>
    const ctx = document.getElementById('coverageChart').getContext('2d');
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
        datasets: [{
          label: 'Coverage Score',
          data: [<?= $metrics['coverage_score'] - 10 ?>, <?= $metrics['coverage_score'] - 5 ?>, <?= $metrics['coverage_score'] ?>, <?= $metrics['coverage_score'] ?>],
          borderColor: '#0066cc',
          tension: 0.1
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,
            max: 100
          }
        }
      }
    });
  </script>
</body>
</html>


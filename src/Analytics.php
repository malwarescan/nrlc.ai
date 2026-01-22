<?php
$metrics = [
  [
    'label' => 'AI Visibility Index',
    'value' => '94',
    'unit' => '%',
    'color' => '#00C2FF'
  ],
  [
    'label' => 'TrustScore',
    'value' => '89',
    'unit' => '/100',
    'color' => '#25D366'
  ],
  [
    'label' => 'Fact Velocity',
    'value' => '2.4k',
    'unit' => '/day',
    'color' => '#00C2FF'
  ],
  [
    'label' => 'Vector Reach',
    'value' => '12.8M',
    'unit' => 'nodes',
    'color' => '#25D366'
  ]
];

function calculatePercentage($value) {
  $numericValue = preg_replace('/[^0-9.]/', '', $value);
  return min((floatval($numericValue) / 100) * 100, 100);
}
?>
<section id="analytics" class="w-full bg-white py-24 px-8">
  <div class="max-w-6xl mx-auto">
    <div class="text-center mb-16">
      <h2 class="text-4xl md:text-5xl font-bold text-[#0A0A0A] mb-4">
        Measure What Matters
      </h2>
      <p class="text-lg text-[#6B6B6B]">
        Data-dense, unobtrusive, precise.
      </p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <?php foreach ($metrics as $index => $metric): ?>
        <div class="border-2 border-[#0A0A0A] p-8 hover:border-[#00C2FF] transition-colors duration-200">
          <div class="space-y-4">
            <div class="flex items-baseline gap-1">
              <span class="text-5xl font-bold text-[#0A0A0A]">
                <?php echo htmlspecialchars($metric['value']); ?>
              </span>
              <span class="text-xl font-mono text-[#6B6B6B]">
                <?php echo htmlspecialchars($metric['unit']); ?>
              </span>
            </div>
            <div class="h-1 w-full bg-[#F8F8F8]">
              <div class="h-full transition-all duration-300" style="width: <?php echo calculatePercentage($metric['value']); ?>%; background-color: <?php echo htmlspecialchars($metric['color']); ?>;"></div>
            </div>
            <div class="text-sm font-mono text-[#6B6B6B] uppercase tracking-wider">
              <?php echo htmlspecialchars($metric['label']); ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="mt-16 p-8 bg-[#F8F8F8] border-2 border-[#0A0A0A]">
      <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
        <div class="space-y-2">
          <h3 class="text-2xl font-bold text-[#0A0A0A]">
            Dashboard Preview
          </h3>
          <p class="text-[#6B6B6B]">
            Left = human summary. Right = JSON preview.
          </p>
        </div>
        <a href="dashboard.php" class="px-6 py-3 bg-[#0A0A0A] text-white font-mono text-sm hover:bg-[#00C2FF] transition-colors duration-200 inline-block">
          View Full Dashboard
        </a>
      </div>
    </div>
  </div>
</section>


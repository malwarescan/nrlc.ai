<?php
$features = [
  [
    'title' => 'Atomic Clarity',
    'description' => 'Each component does one thing clearly. Every element is readable by humans and exportable as JSON.',
    'icon' => '▣'
  ],
  [
    'title' => 'Dual Readability',
    'description' => 'Designed for both human comprehension and machine parsing. Elegance in code syntax and UI symmetry.',
    'icon' => '◈'
  ],
  [
    'title' => 'Progressive Depth',
    'description' => 'Reveal technical layers on demand. Vector IDs, citations, and metadata available when you need them.',
    'icon' => '◇'
  ],
  [
    'title' => 'Trust Through Space',
    'description' => 'White space signals integrity and focus. Every pixel is as intentional as every fact.',
    'icon' => '◻'
  ]
];
?>
<section id="features" class="w-full bg-white py-24 px-8">
  <div class="max-w-6xl mx-auto">
    <div class="text-center mb-16">
      <h2 class="text-4xl md:text-5xl font-bold text-[#0A0A0A] mb-4">
        Design Principles
      </h2>
      <p class="text-lg text-[#6B6B6B] max-w-2xl mx-auto">
        Structured flavor for data. Transform chaos into clarity.
      </p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <?php foreach ($features as $index => $feature): ?>
        <div class="border-2 border-[#0A0A0A] p-8 hover:bg-[#F8F8F8] transition-colors duration-200">
          <div class="text-5xl mb-4 text-[#0A0A0A]"><?php echo htmlspecialchars($feature['icon']); ?></div>
          <h3 class="text-2xl font-bold text-[#0A0A0A] mb-3">
            <?php echo htmlspecialchars($feature['title']); ?>
          </h3>
          <p class="text-[#6B6B6B] leading-relaxed">
            <?php echo htmlspecialchars($feature['description']); ?>
          </p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>


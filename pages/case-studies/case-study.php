<?php
$caseNumber = $_GET['case'] ?? '1';

// Generate deterministic content based on case number
det_seed("case|$caseNumber");

$company = det_pick([
  "TechCorp Solutions", "DataFlow Inc", "CloudFirst Systems", "AI Innovations Ltd",
  "Digital Dynamics", "SmartTech Enterprises", "NextGen Platforms", "InnovateLab Corp"
], 1)[0];

$industry = det_pick([
  "SaaS", "E-commerce", "Healthcare", "Fintech", "Education", "Manufacturing"
], 1)[0];

$challenge = det_pick([
  "Low AI engine citation rates affecting content visibility and user engagement.",
  "Inconsistent structured data implementation leading to poor semantic understanding.",
  "Complex multi-language content requiring robust hreflang and canonical management."
], 1)[0];

$solution = det_pick([
  "Comprehensive GEO-16 framework implementation with industry-specific schema markup.",
  "Advanced entity disambiguation and semantic markup optimization across all content.",
  "Automated content validation and monitoring system for sustained AI SEO performance."
], 1)[0];

$results = det_pick([
  "300% increase in AI engine citations within 90 days of implementation.",
  "85% improvement in content visibility across multiple AI platforms.",
  "50% reduction in crawl budget waste through optimized canonical and hreflang management."
], 1)[0];

$faqs = det_pick([
  ["What was the biggest challenge?", "<?= htmlspecialchars($challenge) ?>"],
  ["How did you solve it?", "<?= htmlspecialchars($solution) ?>"],
  ["What were the results?", "<?= htmlspecialchars($results) ?>"]
], 3);
?>

<section class="window container prose">
  <h1>Case Study #<?= htmlspecialchars($caseNumber) ?>: <?= htmlspecialchars($company) ?></h1>
  
  <p class="lead">How <?= htmlspecialchars($company) ?>, a leading <?= htmlspecialchars($industry) ?> company, achieved significant improvements in AI engine visibility through strategic SEO optimization.</p>
  
  <h2>The Challenge</h2>
  <p><?= htmlspecialchars($challenge) ?></p>
  
  <h2>Our Solution</h2>
  <p><?= htmlspecialchars($solution) ?></p>
  
  <h2>Results</h2>
  <p><?= htmlspecialchars($results) ?></p>
  
  <h2>Key Takeaways</h2>
  <ul>
    <li>Strategic implementation of structured data is crucial for AI engine optimization</li>
    <li>Industry-specific schema markup significantly improves content comprehension</li>
    <li>Ongoing monitoring and optimization ensure sustained performance improvements</li>
  </ul>
  
  <h2>Frequently Asked Questions</h2>
  <div class="grid" style="gap: 4px;">
    <?php foreach ($faqs as $faq): ?>
    <details class="card">
      <summary><strong><?= htmlspecialchars($faq[0]) ?></strong></summary>
      <p class="small muted"><?= htmlspecialchars($faq[1]) ?></p>
    </details>
    <?php endforeach; ?>
  </div>
  
  <div class="status-bar">
    <p class="status-bar-field">Ready to achieve similar results for your company?</p>
    <button class="btn ripple" onclick="window.location.href='/contact/'">Get Started</button>
  </div>
</section>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "Case Study #<?= htmlspecialchars($caseNumber) ?>: <?= htmlspecialchars($company) ?> AI SEO Success",
  "author": {
    "@type": "Person",
    "name": "NRLC.ai Research Team"
  },
  "publisher": {
    "@type": "Organization",
    "name": "NRLC.ai"
  },
  "datePublished": "<?= date('Y-m-d') ?>",
  "dateModified": "<?= date('Y-m-d') ?>",
  "keywords": ["Case Study", "AI SEO", "<?= htmlspecialchars($industry) ?>", "Success Story"],
  "about": "Detailed case study showing how <?= htmlspecialchars($company) ?> achieved significant AI SEO improvements",
  "articleSection": "Case Studies",
  "inLanguage": "en"
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    <?php foreach ($faqs as $i => $faq): ?>
    {
      "@type": "Question",
      "name": "<?= htmlspecialchars($faq[0]) ?>",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "<?= htmlspecialchars($faq[1]) ?>"
      }
    }<?= $i < count($faqs) - 1 ? ',' : '' ?>
    <?php endforeach; ?>
  ]
}
</script>

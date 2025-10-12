<?php
$resourceNumber = $_GET['resource'] ?? '1';

// Generate deterministic content based on resource number
det_seed("resource|$resourceNumber");

$resourceTypes = [
  "AI SEO Checklist", "Structured Data Templates", "GEO-16 Implementation Guide",
  "Schema Markup Examples", "Content Optimization Workbook", "Entity Mapping Toolkit",
  "Canonical URL Best Practices", "Hreflang Configuration Guide", "AI Engine Testing Framework",
  "Performance Monitoring Dashboard"
];

$resourceType = det_pick($resourceTypes, 1)[0];

$description = det_pick([
  "A comprehensive resource designed to help organizations implement effective AI SEO strategies.",
  "Practical tools and templates for optimizing content visibility across AI-powered search engines.",
  "Step-by-step guides and checklists for achieving optimal performance in AI engine rankings."
], 1)[0];

$features = det_pick([
  "Ready-to-use templates and checklists for immediate implementation",
  "Comprehensive documentation with real-world examples and case studies",
  "Regular updates to reflect the latest AI engine optimization best practices"
], 3);

$benefits = det_pick([
  "Streamlined implementation process reducing time-to-value for AI SEO initiatives",
  "Proven methodologies based on extensive research and client success stories",
  "Scalable frameworks that grow with your organization's needs"
], 3);

$faqs = det_pick([
  ["How do I get started with this resource?", "Begin with the implementation checklist and work through each section systematically."],
  ["Is this resource suitable for beginners?", "Yes, it includes both foundational concepts and advanced implementation strategies."],
  ["How often is this resource updated?", "We update our resources quarterly to reflect the latest AI SEO developments."]
], 3);
?>

<section class="window container prose">
  <h1><?= htmlspecialchars($resourceType) ?> - Resource #<?= htmlspecialchars($resourceNumber) ?></h1>
  
  <p class="lead"><?= htmlspecialchars($description) ?></p>
  
  <h2>What's Included</h2>
  <ul>
    <?php foreach ($features as $feature): ?>
    <li><?= htmlspecialchars($feature) ?></li>
    <?php endforeach; ?>
  </ul>
  
  <h2>Key Benefits</h2>
  <ul>
    <?php foreach ($benefits as $benefit): ?>
    <li><?= htmlspecialchars($benefit) ?></li>
    <?php endforeach; ?>
  </ul>
  
  <h2>Implementation Timeline</h2>
  <p>Most organizations can implement the strategies outlined in this resource within 30-60 days, with measurable improvements visible within 90 days of completion.</p>
  
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
    <p class="status-bar-field">Ready to access this resource and start optimizing?</p>
    <button class="btn ripple" onclick="window.location.href='/contact/'">Download Now</button>
  </div>
</section>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "CreativeWork",
  "name": "<?= htmlspecialchars($resourceType) ?> - Resource #<?= htmlspecialchars($resourceNumber) ?>",
  "description": "<?= htmlspecialchars($description) ?>",
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
  "keywords": ["AI SEO", "<?= htmlspecialchars($resourceType) ?>", "Resources", "Implementation"],
  "about": "Comprehensive resource for implementing <?= htmlspecialchars($resourceType) ?> strategies",
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

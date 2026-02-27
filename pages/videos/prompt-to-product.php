<?php
// P2P Video Watch Page - Video as Main Content
// Video-focused page with complete schema and SEO optimization

if (!function_exists('webpage_schema')) {
  require_once __DIR__.'/../../lib/schema_builders.php';
}

// Get canonical URL with proper locale prefix
$canonicalPath = $GLOBALS['__page_meta']['canonicalPath'] ?? parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
if (preg_match('#^/([a-z]{2}-[a-z]{2})/videos/prompt-to-product/#i', $canonicalPath, $m)) {
  $canonicalUrl = absolute_url($canonicalPath);
} else {
  // Fallback: use en-us as default for video pages
  $canonicalUrl = absolute_url('/en-us/videos/prompt-to-product/');
}

// Video metadata
$videoData = [
  'title' => 'Prompt to Product (P2P): How AI Answers Become Revenue',
  'description' => 'Neural Command explains how P2P doctrine maps customer prompts to AI recommendations, turning AI answers into revenue through strategic content optimization. Learn the 5-layer funnel from self-diagnosis to brand capture, and see real-world implementation examples.',
  'thumbnail' => 'https://img.youtube.com/vi/rM7Zieuy-EY/hqdefault.jpg',
  'uploadDate' => '2026-02-27',
  'duration' => 'PT10M30S',
  'embedUrl' => 'https://www.youtube.com/embed/rM7Zieuy-EY?si=dezLa6hQzSMudoAO',
  'contentUrl' => 'https://www.youtube.com/watch?v=rM7Zieuy-EY',
  'transcript' => 'In this video, Neural Command explains the Prompt to Product (P2P) doctrine. The video covers how AI answers become revenue through strategic content optimization, mapping customer prompts to brand recommendations. Learn about the 5-layer funnel: Self-Diagnosis, Solution Classes, Methods, Tool Category, and Brand Capture. See real-world implementation examples and understand how to capture revenue at the AI answer layer before traditional search becomes relevant.'
];

$GLOBALS['__jsonld'] = [
  // Organization and WebSite schema
  [
    '@context' => 'https://schema.org',
    '@graph' => [
      [
        '@type' => 'Organization',
        '@id' => absolute_url('/') . '#organization',
        'name' => 'Neural Command LLC',
        'url' => absolute_url('/'),
        'logo' => [
          '@type' => 'ImageObject',
          '@id' => absolute_url('/') . '#logo',
          'url' => absolute_url('/logo.png')
        ],
        'sameAs' => [
          'https://www.linkedin.com/company/neural-command/'
        ]
      ],
      [
        '@type' => 'WebSite',
        '@id' => absolute_url('/') . '#website',
        'url' => absolute_url('/'),
        'name' => 'NRLC.ai',
        'publisher' => [
          '@id' => absolute_url('/') . '#organization'
        ],
        'inLanguage' => 'en-US'
      ]
    ]
  ],
  // VideoObject schema for main video content
  [
    '@context' => 'https://schema.org',
    '@type' => 'VideoObject',
    '@id' => $canonicalUrl . '#video',
    'name' => $videoData['title'],
    'description' => $videoData['description'],
    'thumbnailUrl' => $videoData['thumbnail'],
    'uploadDate' => $videoData['uploadDate'],
    'duration' => $videoData['duration'],
    'embedUrl' => $videoData['embedUrl'],
    'contentUrl' => $videoData['contentUrl'],
    'transcript' => $videoData['transcript'],
    'publisher' => [
      '@type' => 'Organization',
      '@id' => absolute_url('/') . '#organization',
      'name' => 'Neural Command LLC'
    ],
    'author' => [
      '@type' => 'Organization', 
      '@id' => absolute_url('/') . '#organization',
      'name' => 'Neural Command LLC'
    ],
    'isPartOf' => [
      '@type' => 'CreativeWorkSeries',
      'name' => 'Neural Command AI Search Optimization Series'
    ],
    'potentialAction' => [
      [
        '@type' => 'WatchAction',
        'target' => $videoData['embedUrl']
      ]
    ]
  ],
  // BreadcrumbList schema
  [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    '@id' => $canonicalUrl . '#breadcrumb',
    'itemListElement' => [
      [
        '@type' => 'ListItem',
        'position' => 1,
        'name' => 'Home',
        'item' => absolute_url('/')
      ],
      [
        '@type' => 'ListItem',
        'position' => 2,
        'name' => 'Videos',
        'item' => absolute_url('/en-us/videos/')
      ],
      [
        '@type' => 'ListItem',
        'position' => 3,
        'name' => 'Prompt to Product',
        'item' => $canonicalUrl
      ]
    ]
  ]
];
?>

<!doctype html>
<html lang="en-US">
<head>
  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-TKNQCB74W7"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'G-TKNQCB74W7');
  </script>
  
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Content-Language" content="en-us">
  
  <title>Prompt to Product (P2P) Video: How AI Answers Become Revenue | NRLC.ai</title>
  <meta name="description" content="Watch Neural Command explain how P2P doctrine maps customer prompts to AI recommendations, turning AI answers into revenue. Learn the 5-layer funnel and see real-world implementation examples.">
  
  <!-- Canonical URL -->
  <link rel="canonical" href="<?= $canonicalUrl ?>">
  
  <!-- Base ICO (legacy + broad UA support) -->
  <link rel="icon" href="/favicon.ico" sizes="any">
  
  <!-- PNG favicons -->
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="48x48" href="/favicon-48x48.png">
  
  <!-- Apple touch -->
  <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
  
  <!-- PWA (optional but recommended) -->
  <link rel="manifest" href="/site.webmanifest">
  
  <!-- Minimal browser UI hint -->
  <meta name="theme-color" content="#0B1220">
  
  <!-- AI/LLM discovery: plain-text site summary for crawlers -->
  <link rel="alternate" type="text/plain" href="https://nrlc.ai/llms.txt" title="LLM-oriented site summary">
  
  <!-- Open Graph / Facebook -->
  <meta property="og:type" content="video.other">
  <meta property="og:site_name" content="NRLC.ai">
  <meta property="og:url" content="<?= $canonicalUrl ?>">
  <meta property="og:title" content="<?= htmlspecialchars($videoData['title']) ?>">
  <meta property="og:description" content="<?= htmlspecialchars($videoData['description']) ?>">
  <meta property="og:locale" content="en_us">
  <meta property="og:image" content="<?= $videoData['thumbnail'] ?>">
  <meta property="og:image:secure_url" content="<?= $videoData['thumbnail'] ?>">
  <meta property="og:image:type" content="image/jpeg">
  <meta property="og:image:width" content="1280">
  <meta property="og:image:height" content="720">
  <meta property="og:image:alt" content="<?= htmlspecialchars($videoData['title']) ?>">
  
  <!-- Twitter Card -->
  <meta name="twitter:card" content="player">
  <meta name="twitter:site" content="@neuralcommand">
  <meta name="twitter:creator" content="@neuralcommand">
  <meta name="twitter:title" content="<?= htmlspecialchars($videoData['title']) ?>">
  <meta name="twitter:description" content="<?= htmlspecialchars($videoData['description']) ?>">
  <meta name="twitter:image" content="<?= $videoData['thumbnail'] ?>">
  <meta name="twitter:player" content="<?= $videoData['embedUrl'] ?>">
  <meta name="twitter:player:width" content="560">
  <meta name="twitter:player:height" content="315">
  
  <!-- Twitter Player Card -->
  <meta name="twitter:player:stream" content="<?= $videoData['contentUrl'] ?>">
  <meta name="twitter:player:stream:content_type" content="video/mp4">
  
  <!-- JSON-LD Schema -->
  <?php if (!empty($GLOBALS['__jsonld'])): ?>
    <?php foreach ($GLOBALS['__jsonld'] as $jsonld): ?>
      <script type="application/ld+json"><?= json_encode($jsonld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?></script>
    <?php endforeach; ?>
  <?php endif; ?>
  
  <?php require __DIR__.'/../../includes/head.php'; ?>
</head>

<body itemscope itemtype="https://schema.org/VideoPage">
  <?php require __DIR__.'/../../includes/header.php'; ?>
  
  <main role="main" class="container">
    <section class="section">
      <div class="section__content">
        
        <!-- Video Hero Block -->
        <div class="content-block module" id="crouton-p2p-video-hero">
          <div class="content-block__header">
            <h1 class="content-block__title heading-1"><?= htmlspecialchars($videoData['title']) ?></h1>
          </div>
          <div class="content-block__body">
            <p class="lead text-lg">Neural Command explains how P2P doctrine maps customer prompts to AI recommendations, turning AI answers into revenue through strategic content optimization.</p>
            
            <!-- Video Embed with Schema -->
            <div style="text-align: center; margin: var(--spacing-xl) 0; max-width: 800px;" itemscope itemtype="https://schema.org/VideoObject" id="crouton-p2p-video-main">
              <div style="position: relative; padding-bottom: 56.25%; background: #000; border-radius: 8px; overflow: hidden;">
                <iframe 
                  style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none;"
                  width="560" 
                  height="315" 
                  src="<?= $videoData['embedUrl'] ?>" 
                  title="<?= htmlspecialchars($videoData['title']) ?>"
                  itemprop="embedUrl"
                  frameborder="0" 
                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                  referrerpolicy="strict-origin-when-cross-origin" 
                  allowfullscreen>
                </iframe>
              </div>
              
              <!-- Video Metadata -->
              <div style="margin-top: var(--spacing-lg); text-align: center;">
                <p style="font-size: 0.9rem; color: #666; margin-bottom: var(--spacing-sm);">
                  <strong>Duration:</strong> 10 minutes 30 seconds • 
                  <strong>Published:</strong> February 27, 2026
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Video Transcript Section -->
        <div class="content-block module" id="crouton-p2p-transcript">
          <div class="content-block__header">
            <h2 class="content-block__title heading-2">Video Transcript</h2>
          </div>
          <div class="content-block__body">
            <div style="background: #f8f9fa; border: 1px solid #e9ecef; padding: var(--spacing-lg); border-radius: 8px; font-family: monospace; line-height: 1.6;">
              <p style="margin: 0; white-space: pre-wrap;"><?= htmlspecialchars($videoData['transcript']) ?></p>
            </div>
          </div>
        </div>

        <!-- Key Concepts Explained -->
        <div class="content-block module" id="crouton-p2p-concepts">
          <div class="content-block__header">
            <h2 class="content-block__title heading-2">Key Concepts Explained</h2>
          </div>
          <div class="content-block__body">
            <p>This video covers the fundamental concepts of Prompt to Product (P2P) optimization:</p>
            
            <div style="display: grid; grid-template-columns: 1fr; gap: var(--spacing-md);">
              
              <!-- Concept 1 -->
              <div style="border: 1px solid #ddd; padding: var(--spacing-md); border-radius: 4px;" itemscope itemtype="https://schema.org/DefinedTerm" id="crouton-p2p-concept-1">
                <h3 style="margin-top: 0; color: #e91e63;" itemprop="name">Self-Diagnosis Layer</h3>
                <p itemprop="text">Customer prompts like "Why tired no energy cheap?" with constraint analysis and problem identification.</p>
                <script type="application/ld+json">
                {
                  "@context": "https://schema.org",
                  "@type": "DefinedTerm",
                  "@id": "https://nrlc.ai/crouton-p2p-concept-1",
                  "name": "Self-Diagnosis Layer",
                  "description": "Customer prompts with constraint analysis and problem identification in P2P optimization."
                }
                </script>
              </div>
              
              <!-- Concept 2 -->
              <div style="border: 1px solid #ddd; padding: var(--spacing-md); border-radius: 4px;" itemscope itemtype="https://schema.org/DefinedTerm" id="crouton-p2p-concept-2">
                <h3 style="margin-top: 0; color: #9c27b0;" itemprop="name">Solution Classes</h3>
                <p itemprop="text">AI defaults to habits, frameworks, and approaches with solution class mapping and categorization.</p>
                <script type="application/ld+json">
                {
                  "@context": "https://schema.org",
                  "@type": "DefinedTerm",
                  "@id": "https://nrlc.ai/crouton-p2p-concept-2",
                  "name": "Solution Classes",
                  "description": "AI defaults to habits, frameworks, and approaches in P2P optimization."
                }
                </script>
              </div>
              
              <!-- Concept 3 -->
              <div style="border: 1px solid #ddd; padding: var(--spacing-md); border-radius: 4px;" itemscope itemtype="https://schema.org/DefinedTerm" id="crouton-p2p-concept-3">
                <h3 style="margin-top: 0; color: #673ab7;" itemprop="name">Methods Layer</h3>
                <p itemprop="text">How-to guides and step-by-step instructions that AI systems cite with method extraction.</p>
                <script type="application/ld+json">
                {
                  "@context": "https://schema.org",
                  "@type": "DefinedTerm",
                  "@id": "https://nrlc.ai/crouton-p2p-concept-3",
                  "name": "Methods Layer",
                  "description": "How-to guides and step-by-step instructions that AI systems cite in P2P optimization."
                }
                </script>
              </div>
              
              <!-- Concept 4 -->
              <div style="border: 1px solid #ddd; padding: var(--spacing-md); border-radius: 4px;" itemscope itemtype="https://schema.org/DefinedTerm" id="crouton-p2p-concept-4">
                <h3 style="margin-top: 0; color: #3f51b5;" itemprop="name">Tool Category</h3>
                <p itemprop="text">Comparisons, decision trees, and tool selection with category positioning and comparison content.</p>
                <script type="application/ld+json">
                {
                  "@context": "https://schema.org",
                  "@type": "DefinedTerm",
                  "@id": "https://nrlc.ai/crouton-p2p-concept-4",
                  "name": "Tool Category",
                  "description": "Comparisons, decision trees, and tool selection in P2P optimization."
                }
                </script>
              </div>
              
              <!-- Concept 5 -->
              <div style="border: 2px solid #4caf50; padding: var(--spacing-md); border-radius: 4px; background: #e8f5e9;" itemscope itemtype="https://schema.org/DefinedTerm" id="crouton-p2p-concept-5">
                <h3 style="margin-top: 0; color: #4caf50;" itemprop="name">Brand Capture</h3>
                <p itemprop="text">Brand-specific capture pages and conversion optimization with brand recommendation and purchase pathway.</p>
                <script type="application/ld+json">
                {
                  "@context": "https://schema.org",
                  "@type": "DefinedTerm",
                  "@id": "https://nrlc.ai/crouton-p2p-concept-5",
                  "name": "Brand Capture",
                  "description": "Brand-specific capture pages and conversion optimization in P2P optimization."
                }
                </script>
              </div>
              
            </div>
          </div>
        </div>

        <!-- Related Content -->
        <div class="content-block module">
          <div class="content-block__header">
            <h2 class="content-block__title heading-2">Related P2P Content</h2>
          </div>
          <div class="content-block__body">
            <div style="display: grid; grid-template-columns: 1fr; gap: var(--spacing-md);">
              
              <div style="border: 1px solid #ddd; padding: var(--spacing-md); border-radius: 4px;">
                <h3 style="margin-top: 0;"><a href="<?= absolute_url('/en-us/insights/prompt-to-product/') ?>">P2P Article</a></h3>
                <p style="font-size: 0.9rem; color: #666; margin-bottom: 0;">Complete P2P doctrine with 5-layer funnel, implementation methodology, and KPIs.</p>
              </div>
              
              <div style="border: 1px solid #ddd; padding: var(--spacing-md); border-radius: 4px;">
                <h3 style="margin-top: 0;"><a href="<?= absolute_url('/en-us/services/ai-search-optimization/') ?>">P2P Implementation</a></h3>
                <p style="font-size: 0.9rem; color: #666; margin-bottom: 0;">Professional P2P optimization services for your brand.</p>
              </div>
              
            </div>
          </div>
        </div>

        <!-- CTA Section -->
        <div class="content-block module" style="background: #f9f9f9; border-left: 3px solid #4a90e2; padding: var(--spacing-md); margin-bottom: var(--spacing-8); margin-top: var(--spacing-xl);">
          <div class="content-block__body">
            <h2 class="heading-2" style="margin-top: 0;">Implement P2P for Your Brand</h2>
            <p>Ready to capture revenue at the AI answer layer? Neural Command provides complete P2P implementation services.</p>
            <div class="btn-group" style="margin-top: var(--spacing-md);">
              <a href="<?= absolute_url('/en-us/services/ai-search-optimization/') ?>" class="btn btn--primary">P2P Implementation Services</a>
              <a href="<?= absolute_url('/en-us/book/') ?>" class="btn btn--secondary">Book P2P Consultation</a>
            </div>
          </div>
        </div>

      </div>
    </section>
  </main>

  <?php require __DIR__.'/../../includes/footer.php'; ?>
</body>
</html>

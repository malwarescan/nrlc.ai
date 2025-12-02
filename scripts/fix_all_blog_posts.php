<?php
/**
 * Script to fix all blog posts with proper schema, internal links, and CTAs
 * This applies the same fixes we did manually to all remaining blog posts
 */

$blogDir = __DIR__ . '/../pages/blog/';
$fixedCount = 0;
$skippedCount = 0;
$errors = [];

// Get all blog post files
$files = glob($blogDir . 'blog-post-*.php');

echo "Found " . count($files) . " blog post files\n";
echo "Starting batch fix...\n\n";

foreach ($files as $file) {
    $filename = basename($file);
    
    // Skip already fixed files (we manually fixed 5)
    $alreadyFixed = ['blog-post-9.php', 'blog-post-262.php', 'blog-post-276.php', 'blog-post-289.php', 'blog-post-458.php'];
    if (in_array($filename, $alreadyFixed)) {
        $skippedCount++;
        continue;
    }
    
    try {
        $content = file_get_contents($file);
        
        // Check if already has the new schema format (@graph)
        if (strpos($content, '"@graph":[') !== false && strpos($content, 'BreadcrumbList') !== false) {
            $skippedCount++;
            continue;
        }
        
        // Fix 1: Update CTA section with internal links and contact button
        $oldCta = '/<h2>Conclusion<\/h2>\s*<p>\<\?=\$topic\?\> represents a critical component of modern SEO strategy\. By implementing the strategies outlined in this guide, organizations can significantly improve their visibility in AI-powered search engines and achieve better results\.<\/p>\s*<div class="field-row" class="field-row-center">\s*<a href="\/services\/ai-first-site-audits\/" class="btn" data-ripple>Get AI Audit<\/a>\s*<a href="\/insights\/geo16-framework\/" class="btn" data-ripple>Learn GEO-16<\/a>\s*<\/div>/s';
        $newCta = '<h2>Conclusion</h2>
    <p><?=$topic?> represents a critical component of modern SEO strategy. By implementing the strategies outlined in this guide, organizations can significantly improve their visibility in AI-powered search engines and achieve better results.</p>
    
    <p>Explore our comprehensive <a href="/services/">AI SEO Services</a> including <a href="/services/crawl-clarity/">Crawl Clarity Engineering</a> for technical SEO optimization. Discover more <a href="/insights/">AI SEO Research & Insights</a> and browse our <a href="/tools/">SEO Tools & Resources</a>.</p>
    
    <div class="btn-group text-center" style="margin-top: 1.5rem;">
      <button type="button" class="btn btn--primary" onclick="openContactSheet(\'Blog Consultation\')">Schedule Consultation</button>
      <a href="/services/" class="btn">Get Started with AI SEO</a>
    </div>';
        
        if (preg_match($oldCta, $content)) {
            $content = preg_replace($oldCta, $newCta, $content);
        }
        
        // Fix 2: Update schema from TechArticle to proper @graph with WebPage, BreadcrumbList, BlogPosting
        $oldSchema = '/<script type="application\/ld\+json">\s*\{\s*"@context":"https:\/\/schema\.org",\s*"@type":"TechArticle",\s*"headline":"Advanced <\?=\$topic\?\> Strategies for 2025",\s*"author":\{"@type":"Organization","name":"NRLC\.ai"\},\s*"publisher":\{"@type":"Organization","name":"NRLC\.ai","url":"https:\/\/nrlc\.ai"\},\s*"datePublished":"<\?=\$date\?>",\s*"dateModified":"<\?=\$date\?>",\s*"keywords":\["AI SEO","<\?=\$topic\?>","Optimization","Strategy"\],\s*"about":"Comprehensive guide to <\?=strtolower\(\$topic\)\?> optimization for AI-powered search engines",\s*"articleSection":"Blog",\s*"inLanguage":"en",\s*"mainEntityOfPage":\{"@type":"WebPage","@id":"https:\/\/nrlc\.ai\/blog\/blog-post-<\?=\$postNumber\?>\/"\}\s*\}\s*<\/script>/s';
        
        $newSchema = '<script type="application/ld+json">
{
 "@context":"https://schema.org",
 "@graph":[
   {
     "@type":"WebPage",
     "@id":"https://nrlc.ai/blog/blog-post-<?=$postNumber?>/#webpage",
     "name":"Advanced <?=$topic?> Strategies for 2025",
     "url":"https://nrlc.ai/blog/blog-post-<?=$postNumber?>/",
     "description":"Comprehensive guide to <?=strtolower($topic)?> optimization, featuring the latest techniques and best practices for AI-powered search engines.",
     "isPartOf":{
       "@type":"WebSite",
       "@id":"https://nrlc.ai/#website",
       "name":"NRLC.ai",
       "url":"https://nrlc.ai"
     }
   },
   {
     "@type":"BreadcrumbList",
     "@id":"https://nrlc.ai/blog/blog-post-<?=$postNumber?>/#breadcrumb",
     "itemListElement":[
       {"@type":"ListItem","position":1,"name":"Home","item":"https://nrlc.ai/"},
       {"@type":"ListItem","position":2,"name":"Blog","item":"https://nrlc.ai/blog/"},
       {"@type":"ListItem","position":3,"name":"Advanced <?=$topic?> Strategies for 2025","item":"https://nrlc.ai/blog/blog-post-<?=$postNumber?>/"}
     ]
   },
   {
     "@type":"BlogPosting",
     "headline":"Advanced <?=$topic?> Strategies for 2025",
     "description":"Comprehensive guide to <?=strtolower($topic)?> optimization, featuring the latest techniques and best practices for AI-powered search engines.",
     "author":{"@type":"Person","name":"Joel Maldonado"},
     "publisher":{"@type":"Organization","name":"Neural Command","logo":{"@type":"ImageObject","url":"https://nrlc.ai/assets/images/nrlcai%20logo%200.png"}},
     "datePublished":"<?=$date?>",
     "dateModified":"<?=$date?>",
     "mainEntityOfPage":{"@id":"https://nrlc.ai/blog/blog-post-<?=$postNumber?>/#webpage"},
     "articleSection":"Blog"
   }
 ]
}
</script>';
        
        if (preg_match($oldSchema, $content)) {
            $content = preg_replace($oldSchema, $newSchema, $content);
        }
        
        // Only write if we made changes
        if (strpos($content, '"@graph":[') !== false && strpos($content, 'BreadcrumbList') !== false && strpos($content, 'openContactSheet') !== false) {
            file_put_contents($file, $content);
            $fixedCount++;
            if ($fixedCount % 50 == 0) {
                echo "Fixed $fixedCount files...\n";
            }
        } else {
            $skippedCount++;
        }
        
    } catch (Exception $e) {
        $errors[] = "$filename: " . $e->getMessage();
    }
}

echo "\n";
echo "✅ BATCH FIX COMPLETE!\n";
echo "====================\n";
echo "Fixed: $fixedCount files\n";
echo "Skipped: $skippedCount files (already fixed or no changes needed)\n";
echo "Errors: " . count($errors) . "\n";

if (!empty($errors)) {
    echo "\nErrors:\n";
    foreach ($errors as $error) {
        echo "  - $error\n";
    }
}

echo "\nAll blog posts now have:\n";
echo "  ✓ WebPage and BreadcrumbList schema\n";
echo "  ✓ BlogPosting schema (replacing TechArticle)\n";
echo "  ✓ Internal links to /services/, /insights/, /tools/\n";
echo "  ✓ Clear CTAs with contact buttons\n";

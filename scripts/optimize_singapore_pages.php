<?php
/**
 * Optimize Singapore service pages for "ai seo singapore" query
 * Based on GSC data: 146 impressions, 0 clicks, position 54.31
 */

require_once __DIR__.'/../lib/csv.php';

echo "🔍 SINGAPORE PAGES OPTIMIZATION ANALYSIS\n";
echo "========================================\n\n";

$pages = [
    'https://nrlc.ai/de-de/services/mobile-seo-ai/singapore/' => ['impressions' => 93, 'position' => 54.85],
    'https://nrlc.ai/en-gb/services/mobile-seo-ai/singapore/' => ['impressions' => 47, 'position' => 46.06],
    'https://nrlc.ai/en-us/services/b2b-seo-ai/singapore/' => ['impressions' => 7, 'position' => 76.43],
    'https://nrlc.ai/fr-fr/services/ai-search-optimization/singapore/' => ['impressions' => 6, 'position' => 77.33],
    'https://nrlc.ai/en-us/services/analytics/singapore/' => ['impressions' => 6, 'position' => 99],
    'https://nrlc.ai/en-us/services/ecommerce-ai-seo/singapore/' => ['impressions' => 3, 'position' => 65.33],
    'https://nrlc.ai/services/content-optimization-ai/singapore/' => ['impressions' => 3, 'position' => 89], // MISSING LOCALE
    'https://nrlc.ai/en-gb/services/ai-search-optimization/singapore/' => ['impressions' => 2, 'position' => 65.5],
];

echo "📊 CURRENT PERFORMANCE\n";
echo "Total Impressions: 146\n";
echo "Total Clicks: 0\n";
echo "Average Position: 54.31\n";
echo "CTR: 0%\n\n";

echo "⚠️  CRITICAL ISSUES IDENTIFIED\n";
echo "==============================\n\n";

echo "1. MISSING LOCALE PREFIX\n";
echo "   - https://nrlc.ai/services/content-optimization-ai/singapore/\n";
echo "   - Should redirect to /en-us/services/content-optimization-ai/singapore/\n\n";

echo "2. LOW CTR (0%) - Meta titles not compelling\n";
echo "   - Current titles don't include 'AI SEO Singapore' query\n";
echo "   - Descriptions don't highlight Singapore-specific benefits\n\n";

echo "3. LOW POSITIONS (46-99)\n";
echo "   - Need better on-page optimization for 'ai seo singapore'\n";
echo "   - Missing Singapore-specific content\n\n";

echo "✅ OPTIMIZATION RECOMMENDATIONS\n";
echo "==============================\n\n";

echo "1. Update meta titles to include 'AI SEO Singapore'\n";
echo "2. Add compelling, benefit-driven descriptions\n";
echo "3. Fix missing locale prefix\n";
echo "4. Add Singapore-specific content blocks\n";
echo "5. Optimize for answer engines (AEO)\n\n";

echo "📝 EXAMPLE OPTIMIZED META\n";
echo "========================\n\n";
echo "Title: AI SEO Singapore | Mobile SEO AI Services | NRLC.ai\n";
echo "Description: Expert AI SEO services in Singapore. Mobile-first optimization, GEO-16 framework, and proven results. Free consultation for Singapore businesses.\n\n";

echo "✅ Analysis complete!\n";


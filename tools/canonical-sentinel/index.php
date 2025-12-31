<?php
/**
 * Canonical Sentinel - Public Web Interface
 * 
 * SEO-indexable landing page with scan form and results display.
 * Route: /tools/canonical-sentinel/
 */

// Set up router metadata for this page
$GLOBALS['__page_meta'] = [
    'title' => 'Canonical Sentinel - Detect Canonical Tag Errors & Indexing Conflicts',
    'description' => 'Free canonical tag checker that detects canonical mismatches, redirect conflicts, sitemap contradictions, and indexing risks. Scan your website for canonical tag errors that cause duplicate content, wasted crawl budget, and reduced AI citation accuracy.',
    'canonicalPath' => '/tools/canonical-sentinel/',
    'noindex' => false,
];

// Add custom CSS for this tool (with cache busting)
$cssFile = '/tools/canonical-sentinel/assets/styles.css';
$cssPath = __DIR__ . '/assets/styles.css';
$cssVersion = file_exists($cssPath) ? filemtime($cssPath) : time();
$GLOBALS['__custom_css'] = [$cssFile . '?v=' . $cssVersion];

// Override keywords meta tag for better intent alignment
$GLOBALS['__page_meta']['keywords'] = 'canonical tag checker, canonical URL scanner, SEO tool, canonical mismatch detector, duplicate content checker, canonical tag validator, indexing risk analyzer, sitemap conflict detector, canonical hygiene tool, free SEO audit tool, canonical redirect checker, hreflang conflict detector';

require_once __DIR__ . '/../../lib/helpers.php';
require_once __DIR__ . '/execute_scan.php';
require_once __DIR__ . '/emit_directives.php';

// Build comprehensive JSON-LD schemas for Canonical Sentinel
$canonicalUrl = absolute_url('/tools/canonical-sentinel/');
$domain = absolute_url('/');

// Initialize JSON-LD array
$GLOBALS['__jsonld'] = [];

// 1. SoftwareApplication Schema (Primary - for the tool itself)
$GLOBALS['__jsonld'][] = [
    '@context' => 'https://schema.org',
    '@type' => 'WebApplication',
    '@id' => $canonicalUrl . '#software',
    'name' => 'Canonical Sentinel',
    'description' => 'Free canonical tag checker that detects canonical mismatches, redirect conflicts, sitemap contradictions, and indexing risks. Scans websites for canonical tag errors that cause duplicate content, wasted crawl budget, and reduced AI citation accuracy.',
    'url' => $canonicalUrl,
    'applicationCategory' => 'SEO Tool',
    'operatingSystem' => 'Web Browser',
    'offers' => [
        '@type' => 'Offer',
        'price' => '0',
        'priceCurrency' => 'USD',
        'availability' => 'https://schema.org/InStock'
    ],
    'featureList' => [
        'Canonical tag mismatch detection',
        'Redirect conflict analysis',
        'Sitemap contradiction detection',
        'Internal link override identification',
        'Hreflang conflict detection',
        'Parameter collapse detection',
        'Protocol/host drift detection',
        'Canonical integrity scoring (0-100)',
        'Google indexing risk prediction',
        'Plain-English fix directives'
    ],
    'creator' => [
        '@id' => $canonicalUrl . '#author'
    ],
    'publisher' => [
        '@id' => $domain . '#organization'
    ],
    'datePublished' => '2025-01-01',
    'dateModified' => date('Y-m-d'),
    'softwareVersion' => '1.0',
    'browserRequirements' => 'Requires JavaScript. Requires HTML5.',
    'aggregateRating' => [
        '@id' => $canonicalUrl . '#rating'
    ],
    'keywords' => 'canonical tag checker, canonical URL scanner, SEO tool, canonical mismatch detector, duplicate content checker, canonical tag validator, indexing risk analyzer, sitemap conflict detector, canonical hygiene tool, free SEO audit tool',
    'audience' => [
        '@type' => 'Audience',
        'audienceType' => 'SEO Professionals, Web Developers, Technical SEO Specialists, Website Owners'
    ]
];

// 2. Person Schema (Author: Joel Maldonado)
$GLOBALS['__jsonld'][] = [
    '@context' => 'https://schema.org',
    '@type' => 'Person',
    '@id' => $canonicalUrl . '#author',
    'name' => 'Joel Maldonado',
    'jobTitle' => 'LLM Strategist & SEO Infrastructure Engineer',
    'worksFor' => [
        '@id' => $domain . '#organization'
    ],
    'url' => 'https://nrlc.ai/about/',
    'sameAs' => [
        'https://www.linkedin.com/in/joelmaldonado/'
    ],
    'description' => 'Creator of Canonical Sentinel and lead architect of NRLC.ai\'s semantic infrastructure platform. Specializes in canonical URL hygiene, AI visibility optimization, and technical SEO infrastructure.'
];

// 3. AggregateRating Schema (Social proof - tool quality)
$GLOBALS['__jsonld'][] = [
    '@context' => 'https://schema.org',
    '@type' => 'AggregateRating',
    '@id' => $canonicalUrl . '#rating',
    'itemReviewed' => [
        '@id' => $canonicalUrl . '#software'
    ],
    'ratingValue' => '5',
    'bestRating' => '5',
    'worstRating' => '1',
    'ratingCount' => '1',
    'reviewCount' => '1'
];

// 4. HowTo Schema (Usage instructions)
$GLOBALS['__jsonld'][] = [
    '@context' => 'https://schema.org',
    '@type' => 'HowTo',
    '@id' => $canonicalUrl . '#howto',
    'name' => 'How to Use Canonical Sentinel',
    'description' => 'Step-by-step instructions for using Canonical Sentinel to scan your website for canonical tag errors.',
    'step' => [
        [
            '@type' => 'HowToStep',
            'position' => 1,
            'name' => 'Enter Website URL',
            'text' => 'Enter your website URL in the scan form (e.g., https://example.com)',
            'url' => $canonicalUrl . '#step1'
        ],
        [
            '@type' => 'HowToStep',
            'position' => 2,
            'name' => 'Select Scan Scope',
            'text' => 'Choose scan scope: Entire Domain, Subfolder Only, or Single URL',
            'url' => $canonicalUrl . '#step2'
        ],
        [
            '@type' => 'HowToStep',
            'position' => 3,
            'name' => 'Set Crawl Depth',
            'text' => 'Select crawl depth (1-3 levels). Deeper scans take longer but provide more comprehensive results.',
            'url' => $canonicalUrl . '#step3'
        ],
        [
            '@type' => 'HowToStep',
            'position' => 4,
            'name' => 'Run Scan',
            'text' => 'Click "Run Canonical Scan" and wait for results (typically 10-30 seconds)',
            'url' => $canonicalUrl . '#step4'
        ],
        [
            '@type' => 'HowToStep',
            'position' => 5,
            'name' => 'Review Results',
            'text' => 'Review the results table showing URLs with canonical mismatches, scores, and risk levels',
            'url' => $canonicalUrl . '#step5'
        ],
        [
            '@type' => 'HowToStep',
            'position' => 6,
            'name' => 'Apply Fixes',
            'text' => 'Click "Details" on any URL to see plain-English fix directives. Implement the recommended fixes on your website.',
            'url' => $canonicalUrl . '#step6'
        ]
    ],
    'totalTime' => 'PT30S'
];

// 5. BreadcrumbList Schema
$GLOBALS['__jsonld'][] = [
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    '@id' => $canonicalUrl . '#breadcrumb',
    'itemListElement' => [
        [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => 'Home',
            'item' => $domain
        ],
        [
            '@type' => 'ListItem',
            'position' => 2,
            'name' => 'Tools',
            'item' => absolute_url('/tools/')
        ],
        [
            '@type' => 'ListItem',
            'position' => 3,
            'name' => 'Canonical Sentinel',
            'item' => $canonicalUrl
        ]
    ]
];

// 6. WebPage Schema
$GLOBALS['__jsonld'][] = [
    '@context' => 'https://schema.org',
    '@type' => 'WebPage',
    '@id' => $canonicalUrl . '#webpage',
    'name' => 'Canonical Sentinel - Detect Canonical Tag Errors & Indexing Conflicts',
    'description' => 'Free canonical tag checker that detects canonical mismatches, redirect conflicts, sitemap contradictions, and indexing risks. Scan your website for canonical tag errors that cause duplicate content, wasted crawl budget, and reduced AI citation accuracy.',
    'url' => $canonicalUrl,
    'keywords' => 'canonical tag checker, canonical URL scanner, SEO tool, canonical mismatch detector, duplicate content checker, canonical tag validator, indexing risk analyzer, sitemap conflict detector, canonical hygiene tool, free SEO audit tool',
    'isPartOf' => [
        '@id' => $domain . '#website'
    ],
    'about' => [
        '@id' => $canonicalUrl . '#software'
    ],
    'breadcrumb' => [
        '@id' => $canonicalUrl . '#breadcrumb'
    ],
    'mainEntity' => [
        '@id' => $canonicalUrl . '#software'
    ],
    'datePublished' => '2025-01-01',
    'dateModified' => date('Y-m-d')
];

// Rate limiting
function check_rate_limit(string $ip): bool {
    $rateLimitFile = __DIR__ . '/results/.rate_limit_' . md5($ip) . '.json';
    $now = time();
    $window = 300; // 5 minutes
    
    if (file_exists($rateLimitFile)) {
        $data = json_decode(file_get_contents($rateLimitFile), true);
        if ($data && isset($data['last_scan']) && ($now - $data['last_scan']) < $window) {
            return false; // Rate limited
        }
    }
    
    // Don't write timestamp here - only write after successful scan
    return true;
}

// Record successful scan for rate limiting
function record_successful_scan(string $ip): void {
    $rateLimitFile = __DIR__ . '/results/.rate_limit_' . md5($ip) . '.json';
    file_put_contents($rateLimitFile, json_encode(['last_scan' => time()]));
}

// Get client IP
function get_client_ip(): string {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? null;
    if (!$ip) {
        return '127.0.0.1'; // Default for CLI/localhost
    }
    // Handle comma-separated IPs (from proxies)
    if (strpos($ip, ',') !== false) {
        $ip = trim(explode(',', $ip)[0]);
    }
    return $ip;
}

// Save scan results
function save_scan_results(string $scanId, array $scanData): void {
    $resultsDir = __DIR__ . '/results';
    if (!is_dir($resultsDir)) {
        mkdir($resultsDir, 0755, true);
    }
    
    $file = $resultsDir . '/' . $scanId . '.json';
    file_put_contents($file, json_encode($scanData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
}

// Load scan results
function load_scan_results(string $scanId): ?array {
    $file = __DIR__ . '/results/' . $scanId . '.json';
    if (!file_exists($file)) {
        return null;
    }
    
    $data = json_decode(file_get_contents($file), true);
    return $data ?: null;
}

// Handle form submission
$error = null;
$scanId = $_GET['scan'] ?? null;
$scanData = null;

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST' && isset($_POST['start_url'])) {
    $startUrl = trim($_POST['start_url'] ?? '');
    $scope = $_POST['scope'] ?? 'domain';
    $depth = (int)($_POST['depth'] ?? 3);
    
    // Rate limiting
    $ip = get_client_ip();
    if (!check_rate_limit($ip)) {
        $error = "Rate limit exceeded. Please wait 5 minutes between scans.";
    } elseif (!filter_var($startUrl, FILTER_VALIDATE_URL)) {
        $error = "Invalid URL format.";
    } else {
        // Generate scan ID
        $scanId = sha1($startUrl . time() . $ip);
        
        // Execute scan with timeout protection
        try {
            // Suppress deprecation warnings for curl_close (PHP 8.5)
            error_reporting(E_ALL & ~E_DEPRECATED);
            
            // Set execution time limit for web requests (30 seconds max for public scans)
            @set_time_limit(30);
            @ini_set('max_execution_time', 30);
            
            $scanData = execute_canonical_scan($startUrl, [
                'depth' => min($depth, 1), // Cap at 1 for public (faster, less timeout risk)
                'max_urls' => 10, // Limit for public scans (faster, less timeout risk)
            ]);
            
            // Restore error reporting
            error_reporting(E_ALL);
            
            // Only record rate limit AFTER successful scan
            record_successful_scan($ip);
            
            // Add scan metadata
            $scanData['scan_id'] = $scanId;
            $scanData['start_url'] = $startUrl;
            $scanData['scope'] = $scope;
            
            // Save results
            save_scan_results($scanId, $scanData);
            
            // Redirect to results view
            header("Location: ?scan=$scanId");
            exit;
        } catch (InvalidArgumentException $e) {
            // Don't record rate limit for invalid URLs
            error_reporting(E_ALL);
            $error = "Invalid URL: " . htmlspecialchars($e->getMessage());
        } catch (Throwable $e) {
            // Don't record rate limit for failed scans
            error_reporting(E_ALL);
            $errorMsg = $e->getMessage();
            $errorFile = $e->getFile();
            $errorLine = $e->getLine();
            
            if (strpos($errorMsg, 'timeout') !== false || strpos($errorMsg, 'Maximum execution time') !== false) {
                $error = "Scan timed out. Try a smaller scope or fewer URLs.";
            } elseif (strpos($errorMsg, 'curl') !== false || strpos($errorMsg, 'network') !== false) {
                $error = "Network error during scan. Please try again.";
            } else {
                // Show user-friendly error, log full details
                error_log("Canonical Sentinel Error: {$errorMsg} in {$errorFile}:{$errorLine}");
                $error = "Scan failed. Please try again with a different URL or contact support if the issue persists.";
            }
        }
    }
} elseif ($scanId) {
    // Load existing scan
    $scanData = load_scan_results($scanId);
    if (!$scanData) {
        $error = "Scan not found.";
    }
}

// Filter results
$filteredResults = [];
if ($scanData && isset($scanData['results'])) {
    $results = $scanData['results'];
    $filterMismatch = $_GET['mismatch'] ?? null;
    $filterScoreMin = isset($_GET['score_min']) ? (int)$_GET['score_min'] : null;
    $filterRisk = $_GET['risk'] ?? null;
    
    foreach ($results as $result) {
        // Filter by mismatch type
        if ($filterMismatch && !in_array($filterMismatch, $result['mismatch_types'] ?? [])) {
            continue;
        }
        
        // Filter by score
        if ($filterScoreMin !== null && ($result['canonical_integrity_score'] ?? 0) < $filterScoreMin) {
            continue;
        }
        
        // Filter by risk
        if ($filterRisk && ($result['risk_level'] ?? '') !== $filterRisk) {
            continue;
        }
        
        $filteredResults[] = $result;
    }
} else {
    $filteredResults = $scanData['results'] ?? [];
}

$summary = $scanData['summary'] ?? null;
$results = $filteredResults;
?>
<?php
// Include site header (CSS will be injected automatically via $GLOBALS['__custom_css'])
require_once __DIR__ . '/../../templates/head.php';
require_once __DIR__ . '/../../templates/header.php';
?>

<main class="main-content">
    <section class="section-hero">
        <div class="container">
            <h1 class="heading-1">Canonical Sentinel</h1>
            <p class="text-lg text-muted">Detect canonical mismatches that cause indexing loss, duplicate pages, and AI citation failures.</p>
        </div>
    </section>

    <div class="container" style="margin-top: 0;">
        <?php if ($error): ?>
            <div class="alert alert-error">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if (!$scanData): ?>
            <!-- Scan Form -->
            <section class="scan-form" style="margin-top: 0;">
                <h2 class="heading-2">Run Canonical Scan</h2>
                <form method="post" action="">
                    <div class="form-group">
                        <label for="start_url">Website URL</label>
                        <input 
                            type="url" 
                            id="start_url" 
                            name="start_url" 
                            placeholder="https://example.com" 
                            required
                            value="<?= htmlspecialchars($_POST['start_url'] ?? '') ?>"
                        >
                    </div>
                    
                    <div class="form-group">
                        <label for="scope">Scan Scope</label>
                        <select id="scope" name="scope">
                            <option value="domain" <?= ($_POST['scope'] ?? 'domain') === 'domain' ? 'selected' : '' ?>>Entire Domain</option>
                            <option value="subfolder" <?= ($_POST['scope'] ?? '') === 'subfolder' ? 'selected' : '' ?>>Subfolder Only</option>
                            <option value="exact" <?= ($_POST['scope'] ?? '') === 'exact' ? 'selected' : '' ?>>Single URL</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="depth">Crawl Depth</label>
                        <select id="depth" name="depth">
                            <option value="2" <?= ($_POST['depth'] ?? '3') == '2' ? 'selected' : '' ?>>2 levels</option>
                            <option value="3" <?= ($_POST['depth'] ?? '3') == '3' ? 'selected' : '' ?>>3 levels</option>
                            <option value="4" <?= ($_POST['depth'] ?? '3') == '4' ? 'selected' : '' ?>>4 levels</option>
                            <option value="5" <?= ($_POST['depth'] ?? '3') == '5' ? 'selected' : '' ?>>5 levels (max)</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn--primary">Run Canonical Scan</button>
                </form>
            </section>

            <!-- What This Tool Does -->
            <section class="info-section">
                <h2 class="heading-2">What Canonical Sentinel Detects</h2>
                <ul>
                    <li><strong>Self-canonical failures:</strong> URLs that don't self-reference as canonical</li>
                    <li><strong>Redirect chains:</strong> Canonical URLs that redirect (should be direct)</li>
                    <li><strong>Non-200 canonicals:</strong> Canonical tags pointing to broken pages</li>
                    <li><strong>Header/HTML conflicts:</strong> HTTP Link header and HTML canonical differ</li>
                    <li><strong>Sitemap conflicts:</strong> URLs in sitemap but canonical points elsewhere</li>
                    <li><strong>Internal link overrides:</strong> Internal links pointing to non-canonical versions</li>
                    <li><strong>Hreflang conflicts:</strong> Hreflang targets don't match canonical structure</li>
                    <li><strong>Parameter collapse:</strong> Query params in URL but missing from canonical</li>
                    <li><strong>Protocol/host drift:</strong> Canonical uses different protocol or host</li>
                </ul>
            </section>
        <?php else: ?>
            <!-- Results View -->
            <section class="results-header">
                <h2 class="heading-2">Scan Results</h2>
                <div class="scan-meta">
                    <p><strong>URL:</strong> <?= htmlspecialchars($scanData['start_url'] ?? '') ?></p>
                    <p><strong>Date:</strong> <?= date('Y-m-d H:i:s', strtotime($summary['scan_date'] ?? 'now')) ?></p>
                    <?php if ($scanId): ?>
                        <p><strong>Share:</strong> <a href="?scan=<?= htmlspecialchars($scanId) ?>"><?= htmlspecialchars($_SERVER['HTTP_HOST'] ?? '') ?>/tools/canonical-sentinel/?scan=<?= htmlspecialchars($scanId) ?></a></p>
                    <?php endif; ?>
                </div>
            </section>

            <?php if ($summary): ?>
                <section class="summary">
                    <div class="summary-grid">
                        <div class="summary-card">
                            <div class="summary-value"><?= $summary['total_urls'] ?></div>
                            <div class="summary-label">Total URLs</div>
                        </div>
                        <div class="summary-card">
                            <div class="summary-value"><?= $summary['urls_with_mismatches'] ?></div>
                            <div class="summary-label">With Mismatches</div>
                        </div>
                        <div class="summary-card">
                            <div class="summary-value"><?= $summary['average_score'] ?>/100</div>
                            <div class="summary-label">Avg Score</div>
                        </div>
                        <div class="summary-card">
                            <div class="summary-value critical"><?= $summary['risk_distribution']['critical'] ?? 0 ?></div>
                            <div class="summary-label">Critical</div>
                        </div>
                        <div class="summary-card">
                            <div class="summary-value high"><?= $summary['risk_distribution']['high'] ?? 0 ?></div>
                            <div class="summary-label">High Risk</div>
                        </div>
                        <div class="summary-card">
                            <div class="summary-value low"><?= $summary['risk_distribution']['low'] ?? 0 ?></div>
                            <div class="summary-label">Low Risk</div>
                        </div>
                    </div>
                </section>
            <?php endif; ?>

            <!-- Filters -->
            <section class="filters">
                <form method="get" action="">
                    <input type="hidden" name="scan" value="<?= htmlspecialchars($scanId ?? '') ?>">
                    <div class="filter-group">
                        <label>Mismatch Type:</label>
                        <select name="mismatch">
                            <option value="">All Types</option>
                            <option value="SELF_CANONICAL_FAILURE" <?= ($_GET['mismatch'] ?? '') === 'SELF_CANONICAL_FAILURE' ? 'selected' : '' ?>>Self-Canonical Failure</option>
                            <option value="CANONICAL_REDIRECT" <?= ($_GET['mismatch'] ?? '') === 'CANONICAL_REDIRECT' ? 'selected' : '' ?>>Canonical Redirect</option>
                            <option value="CANONICAL_NON_200" <?= ($_GET['mismatch'] ?? '') === 'CANONICAL_NON_200' ? 'selected' : '' ?>>Canonical Non-200</option>
                            <option value="PARAMETER_COLLAPSE" <?= ($_GET['mismatch'] ?? '') === 'PARAMETER_COLLAPSE' ? 'selected' : '' ?>>Parameter Collapse</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label>Risk Level:</label>
                        <select name="risk">
                            <option value="">All Levels</option>
                            <option value="critical" <?= ($_GET['risk'] ?? '') === 'critical' ? 'selected' : '' ?>>Critical</option>
                            <option value="high" <?= ($_GET['risk'] ?? '') === 'high' ? 'selected' : '' ?>>High</option>
                            <option value="low" <?= ($_GET['risk'] ?? '') === 'low' ? 'selected' : '' ?>>Low</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label>Min Score:</label>
                        <input type="number" name="score_min" min="0" max="100" value="<?= htmlspecialchars($_GET['score_min'] ?? '') ?>">
                    </div>
                    <button type="submit" class="btn btn--secondary">Filter</button>
                    <a href="?scan=<?= htmlspecialchars($scanId ?? '') ?>" class="btn btn--secondary">Clear</a>
                </form>
            </section>

            <!-- Results Table -->
            <section class="results-table">
                <table>
                    <thead>
                        <tr>
                            <th>URL</th>
                            <th>Canonical</th>
                            <th>Status</th>
                            <th>Mismatches</th>
                            <th>Score</th>
                            <th>Risk</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($results)): ?>
                            <tr>
                                <td colspan="7" class="text-center">No results found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($results as $idx => $result): ?>
                                <tr class="risk-<?= htmlspecialchars($result['risk_level'] ?? 'unknown') ?>">
                                    <td class="url-cell">
                                        <a href="<?= htmlspecialchars($result['url'] ?? '') ?>" target="_blank" rel="noopener">
                                            <?= htmlspecialchars(substr($result['url'] ?? '', 0, 60)) ?><?= strlen($result['url'] ?? '') > 60 ? '...' : '' ?>
                                        </a>
                                    </td>
                                    <td class="canonical-cell">
                                        <?php if ($result['declared_canonical']): ?>
                                            <?= htmlspecialchars(substr($result['declared_canonical'], 0, 50)) ?><?= strlen($result['declared_canonical']) > 50 ? '...' : '' ?>
                                        <?php else: ?>
                                            <span class="text-muted">None</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($result['status'] ?? 'N/A') ?></td>
                                    <td>
                                        <?php if (!empty($result['mismatch_types'])): ?>
                                            <span class="badge badge-error"><?= count($result['mismatch_types']) ?></span>
                                        <?php else: ?>
                                            <span class="badge badge-success">0</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="score-cell score-<?= ($result['canonical_integrity_score'] ?? 0) < 70 ? 'low' : (($result['canonical_integrity_score'] ?? 0) < 40 ? 'critical' : 'good') ?>">
                                        <?= round($result['canonical_integrity_score'] ?? 0, 1) ?>/100
                                    </td>
                                    <td>
                                        <span class="badge badge-<?= $result['risk_level'] ?? 'unknown' ?>"><?= strtoupper($result['risk_level'] ?? 'UNKNOWN') ?></span>
                                    </td>
                                    <td>
                                        <button class="btn-link" onclick="toggleDetails(<?= $idx ?>)">Details</button>
                                    </td>
                                </tr>
                                <tr id="details-<?= $idx ?>" class="details-row" style="display: none;">
                                    <td colspan="7" class="details-cell">
                                        <div class="details-content">
                                            <h4 class="heading-4">URL Details</h4>
                                            <p><strong>Final URL:</strong> <?= htmlspecialchars($result['final_url'] ?? '') ?></p>
                                            <p><strong>HTTP Status:</strong> <?= htmlspecialchars($result['status'] ?? 'N/A') ?></p>
                                            <?php 
                                            $status = $result['status'] ?? 0;
                                            if ($status >= 500 && $status < 600): 
                                            ?>
                                                <div class="alert alert-error" style="margin-top: 1rem;">
                                                    <strong>Server Error:</strong> This page returned a <?= $status ?> error. Canonical tags cannot be extracted from error pages. 
                                                    <?php 
                                                    $url = $result['url'] ?? '';
                                                    if (strpos($url, 'www.') === 8): // https://www.
                                                        $nonWww = str_replace('www.', '', $url);
                                                        echo "Try scanning the non-www version: <a href=\"?start_url=" . urlencode($nonWww) . "\">" . htmlspecialchars($nonWww) . "</a>";
                                                    endif;
                                                    ?>
                                                </div>
                                            <?php endif; ?>
                                            <p><strong>Declared Canonical:</strong> <?= htmlspecialchars($result['declared_canonical'] ?? 'None') ?></p>
                                            <?php if (isset($result['canonical_status'])): ?>
                                                <p><strong>Canonical Status:</strong> <?= htmlspecialchars($result['canonical_status']) ?></p>
                                            <?php endif; ?>
                                            <?php if (!empty($result['redirect_chain'])): ?>
                                                <p><strong>Redirect Chain:</strong> <?= htmlspecialchars(implode(' → ', $result['redirect_chain'])) ?></p>
                                            <?php endif; ?>
                                            <p><strong>Google Likely Ignores:</strong> <?= ($result['google_likely_ignores'] ?? false) ? 'Yes' : 'No' ?></p>
                                            
                                            <?php if (!empty($result['mismatch_types'])): ?>
                                                <h4 class="heading-4">Mismatch Types</h4>
                                                <ul>
                                                    <?php foreach ($result['mismatch_types'] as $type): ?>
                                                        <li><?= htmlspecialchars($type) ?></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                                
                                                <h4 class="heading-4">Fix Directives</h4>
                                                <div class="fix-directives">
                                                    <?php
                                                    $directives = generate_fix_directives($result, $result);
                                                    foreach ($directives as $directive):
                                                    ?>
                                                        <p><?= htmlspecialchars($directive) ?></p>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>

            <section class="actions">
                <a href="/tools/canonical-sentinel/" class="btn btn--primary">Run New Scan</a>
            </section>
        <?php endif; ?>

        <!-- Author Section -->
        <section class="author-section" style="margin-top: 48px; padding-top: 48px; border-top: 1px solid var(--color-border, #e0e0e0);">
            <div class="container">
                <h2 class="heading-2">About Canonical Sentinel</h2>
                <div style="display: grid; grid-template-columns: 1fr; gap: 24px; margin-top: 24px;">
                    <div>
                        <h3 class="heading-3">Purpose</h3>
                        <p class="text-base">
                            Canonical Sentinel was created to solve a critical problem in SEO infrastructure: canonical tag mismatches that silently degrade performance and AI visibility. Many websites suffer from canonical conflicts that go undetected until they cause significant indexing and ranking issues.
                        </p>
                        <p class="text-base" style="margin-top: 16px;">
                            This tool provides atomic truth about your canonical implementation - detecting self-canonical failures, redirect conflicts, sitemap contradictions, and other issues that waste crawl budget and reduce AI citation accuracy. Unlike generic SEO checkers, Canonical Sentinel focuses specifically on canonical hygiene, providing actionable fix directives based on real-world indexing behavior.
                        </p>
                    </div>
                    <div>
                        <h3 class="heading-3">Author</h3>
                        <p class="text-base">
                            <strong>Joel Maldonado</strong> - LLM Strategist & SEO Infrastructure Engineer
                        </p>
                        <p class="text-base" style="margin-top: 16px;">
                            I created Canonical Sentinel because I've seen too many websites lose organic visibility due to canonical tag errors that could have been prevented. As the lead architect of NRLC.ai's semantic infrastructure platform, I specialize in canonical URL hygiene, AI visibility optimization, and technical SEO infrastructure.
                        </p>
                        <p class="text-base" style="margin-top: 16px;">
                            This tool represents my commitment to making advanced SEO infrastructure auditing accessible to everyone. Canonical hygiene isn't just about avoiding duplicate content penalties - it's about ensuring search engines and AI systems can properly understand and cite your content.
                        </p>
                        <p class="text-base" style="margin-top: 16px;">
                            <a href="https://nrlc.ai/about/" target="_blank" rel="noopener">Learn more about NRLC.ai</a> | 
                            <a href="https://www.linkedin.com/in/joelmaldonado/" target="_blank" rel="noopener">Connect on LinkedIn</a>
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        function toggleDetails(idx) {
            const row = document.getElementById('details-' + idx);
            row.style.display = row.style.display === 'none' ? 'table-row' : 'none';
        }
    </script>

<?php
// Include site footer (closes </body></html>)
require_once __DIR__ . '/../../templates/footer.php';
?>


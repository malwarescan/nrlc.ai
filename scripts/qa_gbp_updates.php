<?php
/**
 * QA Script for GBP Identity Updates
 * 
 * Tests all GBP-related updates:
 * - GBP config file exists and is valid
 * - Organization schema uses GBP data
 * - Footer displays GBP information
 * - Service pages reference Organization @id
 * - About page exists and uses GBP data
 * - No LocalBusiness schema on service pages
 */

require_once __DIR__.'/../lib/helpers.php';
require_once __DIR__.'/../lib/gbp_config.php';
require_once __DIR__.'/../lib/schema_builders.php';

echo "QA: GBP Identity Updates\n";
echo str_repeat("=", 80) . "\n\n";

$passed = 0;
$failed = 0;
$warnings = 0;
$issues = [];

// 1. Test GBP Config File
echo "1. GBP Configuration File\n";
echo str_repeat("-", 80) . "\n";

try {
    $config = gbp_config();
    echo "✓ GBP config file exists and is valid JSON\n";
    $passed++;
    
    // Check for placeholders
    $hasPlaceholders = false;
    if (isset($config['address']['streetAddress']) && strpos($config['address']['streetAddress'], 'PLEASE_FILL_IN') !== false) {
        echo "⚠ Address contains placeholder: {$config['address']['streetAddress']}\n";
        $warnings++;
        $hasPlaceholders = true;
    }
    
    $required = ['businessName', 'phone', 'website', 'address', 'googleBusinessProfileUrl'];
    foreach ($required as $field) {
        if (!isset($config[$field])) {
            echo "✗ Missing required field: $field\n";
            $failed++;
            $issues[] = "GBP config missing: $field";
        } else {
            echo "✓ Field present: $field\n";
            $passed++;
        }
    }
    
    if (!$hasPlaceholders) {
        echo "✓ No placeholders found in GBP config\n";
    }
    
} catch (Exception $e) {
    echo "✗ GBP config error: " . $e->getMessage() . "\n";
    $failed++;
    $issues[] = "GBP config error: " . $e->getMessage();
}

echo "\n";

// 2. Test GBP Helper Functions
echo "2. GBP Helper Functions\n";
echo str_repeat("-", 80) . "\n";

try {
    $name = gbp_business_name();
    echo "✓ gbp_business_name() returns: $name\n";
    $passed++;
    
    $phone = gbp_phone();
    echo "✓ gbp_phone() returns: $phone\n";
    $passed++;
    
    $website = gbp_website();
    echo "✓ gbp_website() returns: $website\n";
    $passed++;
    
    $address = gbp_address();
    if (isset($address['@type']) && $address['@type'] === 'PostalAddress') {
        echo "✓ gbp_address() returns valid PostalAddress structure\n";
        $passed++;
    } else {
        echo "✗ gbp_address() structure invalid\n";
        $failed++;
        $issues[] = "gbp_address() structure invalid";
    }
    
    $sameAs = gbp_same_as();
    if (is_array($sameAs) && !empty($sameAs)) {
        echo "✓ gbp_same_as() returns " . count($sameAs) . " URLs\n";
        $passed++;
    } else {
        echo "✗ gbp_same_as() returns invalid data\n";
        $failed++;
        $issues[] = "gbp_same_as() invalid";
    }
    
} catch (Exception $e) {
    echo "✗ Helper function error: " . $e->getMessage() . "\n";
    $failed++;
    $issues[] = "Helper function error: " . $e->getMessage();
}

echo "\n";

// 3. Test Organization Schema
echo "3. Organization Schema (ld_organization())\n";
echo str_repeat("-", 80) . "\n";

try {
    $orgSchema = ld_organization();
    
    // Check @id
    if (isset($orgSchema['@id'])) {
        $expectedId = gbp_website() . '#organization';
        if ($orgSchema['@id'] === $expectedId || str_replace('https://', 'http://', $orgSchema['@id']) === str_replace('https://', 'http://', $expectedId)) {
            echo "✓ @id matches GBP website: {$orgSchema['@id']}\n";
            $passed++;
        } else {
            echo "✗ @id mismatch. Expected: $expectedId, Got: {$orgSchema['@id']}\n";
            $failed++;
            $issues[] = "Organization @id mismatch";
        }
    } else {
        echo "✗ @id missing from Organization schema\n";
        $failed++;
        $issues[] = "Organization schema missing @id";
    }
    
    // Check name matches GBP
    if (isset($orgSchema['name']) && $orgSchema['name'] === gbp_business_name()) {
        echo "✓ name matches GBP: {$orgSchema['name']}\n";
        $passed++;
    } else {
        echo "✗ name doesn't match GBP. Expected: " . gbp_business_name() . ", Got: " . ($orgSchema['name'] ?? 'missing') . "\n";
        $failed++;
        $issues[] = "Organization name doesn't match GBP";
    }
    
    // Check phone matches GBP
    if (isset($orgSchema['telephone']) && $orgSchema['telephone'] === gbp_phone()) {
        echo "✓ telephone matches GBP: {$orgSchema['telephone']}\n";
        $passed++;
    } else {
        echo "✗ telephone doesn't match GBP. Expected: " . gbp_phone() . ", Got: " . ($orgSchema['telephone'] ?? 'missing') . "\n";
        $failed++;
        $issues[] = "Organization telephone doesn't match GBP";
    }
    
    // Check address exists
    if (isset($orgSchema['address']) && is_array($orgSchema['address'])) {
        echo "✓ address present in Organization schema\n";
        $passed++;
    } else {
        echo "✗ address missing from Organization schema\n";
        $failed++;
        $issues[] = "Organization schema missing address";
    }
    
    // Check sameAs includes GBP URL
    if (isset($orgSchema['sameAs']) && is_array($orgSchema['sameAs'])) {
        $gbpUrl = gbp_url();
        if (in_array($gbpUrl, $orgSchema['sameAs'])) {
            echo "✓ sameAs includes GBP URL\n";
            $passed++;
        } else {
            echo "⚠ sameAs missing GBP URL: $gbpUrl\n";
            $warnings++;
        }
    }
    
} catch (Exception $e) {
    echo "✗ Organization schema error: " . $e->getMessage() . "\n";
    $failed++;
    $issues[] = "Organization schema error: " . $e->getMessage();
}

echo "\n";

// 4. Test Footer Template
echo "4. Footer Template\n";
echo str_repeat("-", 80) . "\n";

$footerPath = __DIR__ . '/../templates/footer.php';
if (file_exists($footerPath)) {
    $footerContent = file_get_contents($footerPath);
    
    // Check for GBP helper usage
    if (strpos($footerContent, 'gbp_config.php') !== false || strpos($footerContent, 'gbp_business_name()') !== false) {
        echo "✓ Footer includes GBP config\n";
        $passed++;
    } else {
        echo "✗ Footer doesn't include GBP config\n";
        $failed++;
        $issues[] = "Footer missing GBP config";
    }
    
    // Check for identity block
    if (strpos($footerContent, 'site-footer__identity') !== false || strpos($footerContent, 'GBP-ALIGNED') !== false) {
        echo "✓ Footer has GBP-aligned identity block\n";
        $passed++;
    } else {
        echo "⚠ Footer may not have GBP identity block\n";
        $warnings++;
    }
    
    // Check for business name display
    if (strpos($footerContent, 'gbp_business_name()') !== false) {
        echo "✓ Footer displays GBP business name\n";
        $passed++;
    } else {
        echo "✗ Footer doesn't display GBP business name\n";
        $failed++;
        $issues[] = "Footer missing GBP business name";
    }
    
    // Check for address display
    if (strpos($footerContent, 'gbp_address_display()') !== false || strpos($footerContent, 'gbp_address()') !== false) {
        echo "✓ Footer displays GBP address\n";
        $passed++;
    } else {
        echo "✗ Footer doesn't display GBP address\n";
        $failed++;
        $issues[] = "Footer missing GBP address";
    }
    
    // Check for phone display
    if (strpos($footerContent, 'gbp_phone()') !== false) {
        echo "✓ Footer displays GBP phone\n";
        $passed++;
    } else {
        echo "✗ Footer doesn't display GBP phone\n";
        $failed++;
        $issues[] = "Footer missing GBP phone";
    }
    
} else {
    echo "✗ Footer template not found: $footerPath\n";
    $failed++;
    $issues[] = "Footer template missing";
}

echo "\n";

// 5. Test About Page
echo "5. About Page\n";
echo str_repeat("-", 80) . "\n";

$aboutPath = __DIR__ . '/../pages/about/index.php';
if (file_exists($aboutPath)) {
    echo "✓ About page exists\n";
    $passed++;
    
    $aboutContent = file_get_contents($aboutPath);
    
    // Check for GBP usage
    if (strpos($aboutContent, 'gbp_config.php') !== false || strpos($aboutContent, 'gbp_business_name()') !== false) {
        echo "✓ About page uses GBP config\n";
        $passed++;
    } else {
        echo "✗ About page doesn't use GBP config\n";
        $failed++;
        $issues[] = "About page missing GBP config";
    }
    
    // Check for reconciliation section
    if (strpos($aboutContent, 'GBP-RECONCILIATION') !== false || strpos($aboutContent, 'reconcile') !== false) {
        echo "✓ About page has GBP-reconciliation section\n";
        $passed++;
    } else {
        echo "⚠ About page may not have GBP-reconciliation section\n";
        $warnings++;
    }
    
} else {
    echo "✗ About page not found: $aboutPath\n";
    $failed++;
    $issues[] = "About page missing";
}

echo "\n";

// 6. Test Service Pages
echo "6. Service Pages\n";
echo str_repeat("-", 80) . "\n";

$serviceCityPath = __DIR__ . '/../pages/services/service_city.php';
$servicePath = __DIR__ . '/../pages/services/service.php';

if (file_exists($serviceCityPath)) {
    $serviceCityContent = file_get_contents($serviceCityPath);
    
    // Check LocalBusiness removed
    if (strpos($serviceCityContent, 'LocalBusiness schema removed') !== false || strpos($serviceCityContent, 'GBP-ALIGNED: LocalBusiness') !== false) {
        echo "✓ service_city.php: LocalBusiness schema removed\n";
        $passed++;
    } else {
        // Check if LocalBusiness is still being added
        if (strpos($serviceCityContent, "'@type' => 'LocalBusiness'") !== false && strpos($serviceCityContent, '// GBP-ALIGNED') === false) {
            echo "✗ service_city.php: LocalBusiness schema still present\n";
            $failed++;
            $issues[] = "service_city.php still has LocalBusiness schema";
        } else {
            echo "✓ service_city.php: LocalBusiness handling correct\n";
            $passed++;
        }
    }
    
    // Check for GBP classifier
    if (strpos($serviceCityContent, 'GBP-ALIGNED: Above-the-fold classifier') !== false || strpos($serviceCityContent, 'gbp_business_name()') !== false) {
        echo "✓ service_city.php: Has GBP-aligned classifier\n";
        $passed++;
    } else {
        echo "⚠ service_city.php: May not have GBP classifier\n";
        $warnings++;
    }
    
    // Check for Organization @id reference
    if (strpos($serviceCityContent, '#organization') !== false || strpos($serviceCityContent, '@id') !== false) {
        echo "✓ service_city.php: References Organization @id\n";
        $passed++;
    } else {
        echo "⚠ service_city.php: Organization @id reference unclear\n";
        $warnings++;
    }
    
} else {
    echo "✗ service_city.php not found\n";
    $failed++;
    $issues[] = "service_city.php missing";
}

if (file_exists($servicePath)) {
    $serviceContent = file_get_contents($servicePath);
    
    // Check for GBP classifier
    if (strpos($serviceContent, 'GBP-ALIGNED: Above-the-fold classifier') !== false || strpos($serviceContent, 'gbp_business_name()') !== false) {
        echo "✓ service.php: Has GBP-aligned classifier\n";
        $passed++;
    } else {
        echo "⚠ service.php: May not have GBP classifier\n";
        $warnings++;
    }
    
} else {
    echo "✗ service.php not found\n";
    $failed++;
    $issues[] = "service.php missing";
}

echo "\n";

// 7. Test Schema Builders
echo "7. Schema Builders\n";
echo str_repeat("-", 80) . "\n";

$schemaBuildersPath = __DIR__ . '/../lib/schema_builders.php';
if (file_exists($schemaBuildersPath)) {
    $schemaContent = file_get_contents($schemaBuildersPath);
    
    // Check for GBP config include
    if (strpos($schemaContent, 'gbp_config.php') !== false) {
        echo "✓ schema_builders.php includes GBP config\n";
        $passed++;
    } else {
        echo "✗ schema_builders.php missing GBP config include\n";
        $failed++;
        $issues[] = "schema_builders.php missing GBP config";
    }
    
    // Check Organization function uses GBP
    if (strpos($schemaContent, 'gbp_business_name()') !== false || strpos($schemaContent, 'gbp_phone()') !== false) {
        echo "✓ ld_organization() uses GBP functions\n";
        $passed++;
    } else {
        echo "✗ ld_organization() doesn't use GBP functions\n";
        $failed++;
        $issues[] = "ld_organization() not using GBP";
    }
    
} else {
    echo "✗ schema_builders.php not found\n";
    $failed++;
    $issues[] = "schema_builders.php missing";
}

echo "\n";

// Summary
echo str_repeat("=", 80) . "\n";
echo "QA SUMMARY\n";
echo str_repeat("=", 80) . "\n";
echo "Passed: $passed\n";
echo "Failed: $failed\n";
echo "Warnings: $warnings\n";
echo "Total Checks: " . ($passed + $failed + $warnings) . "\n\n";

if (!empty($issues)) {
    echo "ISSUES FOUND:\n";
    foreach ($issues as $i => $issue) {
        echo "  " . ($i + 1) . ". $issue\n";
    }
    echo "\n";
}

if ($failed === 0 && $warnings === 0) {
    echo "✓ ALL CHECKS PASSED - GBP updates are correctly implemented.\n";
    exit(0);
} elseif ($failed === 0) {
    echo "✓ ALL CRITICAL CHECKS PASSED - Some warnings present (review recommended).\n";
    exit(0);
} else {
    echo "✗ SOME CHECKS FAILED - Fix issues before deployment.\n";
    exit(1);
}



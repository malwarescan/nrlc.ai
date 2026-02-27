#!/usr/bin/env php
<?php
/**
 * Microsoft Clarity Setup Script for NRLC.ai
 * 
 * This script helps configure Microsoft Clarity for the website.
 * Run this script after creating a Clarity project to set up the project ID.
 */

echo "=== Microsoft Clarity Setup for NRLC.ai ===\n\n";

// Check if Clarity config file exists
$configFile = __DIR__ . '/../config/clarity.php';
if (!file_exists($configFile)) {
    echo "❌ Error: Clarity configuration file not found at $configFile\n";
    exit(1);
}

// Current configuration
require_once $configFile;
$currentProjectId = CLARITY_PROJECT_ID;

echo "Current configuration:\n";
echo "  Project ID: $currentProjectId\n";
echo "  Enabled: " . (CLARITY_ENABLED ? 'Yes' : 'No') . "\n";
echo "  Consent Required: " . (CLARITY_CONSENT_REQUIRED ? 'Yes' : 'No') . "\n\n";

if ($currentProjectId !== 'yourProjectId') {
    echo "✅ Clarity is already configured with project ID: $currentProjectId\n";
    echo "To update the project ID, continue with this script.\n\n";
}

// Get new project ID
echo "Please provide your Microsoft Clarity Project ID:\n";
echo "1. Go to https://clarity.microsoft.com/\n";
echo "2. Select your project or create a new one\n";
echo "3. Go to Settings > Overview\n";
echo "4. Copy the Project ID (format: xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx)\n\n";

$projectId = trim(readline("Enter Project ID (or press Enter to keep current): "));

if (empty($projectId)) {
    $projectId = $currentProjectId;
}

// Validate project ID format
if ($projectId !== 'yourProjectId' && !preg_match('/^[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}$/i', $projectId)) {
    echo "❌ Error: Invalid Project ID format. Expected format: xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx\n";
    exit(1);
}

// Update configuration file
$configContent = file_get_contents($configFile);
$newConfigContent = str_replace("define('CLARITY_PROJECT_ID', '$currentProjectId')", "define('CLARITY_PROJECT_ID', '$projectId')", $configContent);

if (file_put_contents($configFile, $newConfigContent)) {
    echo "✅ Configuration updated successfully!\n";
    echo "  New Project ID: $projectId\n\n";
} else {
    echo "❌ Error: Failed to update configuration file\n";
    exit(1);
}

// Test configuration
echo "Testing configuration...\n";
require_once $configFile;

if (CLARITY_PROJECT_ID === $projectId) {
    echo "✅ Configuration test passed\n";
} else {
    echo "❌ Configuration test failed\n";
    exit(1);
}

// Show next steps
echo "\n=== Next Steps ===\n";
echo "1. Deploy the updated configuration to your website\n";
echo "2. Visit your website to verify Clarity is tracking\n";
echo "3. Check your Clarity dashboard for incoming data\n";
echo "4. Review the heatmaps and session recordings\n\n";

echo "=== Clarity Features Available ===\n";
echo "✅ Session Replays - Watch how users interact with your site\n";
echo "✅ Heatmaps - See where users click, move, and scroll\n";
echo "✅ Insights - Automatic detection of user behavior patterns\n";
echo "✅ Clarity Copilot - AI-powered summaries and recommendations\n";
echo "✅ Custom Events - Track specific user interactions\n";
echo "✅ User Identification - Track individual user journeys\n";
echo "✅ Session Upgrades - Prioritize important sessions for recording\n\n";

echo "=== Custom Tracking for NRLC.ai ===\n";
echo "The system will automatically track:\n";
echo "  • Page types (homepage, service, insight, video, etc.)\n";
echo "  • User journey stages (awareness, consideration, evaluation, conversion)\n";
echo "  • Site-specific tags (nrlc.ai, ai-seo platform)\n\n";

echo "You can also track custom events using:\n";
echo "  window.NRLCClarity.track('event_name', {key: 'value'});\n\n";

echo "=== Cookie Consent ===\n";
if (CLARITY_CONSENT_REQUIRED) {
    echo "⚠️  Cookie consent is required. Make sure to implement consent management:\n";
    echo "  window.NRLCClarity.setConsent(true, false); // analytics: true, ads: false\n";
} else {
    echo "✅ No cookie consent required (current setting)\n";
}

echo "\n🎉 Microsoft Clarity setup complete!\n";
echo "Your website is now ready for behavioral analytics.\n\n";

<?php
/**
 * Microsoft Clarity Configuration for NRLC.ai
 * 
 * This file contains Microsoft Clarity project configuration
 * and helper functions for behavioral analytics integration.
 */

// Microsoft Clarity Project Configuration
define('CLARITY_PROJECT_ID', 'yourProjectId'); // TODO: Replace with actual project ID from Clarity dashboard
define('CLARITY_ENABLED', true); // Enable/disable Clarity tracking
define('CLARITY_CONSENT_REQUIRED', false); // Set to true if cookie consent is required

// Clarity tracking settings
define('CLARITY_TRACK_PAGE_TYPE', true); // Track page types (homepage, service, insight, etc.)
define('CLARITY_TRACK_JOURNEY_STAGE', true); // Track user journey stages
define('CLARITY_AUTO_UPGRADE_SESSIONS', false); // Auto-upgrade important sessions

// Page type mappings for analytics
function clarity_get_page_type($path) {
    $path = trim($path, '/');
    
    if (empty($path) || $path === 'en-us') return 'homepage';
    if (strpos($path, 'services/') !== false) return 'service';
    if (strpos($path, 'insights/') !== false) return 'insight';
    if (strpos($path, 'videos/') !== false) return 'video';
    if (strpos($path, 'tools/') !== false) return 'tool';
    if (strpos($path, '/learn/') !== false) return 'learn';
    if (strpos($path, '/careers/') !== false) return 'career';
    if (strpos($path, '/industries/') !== false) return 'industry';
    if (strpos($path, '/products/') !== false) return 'product';
    if (strpos($path, '/promptware/') !== false) return 'promptware';
    
    return 'other';
}

// Journey stage mappings
function clarity_get_journey_stage($path) {
    $path = trim($path, '/');
    
    // Remove locale prefix for journey stage detection
    $pathWithoutLocale = preg_replace('#^/[a-z]{2}-[a-z]{2}/#', '', $path);
    
    // Homepage visitors are in awareness stage
    if (empty($pathWithoutLocale) || $pathWithoutLocale === 'en-us') return 'awareness';
    
    // Learn and insights visitors are in consideration stage
    if (strpos($pathWithoutLocale, '/learn/') !== false || strpos($pathWithoutLocale, '/insights/') !== false) return 'consideration';
    
    // Tools and videos visitors are in evaluation stage
    if (strpos($pathWithoutLocale, '/tools/') !== false || strpos($pathWithoutLocale, '/videos/') !== false) return 'evaluation';
    
    // Services and careers visitors are in conversion stage
    if (strpos($pathWithoutLocale, '/services/') !== false || strpos($pathWithoutLocale, '/careers/') !== false) return 'conversion';
    
    return 'unknown';
}

// Generate Clarity configuration for JavaScript
function clarity_get_js_config() {
    if (!CLARITY_ENABLED) {
        return 'null'; // Disabled
    }
    
    $currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    $pageType = clarity_get_page_type($currentPath);
    $journeyStage = clarity_get_journey_stage($currentPath);
    
    return json_encode([
        'projectId' => CLARITY_PROJECT_ID,
        'enabled' => CLARITY_ENABLED,
        'consentRequired' => CLARITY_CONSENT_REQUIRED,
        'pageType' => $pageType,
        'journeyStage' => $journeyStage,
        'trackPageType' => CLARITY_TRACK_PAGE_TYPE,
        'trackJourneyStage' => CLARITY_TRACK_JOURNEY_STAGE,
        'autoUpgradeSessions' => CLARITY_AUTO_UPGRADE_SESSIONS
    ]);
}

// Check if Clarity should be loaded on current page
function clarity_should_load() {
    // Don't load in development environments
    if (in_array($_SERVER['HTTP_HOST'] ?? '', ['localhost', '127.0.0.1', 'localhost:8000', '127.0.0.1:8000'])) {
        return false;
    }
    
    // Don't load if disabled
    if (!CLARITY_ENABLED) {
        return false;
    }
    
    // Don't load on admin pages
    $currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    if (strpos($currentPath, '/admin/') === 0 || strpos($currentPath, '/agent/') === 0) {
        return false;
    }
    
    return true;
}

// Get Clarity project ID for template usage
function clarity_get_project_id() {
    return CLARITY_ENABLED ? CLARITY_PROJECT_ID : null;
}

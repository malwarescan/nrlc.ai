/**
 * Microsoft Clarity Integration for NRLC.ai
 * Behavioral analytics with session replays, heatmaps, and insights
 */

// Microsoft Clarity Project ID - Set from PHP configuration
let CLARITY_PROJECT_ID = 'yourProjectId';

// Initialize Microsoft Clarity
function initClarity() {
  // Check if Clarity is available and project ID is set
  if (typeof window.clarity === 'function' && CLARITY_PROJECT_ID !== 'yourProjectId') {
    // Initialize Clarity with project ID
    window.clarity('start', CLARITY_PROJECT_ID);
    
    // Set custom tags for NRLC.ai specific tracking
    window.clarity('set', 'site', 'nrlc.ai');
    window.clarity('set', 'platform', 'ai-seo');
    window.clarity('set', 'version', '1.0');
    
    // Track page type for better analytics
    const pageType = getPageType();
    if (pageType) {
      window.clarity('set', 'page_type', pageType);
    }
    
    // Track user journey stage
    const journeyStage = getJourneyStage();
    if (journeyStage) {
      window.clarity('set', 'journey_stage', journeyStage);
    }
    
    console.log('Microsoft Clarity initialized for NRLC.ai');
  } else {
    console.warn('Microsoft Clarity not available or project ID not set');
  }
}

// Determine page type for analytics
function getPageType() {
  const path = window.location.pathname;
  
  if (path === '/' || path === '/en-us/') return 'homepage';
  if (path.includes('/services/')) return 'service';
  if (path.includes('/insights/')) return 'insight';
  if (path.includes('/videos/')) return 'video';
  if (path.includes('/tools/')) return 'tool';
  if (path.includes('/learn/')) return 'learn';
  if (path.includes('/careers/')) return 'career';
  if (path.includes('/industries/')) return 'industry';
  if (path.includes('/products/')) return 'product';
  if (path.includes('/promptware/')) return 'promptware';
  
  return 'other';
}

// Determine user journey stage
function getJourneyStage() {
  const path = window.location.pathname;
  
  // Homepage visitors are in awareness stage
  if (path === '/' || path === '/en-us/') return 'awareness';
  
  // Learn and insights visitors are in consideration stage
  if (path.includes('/learn/') || path.includes('/insights/')) return 'consideration';
  
  // Tools and videos visitors are in evaluation stage
  if (path.includes('/tools/') || path.includes('/videos/')) return 'evaluation';
  
  // Services and careers visitors are in conversion stage
  if (path.includes('/services/') || path.includes('/careers/')) return 'conversion';
  
  return 'unknown';
}

// Custom event tracking for NRLC.ai specific actions
function trackClarityEvent(eventName, data = {}) {
  if (typeof window.clarity === 'function') {
    // Track the event
    window.clarity('event', eventName);
    
    // Set additional tags if data provided
    if (data && typeof data === 'object') {
      Object.keys(data).forEach(key => {
        window.clarity('set', key, data[key]);
      });
    }
  }
}

// Identify users for better tracking
function identifyUser(userId, userData = {}) {
  if (typeof window.clarity === 'function' && userId) {
    window.clarity('identify', userId, userData.sessionId, userData.pageId, userData.friendlyName);
  }
}

// Upgrade important sessions for priority recording
function upgradeClaritySession(reason) {
  if (typeof window.clarity === 'function' && reason) {
    window.clarity('upgrade', reason);
  }
}

// Cookie consent management
function setClarityConsent(analytics = true, ads = false) {
  if (typeof window.clarity === 'function') {
    // Use v2 consent API (recommended)
    window.clarity('consentV2', {
      ad_storage: ads ? 'granted' : 'denied',
      analytics_storage: analytics ? 'granted' : 'denied'
    });
  }
}

// Load configuration from PHP (if available)
function loadClarityConfig() {
  // Check if PHP configuration is available
  if (typeof window.clarityConfig !== 'undefined') {
    CLARITY_PROJECT_ID = window.clarityConfig.projectId || CLARITY_PROJECT_ID;
    return true;
  }
  return false;
}

// Auto-initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
  // Load configuration from PHP
  loadClarityConfig();
  
  // Load Clarity script after configuration is set
  loadClarityScript();
  
  // Wait a bit to ensure all scripts are loaded
  setTimeout(initClarity, 1000);
});

// Export functions for global access
window.NRLCClarity = {
  track: trackClarityEvent,
  identify: identifyUser,
  upgrade: upgradeClaritySession,
  setConsent: setClarityConsent,
  init: initClarity,
  config: loadClarityConfig
};

// Load Microsoft Clarity script (will be loaded after configuration is set)
function loadClarityScript() {
  if (CLARITY_PROJECT_ID !== 'yourProjectId') {
    (function(c,l,a,r,i,t,y){
        c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
        t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
        y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
    })(window, document, "clarity", "script", CLARITY_PROJECT_ID);
  }
}

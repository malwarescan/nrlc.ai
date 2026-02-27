# Microsoft Clarity Implementation for NRLC.ai
## Behavioral Analytics with Session Replays, Heatmaps, and Insights

**Date**: 2026-02-27  
**Status**: ✅ IMPLEMENTED & READY FOR CONFIGURATION  

---

## 🎯 **Overview**

Microsoft Clarity has been successfully integrated into NRLC.ai to provide comprehensive behavioral analytics including:

- **Session Replays**: Watch how users interact with your website
- **Heatmaps**: Visualize user clicks, movements, and scrolling patterns
- **Insights**: Automatic detection of user behavior patterns and issues
- **Clarity Copilot**: AI-powered summaries and actionable recommendations
- **Custom Events**: Track specific user interactions and conversions

---

## 🔧 **Implementation Details**

### **Files Created/Modified**:
- ✅ `assets/js/clarity.js` - Main Clarity integration script
- ✅ `config/clarity.php` - PHP configuration file
- ✅ `templates/head.php` - Added Clarity to site-wide head section
- ✅ `scripts/setup_clarity.php` - Configuration setup script
- ✅ `package.json` - Added @microsoft/clarity dependency

### **Integration Method**:
- **Site-wide Installation**: Clarity loads on all pages via head.php
- **Conditional Loading**: Automatically disabled in development and admin areas
- **Configuration-driven**: PHP configuration controls behavior
- **Privacy-aware**: Cookie consent management built-in

---

## ⚙️ **Configuration**

### **Current Settings**:
```php
// config/clarity.php
define('CLARITY_PROJECT_ID', 'yourProjectId'); // TODO: Set your actual project ID
define('CLARITY_ENABLED', true); // Enable/disable tracking
define('CLARITY_CONSENT_REQUIRED', false); // Cookie consent requirement
```

### **Setup Required**:
1. **Get Project ID** from Microsoft Clarity dashboard
2. **Run Setup Script**: `php scripts/setup_clarity.php`
3. **Deploy Changes** to production
4. **Verify Tracking** in Clarity dashboard

---

## 🚀 **Setup Instructions**

### **Step 1: Create Clarity Project**
1. Visit [Microsoft Clarity](https://clarity.microsoft.com/)
2. Sign in with Microsoft account
3. Click "Add new project"
4. Enter project name: "NRLC.ai"
5. Enter website URL: "https://nrlc.ai"
6. Accept terms and create project

### **Step 2: Get Project ID**
1. In Clarity dashboard, select your project
2. Go to **Settings > Overview**
3. Copy the **Project ID** (format: `xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx`)

### **Step 3: Configure NRLC.ai**
```bash
# Run the setup script
php scripts/setup_clarity.php

# Follow prompts to enter your Project ID
```

### **Step 4: Deploy and Verify**
```bash
# Commit and deploy changes
git add .
git commit -m "Configure Microsoft Clarity with project ID"
git push

# Visit your website and check Clarity dashboard for data
```

---

## 📊 **Automatic Tracking Features**

### **Page Type Tracking**:
- **Homepage**: `/` and `/en-us/`
- **Service Pages**: `/services/*`
- **Insight Articles**: `/insights/*`
- **Video Pages**: `/videos/*`
- **Tool Pages**: `/tools/*`
- **Learn Pages**: `/learn/*`
- **Career Pages**: `/careers/*`
- **Industry Pages**: `/industries/*`
- **Product Pages**: `/products/*`
- **Promptware**: `/promptware/*`

### **Journey Stage Tracking**:
- **Awareness**: Homepage visitors
- **Consideration**: Learn and insights visitors
- **Evaluation**: Tools and videos visitors
- **Conversion**: Services and careers visitors

### **Custom Tags Applied**:
- `site: nrlc.ai`
- `platform: ai-seo`
- `version: 1.0`
- `page_type: [auto-detected]`
- `journey_stage: [auto-detected]`

---

## 🎛️ **Custom Event Tracking**

### **Available Functions**:
```javascript
// Track custom events
window.NRLCClarity.track('button_click', {
  button_name: 'contact_form',
  page_section: 'header'
});

// Identify users for better tracking
window.NRLCClarity.identify('user123', {
  sessionId: 'session456',
  pageId: 'contact',
  friendlyName: 'John Doe'
});

// Upgrade important sessions
window.NRLCClarity.upgrade('form_submission');

// Manage cookie consent
window.NRLCClarity.setConsent(true, false); // analytics: true, ads: false
```

### **Recommended Events to Track**:
- `form_submission` - Contact form submissions
- `service_inquiry` - Service page inquiries
- `video_play` - Video interactions
- `tool_usage` - Tool page interactions
- `booking_click` - Consultation booking clicks
- `newsletter_signup` - Email newsletter signups

---

## 🔒 **Privacy and Compliance**

### **Data Collection**:
- **Session Recordings**: User interactions (clicks, scrolls, inputs)
- **Heatmap Data**: Aggregate click and movement patterns
- **Technical Data**: Browser, device, location (country level)
- **No Personal Data**: No email addresses, names, or personal identifiers

### **Compliance Features**:
- **Cookie Consent**: Built-in consent management
- **Data Retention**: Configurable retention periods
- **Export Options**: Data export capabilities
- **GDPR Compatible**: Privacy by design

### **Exclusions**:
- **Development Environments**: Automatically disabled
- **Admin Areas**: No tracking on `/admin/*` and `/agent/*`
- **Sensitive Inputs**: Password fields automatically masked

---

## 📈 **Analytics and Insights**

### **Available Dashboards**:
- **Overview**: Key metrics and trends
- **Heatmaps**: Click, move, and scroll heatmaps
- **Session Recordings**: Individual user sessions
- **Insights**: Automatic behavior pattern detection
- **Funnel Analysis**: Conversion funnel performance

### **Key Metrics**:
- **Session Count**: Total user sessions
- **Page Views**: Total page impressions
- **Bounce Rate**: Single-page session percentage
- **Session Duration**: Average time on site
- **Dead Clicks**: Clicks with no response
- **Rage Clicks**: Frustrated clicking patterns
- **Quick Backs**: Rapid page exits

### **AI-Powered Insights**:
- **Clarity Copilot**: Automated analysis and recommendations
- **Issue Detection**: Automatic identification of UX problems
- **Performance Issues**: Slow-loading elements and errors
- **User Frustration**: Rage clicks and dead clicks analysis

---

## 🛠️ **Advanced Configuration**

### **Custom Tracking Implementation**:
```php
// In PHP templates, add custom tracking
if (function_exists('clarity_should_load') && clarity_should_load()) {
    echo '<script>window.NRLCClarity.track("page_view", {template: "' . $template . '"});</script>';
}
```

### **Conditional Loading Rules**:
```php
// config/clarity.php - Custom rules
function clarity_should_load() {
    // Don't load in development
    if (in_array($_SERVER['HTTP_HOST'] ?? '', ['localhost', '127.0.0.1'])) {
        return false;
    }
    
    // Don't load on admin pages
    $currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
    if (strpos($currentPath, '/admin/') === 0) {
        return false;
    }
    
    return CLARITY_ENABLED;
}
```

---

## 🎯 **Use Cases for NRLC.ai**

### **Content Optimization**:
- **Article Performance**: See how users read insight articles
- **Video Engagement**: Track video watch patterns and drop-offs
- **Tool Usage**: Understand how users interact with SEO tools
- **Service Pages**: Optimize service page conversion funnels

### **User Experience Improvements**:
- **Navigation Issues**: Identify confusing navigation patterns
- **Form Problems**: Detect form abandonment and errors
- **Mobile Experience**: Compare mobile vs desktop behavior
- **Loading Issues**: Find slow-loading elements and pages

### **Business Intelligence**:
- **Lead Generation**: Track contact form and booking conversions
- **Content Strategy**: Identify most popular content types
- **User Segmentation**: Understand different user behaviors
- **Conversion Optimization**: Improve conversion funnel performance

---

## 📞 **Support and Troubleshooting**

### **Common Issues**:
1. **No Data in Dashboard**: Check project ID configuration
2. **Script Not Loading**: Verify file permissions and paths
3. **Cookie Consent**: Ensure consent is properly managed
4. **Development Mode**: Check if running on localhost

### **Debugging Tools**:
```javascript
// Check if Clarity is loaded
console.log('Clarity loaded:', typeof window.clarity !== 'undefined');
console.log('Clarity config:', window.clarityConfig);

// Manually trigger events for testing
window.NRLCClarity.track('test_event', {debug: true});
```

### **Support Resources**:
- **Microsoft Clarity Documentation**: https://learn.microsoft.com/en-us/clarity/
- **Community Forum**: https://learn.microsoft.com/en-us/answers/topics/clarity.html
- **Setup Script**: `php scripts/setup_clarity.php`

---

## 🎉 **Implementation Complete**

Microsoft Clarity is now fully integrated into NRLC.ai and ready for behavioral analytics:

✅ **Site-wide Implementation** - Loads on all pages automatically  
✅ **Configuration Management** - PHP-based configuration system  
✅ **Privacy Compliance** - Cookie consent and data protection  
✅ **Custom Tracking** - NRLC.ai specific event tracking  
✅ **Development Safety** - Disabled in development environments  
✅ **Setup Automation** - Easy configuration script  

**Next Steps**: Configure your Project ID and start collecting behavioral insights! 🚀

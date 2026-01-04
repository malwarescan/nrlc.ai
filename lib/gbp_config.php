<?php
/**
 * Google Business Profile Configuration Helper
 * 
 * This file provides access to GBP data as the single source of truth for business identity.
 * All identity signals across the site must match GBP exactly.
 * 
 * IMPORTANT: Update config/gbp.json with actual GBP data before deployment.
 */

declare(strict_types=1);

// Guard against redeclaration
if (!function_exists('gbp_config')) {
  /**
   * Load GBP configuration from JSON file
   * 
   * @return array GBP configuration data
   * @throws RuntimeException if config file is missing or invalid
   */
  function gbp_config(): array {
    static $config = null;
    
    if ($config === null) {
      $configPath = __DIR__ . '/../config/gbp.json';
      
      if (!file_exists($configPath)) {
        throw new RuntimeException("GBP config file not found: {$configPath}. Please create config/gbp.json with Google Business Profile data.");
      }
      
      $json = file_get_contents($configPath);
      if ($json === false) {
        throw new RuntimeException("Failed to read GBP config file: {$configPath}");
      }
      
      $config = json_decode($json, true);
      if (json_last_error() !== JSON_ERROR_NONE) {
        throw new RuntimeException("Invalid JSON in GBP config file: " . json_last_error_msg());
      }
      
      // Validate required fields
      $required = ['businessName', 'phone', 'website', 'address', 'googleBusinessProfileUrl'];
      foreach ($required as $field) {
        if (!isset($config[$field])) {
          throw new RuntimeException("GBP config missing required field: {$field}");
        }
      }
      
      // Validate address structure
      if (!is_array($config['address'])) {
        throw new RuntimeException("GBP config 'address' must be an object");
      }
      
      $requiredAddress = ['streetAddress', 'addressLocality', 'addressRegion', 'postalCode', 'addressCountry'];
      foreach ($requiredAddress as $field) {
        if (!isset($config['address'][$field])) {
          throw new RuntimeException("GBP config address missing required field: {$field}");
        }
      }
    }
    
    return $config;
  }

  /**
   * Get business name from GBP (exact match required)
   * 
   * @return string Business name exactly as it appears in GBP
   */
  function gbp_business_name(): string {
    return gbp_config()['businessName'];
  }

  /**
   * Get legal name from GBP
   * 
   * @return string Legal name
   */
  function gbp_legal_name(): string {
    $config = gbp_config();
    return $config['legalName'] ?? $config['businessName'];
  }

  /**
   * Get primary phone number from GBP (exact match required)
   * 
   * @return string Phone number exactly as it appears in GBP
   */
  function gbp_phone(): string {
    return gbp_config()['phone'];
  }

  /**
   * Get business email from GBP
   * 
   * @return string Email address
   */
  function gbp_email(): string {
    $config = gbp_config();
    return $config['email'] ?? 'contact@neuralcommandllc.com';
  }

  /**
   * Get website URL from GBP (exact match required)
   * 
   * @return string Website URL exactly as it appears in GBP
   */
  function gbp_website(): string {
    return gbp_config()['website'];
  }

  /**
   * Get full address as PostalAddress array (for schema markup)
   * 
   * @return array PostalAddress structure matching GBP exactly
   */
  function gbp_address(): array {
    $addr = gbp_config()['address'];
    return [
      '@type' => 'PostalAddress',
      'streetAddress' => $addr['streetAddress'],
      'addressLocality' => $addr['addressLocality'],
      'addressRegion' => $addr['addressRegion'],
      'postalCode' => $addr['postalCode'],
      'addressCountry' => $addr['addressCountry']
    ];
  }

  /**
   * Get formatted address string for display (e.g., in footer)
   * Filters out placeholders and returns empty string if all fields are placeholders
   * 
   * @return string Human-readable address, or empty string if placeholders only
   */
  function gbp_address_display(): string {
    $addr = gbp_config()['address'];
    
    // Filter out placeholders and empty values
    $parts = array_filter([
      $addr['streetAddress'],
      $addr['addressLocality'],
      $addr['addressRegion'],
      $addr['postalCode']
    ], function($value) {
      // Remove placeholders and empty strings
      return !empty($value) && strpos($value, 'PLEASE_FILL_IN') === false;
    });
    
    // Return empty string if all fields are placeholders
    if (empty($parts)) {
      return '';
    }
    
    return implode(', ', $parts);
  }

  /**
   * Get Google Business Profile URL
   * 
   * @return string GBP URL
   */
  function gbp_url(): string {
    return gbp_config()['googleBusinessProfileUrl'];
  }

  /**
   * Get sameAs array for schema markup (includes GBP URL and other profiles)
   * 
   * @return array Array of URLs
   */
  function gbp_same_as(): array {
    return gbp_config()['sameAs'] ?? [];
  }

  /**
   * Get service area from GBP (if specified)
   * 
   * @return array Service area information
   */
  function gbp_service_area(): array {
    $config = gbp_config();
    return $config['serviceArea'] ?? [];
  }

  /**
   * Verify that a value matches GBP exactly (for QA/validation)
   * 
   * @param string $field Field name (businessName, phone, etc.)
   * @param string $value Value to check
   * @return bool True if matches GBP exactly
   */
  function gbp_verify_match(string $field, string $value): bool {
    $config = gbp_config();
    
    switch ($field) {
      case 'businessName':
      case 'legalName':
      case 'phone':
      case 'website':
        return isset($config[$field]) && $config[$field] === $value;
      
      case 'address':
        if (!is_array($value)) return false;
        $gbpAddr = $config['address'];
        return $value['streetAddress'] === $gbpAddr['streetAddress'] &&
               $value['addressLocality'] === $gbpAddr['addressLocality'] &&
               $value['addressRegion'] === $gbpAddr['addressRegion'] &&
               $value['postalCode'] === $gbpAddr['postalCode'] &&
               $value['addressCountry'] === $gbpAddr['addressCountry'];
      
      default:
        return false;
    }
  }
} // End function_exists guard

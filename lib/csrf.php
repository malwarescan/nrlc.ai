<?php
/**
 * NRLC AI Case Study System - CSRF Protection
 * 
 * Classic synchronizer token pattern.
 * Only needed for POST/PUT endpoints.
 */

session_start();

/**
 * Generate CSRF token
 */
function generate_csrf_token(): string {
  if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
  }
  return $_SESSION['csrf_token'];
}

/**
 * Get CSRF token (for forms)
 */
function csrf_token(): string {
  return generate_csrf_token();
}

/**
 * Validate CSRF token
 * 
 * @param string|null $token Token from request
 * @return bool Valid
 */
function validate_csrf_token(?string $token): bool {
  if (empty($token) || empty($_SESSION['csrf_token'])) {
    return false;
  }
  
  return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Require valid CSRF token
 * Dies with 403 if invalid
 */
function require_csrf_token(): void {
  $token = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;
  
  if (!validate_csrf_token($token)) {
    http_response_code(403);
    die('Invalid CSRF token. Please refresh the page and try again.');
  }
}

/**
 * CSRF token input field (for forms)
 */
function csrf_field(): string {
  return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(csrf_token()) . '">';
}


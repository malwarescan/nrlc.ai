<?php
/**
 * NRLC AI Case Study System - Authentication
 * 
 * Minimum viable session-based auth.
 * One admin role, one client role.
 * Gates: /admin/* and /app/clients/*
 */

session_start();

/**
 * Check if user is authenticated
 */
function is_authenticated(): bool {
  return isset($_SESSION['user_id']) && isset($_SESSION['user_role']);
}

/**
 * Check if user has admin role
 */
function is_admin(): bool {
  return is_authenticated() && $_SESSION['user_role'] === 'admin';
}

/**
 * Check if user has client role
 */
function is_client(): bool {
  return is_authenticated() && $_SESSION['user_role'] === 'client';
}

/**
 * Require authentication
 * Redirects to login if not authenticated
 */
function require_auth(): void {
  if (!is_authenticated()) {
    header('Location: /login.php?redirect=' . urlencode($_SERVER['REQUEST_URI']));
    exit;
  }
}

/**
 * Require admin role
 * Redirects to login if not admin
 */
function require_admin(): void {
  require_auth();
  if (!is_admin()) {
    http_response_code(403);
    die('Access denied. Admin role required.');
  }
}

/**
 * Require client role
 * Redirects to login if not client
 */
function require_client(): void {
  require_auth();
  if (!is_client()) {
    http_response_code(403);
    die('Access denied. Client role required.');
  }
}

/**
 * Authenticate user
 * 
 * @param string $username
 * @param string $password
 * @return bool Success
 */
function authenticate(string $username, string $password): bool {
  // In production, query database
  // For now, use environment variables or config file
  
  $users = get_users();
  
  foreach ($users as $user) {
    if ($user['username'] === $username && password_verify($password, $user['password_hash'])) {
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['user_role'] = $user['role'];
      $_SESSION['user_name'] = $user['name'] ?? $username;
      $_SESSION['user_email'] = $user['email'] ?? (filter_var($username, FILTER_VALIDATE_EMAIL) ? $username : null);
      return true;
    }
  }
  
  return false;
}

/**
 * Logout user
 */
function logout(): void {
  session_destroy();
  header('Location: /login.php');
  exit;
}

/**
 * Get users (in production, from database)
 * 
 * For now, reads from environment or config
 */
function get_users(): array {
  // Option 1: Environment variables
  $adminUser = getenv('ADMIN_USERNAME');
  $adminPass = getenv('ADMIN_PASSWORD');
  $adminEmail = getenv('ADMIN_EMAIL');
  $clientUser = getenv('CLIENT_USERNAME');
  $clientPass = getenv('CLIENT_PASSWORD');
  $clientEmail = getenv('CLIENT_EMAIL');
  
  $users = [];
  
  if ($adminUser && $adminPass) {
    $users[] = [
      'id' => 1,
      'username' => $adminUser,
      'password_hash' => password_hash($adminPass, PASSWORD_DEFAULT),
      'role' => 'admin',
      'name' => 'Admin',
      'email' => $adminEmail ?: (filter_var($adminUser, FILTER_VALIDATE_EMAIL) ? $adminUser : null),
    ];
  }
  
  if ($clientUser && $clientPass) {
    $users[] = [
      'id' => 2,
      'username' => $clientUser,
      'password_hash' => password_hash($clientPass, PASSWORD_DEFAULT),
      'role' => 'client',
      'name' => 'Client',
      'email' => $clientEmail ?: (filter_var($clientUser, FILTER_VALIDATE_EMAIL) ? $clientUser : null),
    ];
  }
  
  // Option 2: Config file (fallback)
  if (empty($users)) {
    $configFile = __DIR__ . '/../config/users.php';
    if (file_exists($configFile)) {
      $users = require $configFile;
    }
  }
  
  // Option 3: Default dev users (only if no env/config)
  if (empty($users)) {
    $users = [
      [
        'id' => 1,
        'username' => 'admin',
        'password_hash' => password_hash('admin', PASSWORD_DEFAULT), // CHANGE IN PRODUCTION
        'role' => 'admin',
        'name' => 'Admin',
        'email' => 'admin@example.com',
      ],
      [
        'id' => 2,
        'username' => 'client',
        'password_hash' => password_hash('client', PASSWORD_DEFAULT), // CHANGE IN PRODUCTION
        'role' => 'client',
        'name' => 'Client',
        'email' => 'client@example.com',
      ]
    ];
  }
  
  return $users;
}

function current_user_id(): ?string {
  return isset($_SESSION['user_id']) ? (string)$_SESSION['user_id'] : null;
}

function current_user_email(): ?string {
  if (!empty($_SESSION['user_email']) && is_string($_SESSION['user_email'])) {
    return $_SESSION['user_email'];
  }
  if (!empty($_SESSION['user_name']) && filter_var($_SESSION['user_name'], FILTER_VALIDATE_EMAIL)) {
    return $_SESSION['user_name'];
  }
  return null;
}

function find_user_by_email(string $email): ?array {
  $needle = strtolower(trim($email));
  if ($needle === '') {
    return null;
  }
  foreach (get_users() as $user) {
    $candidate = strtolower((string)($user['email'] ?? ''));
    if ($candidate === '' && !empty($user['username']) && filter_var($user['username'], FILTER_VALIDATE_EMAIL)) {
      $candidate = strtolower((string)$user['username']);
    }
    if ($candidate === $needle) {
      return $user;
    }
  }
  return null;
}


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
  $clientUser = getenv('CLIENT_USERNAME');
  $clientPass = getenv('CLIENT_PASSWORD');
  
  $users = [];
  
  if ($adminUser && $adminPass) {
    $users[] = [
      'id' => 1,
      'username' => $adminUser,
      'password_hash' => password_hash($adminPass, PASSWORD_DEFAULT),
      'role' => 'admin',
      'name' => 'Admin'
    ];
  }
  
  if ($clientUser && $clientPass) {
    $users[] = [
      'id' => 2,
      'username' => $clientUser,
      'password_hash' => password_hash($clientPass, PASSWORD_DEFAULT),
      'role' => 'client',
      'name' => 'Client'
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
        'name' => 'Admin'
      ],
      [
        'id' => 2,
        'username' => 'client',
        'password_hash' => password_hash('client', PASSWORD_DEFAULT), // CHANGE IN PRODUCTION
        'role' => 'client',
        'name' => 'Client'
      ]
    ];
  }
  
  return $users;
}


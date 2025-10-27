<?php
// Handle GET requests
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  // For GET requests, return a simple JSON response
  header('Content-Type: application/json');
  echo json_encode([
    'ok' => true,
    'message' => 'Use POST to submit booking requests',
    'endpoint' => '/api/book/',
    'form_action' => '/api/book/'
  ]);
  exit;
}

// Handle POST requests
header('Content-Type: application/json');

// Handle CORS for form submissions
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: POST, OPTIONS');
  header('Access-Control-Allow-Headers: Content-Type');
  exit(0);
}

// Only allow POST requests for form submission
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['ok' => false, 'error' => 'Method not allowed']);
  exit;
}

// Include the main book API handler
require_once __DIR__.'/../../../api/book.php';


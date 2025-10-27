<?php
// Redirect GET requests to the booking page
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  header('Location: /pages/book/');
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


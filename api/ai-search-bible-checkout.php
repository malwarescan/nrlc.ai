<?php
declare(strict_types=1);

require_once __DIR__ . '/../lib/helpers.php';
require_once __DIR__ . '/../lib/ai_search_bible_paywall.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo 'Method not allowed';
  exit;
}

$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/api/ai-search-bible/checkout', PHP_URL_PATH) ?: '/api/ai-search-bible/checkout';
error_log('ai-bible-checkout: method=' . ($_SERVER['REQUEST_METHOD'] ?? 'UNKNOWN') . ' path=' . $requestPath);

$successUrl = absolute_url('/ai-search-bible/full/?session_id={CHECKOUT_SESSION_ID}');
$cancelUrl = absolute_url('/ai-search-bible/');
$result = ai_search_bible_create_checkout_session($successUrl, $cancelUrl);
if (empty($result['ok']) || empty($result['url'])) {
  error_log('ai-bible-checkout: create_session=fail redirect=none');
  http_response_code(400);
  echo 'Unable to start checkout';
  exit;
}

error_log('ai-bible-checkout: create_session=ok redirect=checkout');
header('Location: ' . $result['url'], true, 303);
exit;

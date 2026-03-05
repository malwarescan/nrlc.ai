<?php
declare(strict_types=1);

require_once __DIR__ . '/../lib/helpers.php';
require_once __DIR__ . '/../lib/ai_search_bible_paywall.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo 'Method not allowed';
  exit;
}

$successUrl = absolute_url('/ai-search-bible/full/?session_id={CHECKOUT_SESSION_ID}');
$cancelUrl = absolute_url('/ai-search-bible/');
$result = ai_search_bible_create_checkout_session($successUrl, $cancelUrl);
if (empty($result['ok']) || empty($result['url'])) {
  http_response_code(400);
  echo 'Unable to start checkout';
  exit;
}

header('Location: ' . $result['url'], true, 303);
exit;

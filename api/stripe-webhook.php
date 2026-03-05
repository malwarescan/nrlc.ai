<?php
declare(strict_types=1);

require_once __DIR__ . '/../lib/auth.php';
require_once __DIR__ . '/../lib/ai_search_bible_paywall.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo 'Method not allowed';
  exit;
}

$payload = file_get_contents('php://input') ?: '';
$eventForMode = json_decode($payload, true);
$isLiveMode = is_array($eventForMode) && (($eventForMode['livemode'] ?? null) === true);
$isTestMode = is_array($eventForMode) && (($eventForMode['livemode'] ?? null) === false);
if ($isLiveMode) {
  header('X-Stripe-Mode: live');
} elseif ($isTestMode) {
  header('X-Stripe-Mode: test');
} else {
  header('X-Stripe-Mode: unknown');
}

$signature = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? '';
if (!ai_search_bible_verify_webhook_signature($payload, $signature)) {
  http_response_code(400);
  echo 'Invalid signature';
  exit;
}

$event = json_decode($payload, true);
if (!is_array($event)) {
  http_response_code(400);
  echo 'Invalid payload';
  exit;
}

$eventId = (string)($event['id'] ?? '');
if ($eventId !== '' && ai_search_bible_event_already_processed($eventId)) {
  http_response_code(200);
  echo 'ok';
  exit;
}

$eventType = (string)($event['type'] ?? '');
$object = $event['data']['object'] ?? [];
if (!is_array($object)) {
  ai_search_bible_upsert_webhook_event([
    'stripe_event_id' => $eventId,
    'type' => $eventType,
    'processed_ok' => false,
    'error_message' => 'Invalid event object',
  ]);
  http_response_code(200);
  echo 'ok';
  exit;
}

if (!in_array($eventType, ['checkout.session.completed', 'checkout.session.async_payment_succeeded', 'payment_intent.succeeded'], true)) {
  ai_search_bible_upsert_webhook_event([
    'stripe_event_id' => $eventId,
    'type' => $eventType,
    'processed_ok' => true,
    'error_message' => 'Ignored event type',
  ]);
  http_response_code(200);
  echo 'ok';
  exit;
}

$email = '';
$stripeCustomerId = '';
$stripePaymentIntentId = '';
$stripeCheckoutSessionId = '';

if ($eventType === 'checkout.session.completed' || $eventType === 'checkout.session.async_payment_succeeded') {
  $email = (string)($object['customer_details']['email'] ?? $object['customer_email'] ?? '');
  $stripeCustomerId = (string)($object['customer'] ?? '');
  $stripePaymentIntentId = (string)($object['payment_intent'] ?? '');
  $stripeCheckoutSessionId = (string)($object['id'] ?? '');
} else {
  $email = (string)($object['receipt_email'] ?? $object['charges']['data'][0]['billing_details']['email'] ?? '');
  $stripeCustomerId = (string)($object['customer'] ?? '');
  $stripePaymentIntentId = (string)($object['id'] ?? '');
}

if ($email === '') {
  ai_search_bible_upsert_webhook_event([
    'stripe_event_id' => $eventId,
    'type' => $eventType,
    'processed_ok' => true,
    'error_message' => 'Missing payer email',
    'email' => '',
  ]);
  error_log('stripe-webhook: missing email for event ' . $eventId);
  http_response_code(200);
  echo 'ok';
  exit;
}

$user = find_user_by_email($email);
if (!is_array($user) || !isset($user['id'])) {
  ai_search_bible_upsert_webhook_event([
    'stripe_event_id' => $eventId,
    'type' => $eventType,
    'processed_ok' => true,
    'error_message' => 'No user mapped to payer email',
    'email' => $email,
    'entitlement_key' => ai_search_bible_entitlement_key(),
  ]);
  error_log('stripe-webhook: no user mapped for email ' . $email . ' event ' . $eventId);
  http_response_code(200);
  echo 'ok';
  exit;
}

$saved = ai_search_bible_upsert_entitlement([
  'user_id' => (string)$user['id'],
  'status' => 'active',
  'stripe_customer_id' => $stripeCustomerId,
  'stripe_payment_intent_id' => $stripePaymentIntentId,
  'stripe_checkout_session_id' => $stripeCheckoutSessionId,
  'stripe_event_id_last' => $eventId,
]);

if (!$saved) {
  ai_search_bible_upsert_webhook_event([
    'stripe_event_id' => $eventId,
    'type' => $eventType,
    'processed_ok' => false,
    'error_message' => 'Entitlement upsert failed',
    'user_id' => (string)$user['id'],
    'email' => $email,
    'entitlement_key' => ai_search_bible_entitlement_key(),
  ]);
  error_log('stripe-webhook: entitlement upsert failed for user ' . $user['id'] . ' event ' . $eventId);
  http_response_code(500);
  echo 'entitlement update failed';
  exit;
}

ai_search_bible_upsert_webhook_event([
  'stripe_event_id' => $eventId,
  'type' => $eventType,
  'processed_ok' => true,
  'error_message' => '',
  'user_id' => (string)$user['id'],
  'email' => $email,
  'entitlement_key' => ai_search_bible_entitlement_key(),
]);
error_log('stripe-webhook: entitlement active for user ' . $user['id'] . ' event ' . $eventId);
http_response_code(200);
echo 'ok';

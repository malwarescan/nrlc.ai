<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

function ai_search_bible_session_bootstrap(): void {
  if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
  }
}

function ai_search_bible_paywall_config(): array {
  return [
    'stripe_publishable_key' => $_ENV['STRIPE_PUBLISHABLE_KEY'] ?? getenv('STRIPE_PUBLISHABLE_KEY') ?: '',
    'stripe_buy_button_id' => $_ENV['STRIPE_BUY_BUTTON_ID'] ?? getenv('STRIPE_BUY_BUTTON_ID') ?: '',
    'stripe_secret_key' => $_ENV['STRIPE_SECRET_KEY'] ?? getenv('STRIPE_SECRET_KEY') ?: '',
    'stripe_webhook_secret' => $_ENV['STRIPE_WEBHOOK_SECRET'] ?? getenv('STRIPE_WEBHOOK_SECRET') ?: '',
    'entitlement_key' => $_ENV['NRLC_ENTITLEMENT_KEY'] ?? getenv('NRLC_ENTITLEMENT_KEY') ?: 'ai_search_bible',
    'price_label' => $_ENV['AI_SEARCH_BIBLE_PRICE_LABEL'] ?? getenv('AI_SEARCH_BIBLE_PRICE_LABEL') ?: '$99',
  ];
}

function ai_search_bible_entitlement_key(): string {
  $cfg = ai_search_bible_paywall_config();
  return $cfg['entitlement_key'];
}

function ai_search_bible_get_entitlement_for_user(string $userId): ?array {
  $pdo = nrlc_pdo();
  if (!$pdo) {
    return null;
  }
  $sql = 'SELECT user_id, entitlement_key, status, stripe_customer_id, stripe_payment_intent_id, stripe_checkout_session_id, updated_at
          FROM entitlements
          WHERE user_id = :user_id AND entitlement_key = :entitlement_key
          LIMIT 1';
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ':user_id' => $userId,
    ':entitlement_key' => ai_search_bible_entitlement_key(),
  ]);
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  return is_array($row) ? $row : null;
}

function ai_search_bible_user_has_active_entitlement(string $userId): bool {
  $entitlement = ai_search_bible_get_entitlement_for_user($userId);
  return is_array($entitlement) && ($entitlement['status'] ?? '') === 'active';
}

function ai_search_bible_event_already_processed(string $eventId): bool {
  $pdo = nrlc_pdo();
  if (!$pdo || $eventId === '') {
    return false;
  }
  $stmt = $pdo->prepare('SELECT 1 FROM webhook_events WHERE stripe_event_id = :event_id AND processed_ok = TRUE LIMIT 1');
  $stmt->execute([':event_id' => $eventId]);
  return (bool)$stmt->fetchColumn();
}

function ai_search_bible_upsert_webhook_event(array $payload): bool {
  $pdo = nrlc_pdo();
  if (!$pdo) {
    return false;
  }
  $sql = 'INSERT INTO webhook_events
    (stripe_event_id, type, received_at, processed_ok, error_message, user_id, email, entitlement_key)
    VALUES
    (:stripe_event_id, :type, NOW(), :processed_ok, :error_message, :user_id, :email, :entitlement_key)
    ON CONFLICT (stripe_event_id)
    DO UPDATE SET
      type = EXCLUDED.type,
      processed_ok = EXCLUDED.processed_ok,
      error_message = EXCLUDED.error_message,
      user_id = EXCLUDED.user_id,
      email = EXCLUDED.email,
      entitlement_key = EXCLUDED.entitlement_key';
  $stmt = $pdo->prepare($sql);
  return $stmt->execute([
    ':stripe_event_id' => (string)($payload['stripe_event_id'] ?? ''),
    ':type' => (string)($payload['type'] ?? ''),
    ':processed_ok' => !empty($payload['processed_ok']) ? 'true' : 'false',
    ':error_message' => (string)($payload['error_message'] ?? ''),
    ':user_id' => (string)($payload['user_id'] ?? ''),
    ':email' => (string)($payload['email'] ?? ''),
    ':entitlement_key' => (string)($payload['entitlement_key'] ?? ai_search_bible_entitlement_key()),
  ]);
}

function ai_search_bible_recent_webhook_events(int $limit = 100): array {
  $pdo = nrlc_pdo();
  if (!$pdo) {
    return [];
  }
  $limit = max(1, min(500, $limit));
  $stmt = $pdo->query('SELECT stripe_event_id, type, received_at, processed_ok, error_message, user_id, email, entitlement_key
                       FROM webhook_events
                       ORDER BY received_at DESC
                       LIMIT ' . (int)$limit);
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return is_array($rows) ? $rows : [];
}

function ai_search_bible_upsert_entitlement(array $payload): bool {
  $pdo = nrlc_pdo();
  if (!$pdo) {
    return false;
  }
  $sql = 'INSERT INTO entitlements
    (user_id, entitlement_key, status, stripe_customer_id, stripe_payment_intent_id, stripe_checkout_session_id, stripe_event_id_last, created_at, updated_at)
    VALUES
    (:user_id, :entitlement_key, :status, :stripe_customer_id, :stripe_payment_intent_id, :stripe_checkout_session_id, :stripe_event_id_last, NOW(), NOW())
    ON CONFLICT (user_id, entitlement_key)
    DO UPDATE SET
      status = EXCLUDED.status,
      stripe_customer_id = EXCLUDED.stripe_customer_id,
      stripe_payment_intent_id = EXCLUDED.stripe_payment_intent_id,
      stripe_checkout_session_id = EXCLUDED.stripe_checkout_session_id,
      stripe_event_id_last = EXCLUDED.stripe_event_id_last,
      updated_at = NOW()';
  $stmt = $pdo->prepare($sql);
  return $stmt->execute([
    ':user_id' => (string)($payload['user_id'] ?? ''),
    ':entitlement_key' => ai_search_bible_entitlement_key(),
    ':status' => (string)($payload['status'] ?? 'active'),
    ':stripe_customer_id' => (string)($payload['stripe_customer_id'] ?? ''),
    ':stripe_payment_intent_id' => (string)($payload['stripe_payment_intent_id'] ?? ''),
    ':stripe_checkout_session_id' => (string)($payload['stripe_checkout_session_id'] ?? ''),
    ':stripe_event_id_last' => (string)($payload['stripe_event_id_last'] ?? ''),
  ]);
}

function ai_search_bible_verify_webhook_signature(string $payload, string $signatureHeader): bool {
  $cfg = ai_search_bible_paywall_config();
  $secret = $cfg['stripe_webhook_secret'];
  if ($secret === '' || $signatureHeader === '') {
    return false;
  }

  $parts = explode(',', $signatureHeader);
  $timestamp = null;
  $signatures = [];
  foreach ($parts as $part) {
    $kv = explode('=', trim($part), 2);
    if (count($kv) !== 2) {
      continue;
    }
    if ($kv[0] === 't') {
      $timestamp = $kv[1];
    } elseif ($kv[0] === 'v1') {
      $signatures[] = $kv[1];
    }
  }

  if (!$timestamp || empty($signatures)) {
    return false;
  }

  if (abs(time() - (int)$timestamp) > 300) {
    return false;
  }

  $signedPayload = $timestamp . '.' . $payload;
  $expected = hash_hmac('sha256', $signedPayload, $secret);
  foreach ($signatures as $signature) {
    if (hash_equals($expected, $signature)) {
      return true;
    }
  }
  return false;
}

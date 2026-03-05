<?php
declare(strict_types=1);

require_once __DIR__ . '/../lib/auth.php';
require_once __DIR__ . '/../lib/ai_search_bible_paywall.php';

header('Content-Type: application/json; charset=UTF-8');

if (!is_authenticated()) {
  http_response_code(401);
  echo json_encode(['ok' => false, 'error' => 'Authentication required']);
  exit;
}

$userId = current_user_id();
if ($userId === null) {
  http_response_code(400);
  echo json_encode(['ok' => false, 'error' => 'Invalid user']);
  exit;
}

$row = ai_search_bible_get_entitlement_for_user($userId);
$active = is_array($row) && ($row['status'] ?? '') === 'active';

echo json_encode([
  'ok' => true,
  'ai_search_bible' => $active,
  'status' => $row['status'] ?? 'inactive',
  'updated_at' => $row['updated_at'] ?? null,
]);

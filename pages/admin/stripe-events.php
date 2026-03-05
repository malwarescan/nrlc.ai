<?php
declare(strict_types=1);

require_once __DIR__ . '/../../lib/ai_search_bible_paywall.php';

$events = ai_search_bible_recent_webhook_events(200);
?>

<main role="main" class="container">
  <section class="section">
    <div class="section__content">
      <div class="content-block module">
        <div class="content-block__header">
          <h1 class="content-block__title heading-1">Stripe Webhook Events</h1>
        </div>
        <div class="content-block__body">
          <p>Recent webhook processing results for AI Search Bible entitlement unlock flow.</p>
          <?php if (empty($events)): ?>
            <p>No webhook events found.</p>
          <?php else: ?>
            <div style="overflow-x: auto;">
              <table style="width: 100%; border-collapse: collapse;">
                <thead>
                  <tr>
                    <th style="text-align: left; border-bottom: 1px solid #ccc; padding: 8px;">Received</th>
                    <th style="text-align: left; border-bottom: 1px solid #ccc; padding: 8px;">Stripe Event ID</th>
                    <th style="text-align: left; border-bottom: 1px solid #ccc; padding: 8px;">Type</th>
                    <th style="text-align: left; border-bottom: 1px solid #ccc; padding: 8px;">Processed</th>
                    <th style="text-align: left; border-bottom: 1px solid #ccc; padding: 8px;">User</th>
                    <th style="text-align: left; border-bottom: 1px solid #ccc; padding: 8px;">Email</th>
                    <th style="text-align: left; border-bottom: 1px solid #ccc; padding: 8px;">Entitlement</th>
                    <th style="text-align: left; border-bottom: 1px solid #ccc; padding: 8px;">Error</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($events as $event): ?>
                    <tr>
                      <td style="border-bottom: 1px solid #eee; padding: 8px; white-space: nowrap;"><?= htmlspecialchars((string)($event['received_at'] ?? '')) ?></td>
                      <td style="border-bottom: 1px solid #eee; padding: 8px; font-family: ui-monospace, Menlo, Monaco, Consolas, monospace;"><?= htmlspecialchars((string)($event['stripe_event_id'] ?? '')) ?></td>
                      <td style="border-bottom: 1px solid #eee; padding: 8px;"><?= htmlspecialchars((string)($event['type'] ?? '')) ?></td>
                      <td style="border-bottom: 1px solid #eee; padding: 8px;"><?= !empty($event['processed_ok']) ? 'yes' : 'no' ?></td>
                      <td style="border-bottom: 1px solid #eee; padding: 8px;"><?= htmlspecialchars((string)($event['user_id'] ?? '')) ?></td>
                      <td style="border-bottom: 1px solid #eee; padding: 8px;"><?= htmlspecialchars((string)($event['email'] ?? '')) ?></td>
                      <td style="border-bottom: 1px solid #eee; padding: 8px;"><?= htmlspecialchars((string)($event['entitlement_key'] ?? '')) ?></td>
                      <td style="border-bottom: 1px solid #eee; padding: 8px;"><?= htmlspecialchars((string)($event['error_message'] ?? '')) ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>
</main>

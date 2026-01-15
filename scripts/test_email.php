#!/usr/bin/env php
<?php
/**
 * Test Email Sending
 * Run this script to test if SMTP email is configured correctly
 * Usage: php scripts/test_email.php
 */

require_once __DIR__ . '/../lib/smtp_email.php';

echo "Testing Email Configuration...\n\n";

// Check environment variables
$smtp_host = $_ENV['SMTP_HOST'] ?? 'smtp.gmail.com';
$smtp_port = $_ENV['SMTP_PORT'] ?? 587;
$smtp_username = $_ENV['SMTP_USERNAME'] ?? '';
$smtp_password = $_ENV['SMTP_PASSWORD'] ?? '';

echo "SMTP Configuration:\n";
echo "  Host: " . ($smtp_host ?: 'NOT SET') . "\n";
echo "  Port: " . ($smtp_port ?: 'NOT SET') . "\n";
echo "  Username: " . ($smtp_username ? 'SET (hidden)' : 'NOT SET') . "\n";
echo "  Password: " . ($smtp_password ? 'SET (hidden)' : 'NOT SET') . "\n\n";

if (empty($smtp_username) || empty($smtp_password)) {
  echo "❌ ERROR: SMTP credentials not configured!\n\n";
  echo "To fix this, set these environment variables in Railway:\n";
  echo "  SMTP_HOST=smtp.gmail.com\n";
  echo "  SMTP_PORT=587\n";
  echo "  SMTP_USERNAME=your-email@gmail.com\n";
  echo "  SMTP_PASSWORD=your-app-password\n";
  echo "  SMTP_FROM_EMAIL=noreply@nrlc.ai\n";
  echo "  SMTP_FROM_NAME=NRLC.ai\n\n";
  echo "See EMAIL_SETUP.md for detailed instructions.\n";
  exit(1);
}

// Test email to info@neuralcommandllc.com
$test_to = 'info@neuralcommandllc.com';
$test_subject = 'Test Email from NRLC.ai Booking System';
$test_message = "This is a test email to verify SMTP configuration is working.\n\n";
$test_message .= "Sent at: " . date('Y-m-d H:i:s') . "\n";
$test_message .= "SMTP Host: $smtp_host\n";
$test_message .= "SMTP Port: $smtp_port\n";

echo "Sending test email to: $test_to\n";
echo "Subject: $test_subject\n\n";

$result = send_email_via_smtp($test_to, $test_subject, $test_message, [
  'Reply-To' => 'info@neuralcommandllc.com'
]);

if ($result) {
  echo "✅ SUCCESS: Test email sent!\n";
  echo "Check the inbox at $test_to to confirm delivery.\n";
  exit(0);
} else {
  echo "❌ FAILED: Could not send test email.\n";
  echo "Check Railway logs for SMTP connection errors.\n";
  echo "Common issues:\n";
  echo "  - Incorrect SMTP credentials\n";
  echo "  - Gmail requires App Password (not regular password)\n";
  echo "  - Firewall blocking SMTP port\n";
  exit(1);
}
?>

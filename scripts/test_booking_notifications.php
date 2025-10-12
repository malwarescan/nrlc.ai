<?php
declare(strict_types=1);

/**
 * Test script for booking notifications
 * Tests SMS and email functionality
 */

// Test booking data
$test_booking = [
  'name' => 'Test User',
  'email' => 'test@example.com',
  'company' => 'Test Company',
  'website' => 'https://test.com',
  'service_interest' => 'crawl-clarity',
  'current_challenges' => 'Testing the booking system',
  'preferred_time' => 'morning',
  'submitted_at' => date('Y-m-d H:i:s'),
  'ip_address' => '127.0.0.1',
  'user_agent' => 'Test Script'
];

echo "Testing booking notifications...\n\n";

// Test SMS
echo "1. Testing SMS notification:\n";
require_once __DIR__ . '/send_sms.php';
$sms_result = send_sms_via_twilio('12135628438', 'Test SMS from booking system');
echo "SMS result: " . ($sms_result ? "SUCCESS" : "FAILED") . "\n\n";

// Test email notification
echo "2. Testing email notification:\n";
function test_send_email_notification($booking_data) {
  $to = 'hirejoelm@gmail.com';
  $subject = 'TEST: New Consultation Request - ' . $booking_data['name'];
  
  $message = "
TEST EMAIL - New consultation request received:

Name: {$booking_data['name']}
Email: {$booking_data['email']}
Company: {$booking_data['company']}
Website: {$booking_data['website']}
Service Interest: {$booking_data['service_interest']}
Current Challenges: {$booking_data['current_challenges']}
Preferred Time: {$booking_data['preferred_time']}

Submitted: {$booking_data['submitted_at']}
IP Address: {$booking_data['ip_address']}

This is a test email from the booking system.
";
  
  $headers = [
    'From: noreply@nrlc.ai',
    'Reply-To: ' . $booking_data['email'],
    'X-Mailer: PHP/' . phpversion(),
    'Content-Type: text/plain; charset=UTF-8'
  ];
  
  $email_sent = mail($to, $subject, $message, implode("\r\n", $headers));
  
  // Log email attempt
  $email_log = date('Y-m-d H:i:s') . " - TEST Email to $to: " . ($email_sent ? 'SUCCESS' : 'FAILED') . "\n";
  file_put_contents(__DIR__ . '/../logs/email.log', $email_log, FILE_APPEND | LOCK_EX);
  
  return $email_sent;
}

$email_result = test_send_email_notification($test_booking);
echo "Email result: " . ($email_result ? "SUCCESS" : "FAILED") . "\n\n";

// Test confirmation email
echo "3. Testing confirmation email:\n";
function test_send_confirmation_email($booking_data) {
  $to = $booking_data['email'];
  $subject = 'TEST: Consultation Request Received - NRLC.ai';
  
  $message = "
TEST EMAIL - Dear {$booking_data['name']},

Thank you for your interest in NRLC.ai's AI-first SEO services. We have received your consultation request for {$booking_data['service_interest']}.

This is a test confirmation email from the booking system.

Best regards,
The NRLC.ai Team
";
  
  $headers = [
    'From: noreply@nrlc.ai',
    'Reply-To: hirejoelm@gmail.com',
    'X-Mailer: PHP/' . phpversion(),
    'Content-Type: text/plain; charset=UTF-8'
  ];
  
  $confirmation_sent = mail($to, $subject, $message, implode("\r\n", $headers));
  
  // Log confirmation email attempt
  $confirmation_log = date('Y-m-d H:i:s') . " - TEST Confirmation email to $to: " . ($confirmation_sent ? 'SUCCESS' : 'FAILED') . "\n";
  file_put_contents(__DIR__ . '/../logs/confirmation.log', $confirmation_log, FILE_APPEND | LOCK_EX);
  
  return $confirmation_sent;
}

$confirmation_result = test_send_confirmation_email($test_booking);
echo "Confirmation email result: " . ($confirmation_result ? "SUCCESS" : "FAILED") . "\n\n";

echo "Test completed!\n";
echo "Check the following log files:\n";
echo "- logs/sms.log\n";
echo "- logs/email.log\n";
echo "- logs/confirmation.log\n";
echo "- logs/bookings.log\n";
?>

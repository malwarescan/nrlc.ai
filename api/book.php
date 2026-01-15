<?php
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

// Validate required fields (only name and email are required now)
$required_fields = ['name', 'email'];
$errors = [];

foreach ($required_fields as $field) {
  if (empty($_POST[$field])) {
    $errors[] = "Field '$field' is required";
  }
}

// Validate email format
if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  $errors[] = 'Invalid email format';
}

// If there are validation errors, return them
if (!empty($errors)) {
  http_response_code(400);
  echo json_encode(['ok' => false, 'errors' => $errors]);
  exit;
}

// Sanitize input data (with defaults for optional fields)
$booking_data = [
  'name' => htmlspecialchars(trim($_POST['name'])),
  'email' => htmlspecialchars(trim($_POST['email'])),
  'company' => htmlspecialchars(trim($_POST['company'] ?? '')),
  'website' => htmlspecialchars(trim($_POST['website'] ?? '')),
  'service_interest' => htmlspecialchars(trim($_POST['service_interest'] ?? 'General AI SEO Consultation')),
  'current_challenges' => htmlspecialchars(trim($_POST['current_challenges'] ?? '')),
  'preferred_time' => htmlspecialchars(trim($_POST['preferred_time'] ?? '')),
  'submitted_at' => date('Y-m-d H:i:s'),
  'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
  'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
];

// Log the booking (in a real implementation, you'd save to database)
$log_entry = date('Y-m-d H:i:s') . " - Booking Request:\n" . 
  "Name: " . $booking_data['name'] . "\n" .
  "Email: " . $booking_data['email'] . "\n" .
  "Company: " . $booking_data['company'] . "\n" .
  "Website: " . $booking_data['website'] . "\n" .
  "Service Interest: " . $booking_data['service_interest'] . "\n" .
  "Challenges: " . $booking_data['current_challenges'] . "\n" .
  "Preferred Time: " . $booking_data['preferred_time'] . "\n" .
  "IP: " . $booking_data['ip_address'] . "\n" .
  "User Agent: " . $booking_data['user_agent'] . "\n" .
  "---\n\n";

// Write to log file (create logs directory if it doesn't exist)
$logs_dir = __DIR__ . '/../logs';
if (!is_dir($logs_dir)) {
  mkdir($logs_dir, 0755, true);
}

file_put_contents($logs_dir . '/bookings.log', $log_entry, FILE_APPEND | LOCK_EX);

// Send SMS notification
$sms_sent = send_sms_notification($booking_data);

// Send email notification
$email_sent = send_email_notification($booking_data);

// Send confirmation email to user
$confirmation_sent = send_confirmation_email($booking_data);

// Return success with notification status
echo json_encode([
  'ok' => true, 
  'message' => 'Booking request received successfully. We will contact you within 24 hours.',
  'booking_id' => 'BK-' . date('Ymd') . '-' . substr(md5($booking_data['email'] . time()), 0, 8),
  'notifications' => [
    'sms_sent' => $sms_sent,
    'email_sent' => $email_sent,
    'confirmation_sent' => $confirmation_sent
  ]
]);

function send_sms_notification($booking_data) {
  $phone_number = '12135628438';
  $message = "New consultation request from {$booking_data['name']} ({$booking_data['email']}). Service: {$booking_data['service_interest']}. Company: {$booking_data['company']}";
  
  // Include SMS sending function
  require_once __DIR__ . '/../scripts/send_sms.php';
  
  return send_sms_via_twilio($phone_number, $message);
}

function send_email_notification($booking_data) {
  require_once __DIR__ . '/../lib/smtp_email.php';
  
  $to = 'info@neuralcommandllc.com';
  $subject = 'New Consultation Request - ' . $booking_data['name'];
  
  $message = "
New consultation request received:

Name: {$booking_data['name']}
Email: {$booking_data['email']}
Company: {$booking_data['company']}
Website: {$booking_data['website']}
Service Interest: {$booking_data['service_interest']}
Current Challenges: {$booking_data['current_challenges']}
Preferred Time: {$booking_data['preferred_time']}

Submitted: {$booking_data['submitted_at']}
IP Address: {$booking_data['ip_address']}

Please respond within 24 hours.
";
  
  $headers = [
    'Reply-To' => $booking_data['email']
  ];
  
  // Ensure logs directory exists
  $logs_dir = __DIR__ . '/../logs';
  if (!is_dir($logs_dir)) {
    mkdir($logs_dir, 0755, true);
  }
  
  // Try SMTP first, fallback to mail()
  $email_sent = send_email_via_smtp($to, $subject, $message, $headers);
  
  // Detailed logging with error info
  $email_log = date('Y-m-d H:i:s') . " - Email to $to: " . ($email_sent ? 'SUCCESS' : 'FAILED');
  if (!$email_sent) {
    $email_log .= " (SMTP/mail() failed - check mail server configuration)";
  }
  $email_log .= "\n";
  file_put_contents($logs_dir . '/email.log', $email_log, FILE_APPEND | LOCK_EX);
  
  // Also log the full email body for debugging
  $full_log = date('Y-m-d H:i:s') . " - FULL EMAIL:\nTo: $to\nSubject: $subject\nMessage:\n$message\n---\n\n";
  file_put_contents($logs_dir . '/email_full.log', $full_log, FILE_APPEND | LOCK_EX);
  
  return $email_sent;
}

function send_confirmation_email($booking_data) {
  require_once __DIR__ . '/../lib/smtp_email.php';
  
  $to = $booking_data['email'];
  $subject = 'Consultation Request Received - NRLC.ai';
  
  $message = "
Dear {$booking_data['name']},

Thank you for your interest in NRLC.ai's AI-first SEO services. We have received your consultation request for {$booking_data['service_interest']}.

Our team will review your request and contact you within 24 hours to schedule your consultation.

Request Details:
- Service: {$booking_data['service_interest']}
- Preferred Time: {$booking_data['preferred_time']}
- Submitted: {$booking_data['submitted_at']}

If you have any questions in the meantime, please don't hesitate to contact us.

Best regards,
The NRLC.ai Team

---
NRLC.ai - Optimizing the Internet for AI Understanding
Website: https://nrlc.ai
Email: info@neuralcommandllc.com
";
  
  $headers = [
    'Reply-To' => 'info@neuralcommandllc.com'
  ];
  
  // Try SMTP first, fallback to mail()
  $confirmation_sent = send_email_via_smtp($to, $subject, $message, $headers);
  
  // Log confirmation email attempt
  $confirmation_log = date('Y-m-d H:i:s') . " - Confirmation email to $to: " . ($confirmation_sent ? 'SUCCESS' : 'FAILED') . "\n";
  file_put_contents(__DIR__ . '/../logs/confirmation.log', $confirmation_log, FILE_APPEND | LOCK_EX);
  
  return $confirmation_sent;
}
?>


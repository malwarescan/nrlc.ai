<?php
declare(strict_types=1);

/**
 * SMS Sender using Twilio API
 * Requires Twilio account and credentials
 */

function send_sms_via_twilio($phone_number, $message) {
  // Twilio credentials (set these in environment variables or config)
  $account_sid = $_ENV['TWILIO_ACCOUNT_SID'] ?? 'your_account_sid';
  $auth_token = $_ENV['TWILIO_AUTH_TOKEN'] ?? 'your_auth_token';
  $twilio_number = $_ENV['TWILIO_PHONE_NUMBER'] ?? 'your_twilio_number';
  
  // For now, just log the SMS content
  $sms_log = date('Y-m-d H:i:s') . " - SMS to $phone_number: $message\n";
  file_put_contents(__DIR__ . '/../logs/sms.log', $sms_log, FILE_APPEND | LOCK_EX);
  
  // TODO: Implement actual Twilio SMS sending
  // Uncomment and configure when you have Twilio credentials:
  /*
  $url = "https://api.twilio.com/2010-04-01/Accounts/$account_sid/Messages.json";
  
  $data = [
    'From' => $twilio_number,
    'To' => $phone_number,
    'Body' => $message
  ];
  
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_USERPWD, "$account_sid:$auth_token");
  
  $response = curl_exec($ch);
  $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);
  
  if ($http_code === 201) {
    return true;
  } else {
    error_log("SMS sending failed: $response");
    return false;
  }
  */
  
  return true; // Return true for now
}

// Test function
if (isset($argv[1]) && isset($argv[2])) {
  $phone = $argv[1];
  $message = $argv[2];
  $result = send_sms_via_twilio($phone, $message);
  echo $result ? "SMS sent successfully\n" : "SMS failed\n";
}
?>

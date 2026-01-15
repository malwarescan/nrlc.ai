<?php
/**
 * SMTP Email Sender
 * Sends emails via SMTP when PHP mail() function is not available
 */

function send_email_via_smtp($to, $subject, $message, $headers = []) {
  // SMTP Configuration from environment variables
  $smtp_host = $_ENV['SMTP_HOST'] ?? 'smtp.gmail.com';
  $smtp_port = $_ENV['SMTP_PORT'] ?? 587;
  $smtp_username = $_ENV['SMTP_USERNAME'] ?? '';
  $smtp_password = $_ENV['SMTP_PASSWORD'] ?? '';
  $smtp_from_email = $_ENV['SMTP_FROM_EMAIL'] ?? 'noreply@nrlc.ai';
  $smtp_from_name = $_ENV['SMTP_FROM_NAME'] ?? 'NRLC.ai';
  
  // If no SMTP credentials, log error and return false
  // PHP mail() doesn't work on Railway without SMTP
  if (empty($smtp_username) || empty($smtp_password)) {
    error_log("SMTP not configured: SMTP_USERNAME or SMTP_PASSWORD missing. Set environment variables in Railway.");
    // Don't try mail() on Railway - it won't work
    return false;
  }
  
  // Build email headers
  $email_headers = [
    'From: ' . $smtp_from_name . ' <' . $smtp_from_email . '>',
    'Reply-To: ' . ($headers['Reply-To'] ?? $smtp_from_email),
    'X-Mailer: PHP/' . phpversion(),
    'Content-Type: text/plain; charset=UTF-8',
    'MIME-Version: 1.0'
  ];
  
  // Add any additional headers
  foreach ($headers as $key => $value) {
    if ($key !== 'Reply-To' && !in_array($key, ['From', 'X-Mailer', 'Content-Type', 'MIME-Version'])) {
      $email_headers[] = "$key: $value";
    }
  }
  
  $email_body = $message;
  $email_headers_string = implode("\r\n", $email_headers);
  
  // Use PHPMailer-style SMTP if available, otherwise use socket-based SMTP
  // For now, we'll use a simple socket-based approach
  try {
    $smtp = fsockopen($smtp_host, $smtp_port, $errno, $errstr, 30);
    
    if (!$smtp) {
      error_log("SMTP connection failed: $errstr ($errno)");
      return false;
    }
    
    // Read server greeting
    $response = fgets($smtp, 515);
    if (substr($response, 0, 3) !== '220') {
      error_log("SMTP greeting failed: $response");
      fclose($smtp);
      return false;
    }
    
    // Send EHLO
    fputs($smtp, "EHLO " . $smtp_host . "\r\n");
    $response = '';
    while ($line = fgets($smtp, 515)) {
      $response .= $line;
      if (substr($line, 3, 1) === ' ') break;
    }
    
    // Start TLS if port is 587
    if ($smtp_port == 587) {
      fputs($smtp, "STARTTLS\r\n");
      $response = fgets($smtp, 515);
      if (substr($response, 0, 3) !== '220') {
        error_log("STARTTLS failed: $response");
        fclose($smtp);
        return false;
      }
      stream_socket_enable_crypto($smtp, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
      
      // Send EHLO again after TLS
      fputs($smtp, "EHLO " . $smtp_host . "\r\n");
      $response = '';
      while ($line = fgets($smtp, 515)) {
        $response .= $line;
        if (substr($line, 3, 1) === ' ') break;
      }
    }
    
    // Authenticate
    fputs($smtp, "AUTH LOGIN\r\n");
    $response = fgets($smtp, 515);
    if (substr($response, 0, 3) !== '334') {
      error_log("AUTH LOGIN failed: $response");
      fclose($smtp);
      return false;
    }
    
    fputs($smtp, base64_encode($smtp_username) . "\r\n");
    $response = fgets($smtp, 515);
    if (substr($response, 0, 3) !== '334') {
      error_log("Username authentication failed: $response");
      fclose($smtp);
      return false;
    }
    
    fputs($smtp, base64_encode($smtp_password) . "\r\n");
    $response = fgets($smtp, 515);
    if (substr($response, 0, 3) !== '235') {
      error_log("Password authentication failed: $response");
      fclose($smtp);
      return false;
    }
    
    // Send MAIL FROM
    fputs($smtp, "MAIL FROM: <" . $smtp_from_email . ">\r\n");
    $response = fgets($smtp, 515);
    if (substr($response, 0, 3) !== '250') {
      error_log("MAIL FROM failed: $response");
      fclose($smtp);
      return false;
    }
    
    // Send RCPT TO
    fputs($smtp, "RCPT TO: <" . $to . ">\r\n");
    $response = fgets($smtp, 515);
    if (substr($response, 0, 3) !== '250') {
      error_log("RCPT TO failed: $response");
      fclose($smtp);
      return false;
    }
    
    // Send DATA
    fputs($smtp, "DATA\r\n");
    $response = fgets($smtp, 515);
    if (substr($response, 0, 3) !== '354') {
      error_log("DATA command failed: $response");
      fclose($smtp);
      return false;
    }
    
    // Send email content
    fputs($smtp, "Subject: " . $subject . "\r\n");
    fputs($smtp, $email_headers_string . "\r\n");
    fputs($smtp, "\r\n");
    fputs($smtp, $email_body . "\r\n");
    fputs($smtp, ".\r\n");
    
    $response = fgets($smtp, 515);
    if (substr($response, 0, 3) !== '250') {
      error_log("Email sending failed: $response");
      fclose($smtp);
      return false;
    }
    
    // Quit
    fputs($smtp, "QUIT\r\n");
    fclose($smtp);
    
    return true;
    
  } catch (Exception $e) {
    error_log("SMTP error: " . $e->getMessage());
    return false;
  }
}

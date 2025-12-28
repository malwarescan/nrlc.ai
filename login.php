<?php
/**
 * NRLC AI Case Study System - Login Page
 */

require_once __DIR__ . '/lib/auth.php';

$error = '';
$redirect = $_GET['redirect'] ?? '/';

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $password = $_POST['password'] ?? '';
  
  if (empty($username) || empty($password)) {
    $error = 'Username and password required';
  } elseif (authenticate($username, $password)) {
    header('Location: ' . $redirect);
    exit;
  } else {
    $error = 'Invalid username or password';
  }
}

// If already logged in, redirect
if (is_authenticated()) {
  header('Location: ' . $redirect);
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | NRLC.ai Admin</title>
  <style>
    body {
      font-family: system-ui, sans-serif;
      max-width: 400px;
      margin: 4rem auto;
      padding: 2rem;
      background: #f5f5f5;
    }
    .login-box {
      background: white;
      padding: 2rem;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    h1 {
      margin-top: 0;
      color: #333;
    }
    .error {
      background: #fee;
      border: 1px solid #fcc;
      padding: 0.75rem;
      border-radius: 4px;
      margin-bottom: 1rem;
      color: #c00;
    }
    label {
      display: block;
      margin-top: 1rem;
      font-weight: 600;
      color: #333;
    }
    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 0.75rem;
      margin-top: 0.25rem;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }
    button {
      width: 100%;
      background: #0066cc;
      color: white;
      padding: 0.75rem;
      border: none;
      border-radius: 4px;
      margin-top: 1.5rem;
      font-size: 1rem;
      cursor: pointer;
    }
    button:hover {
      background: #0052a3;
    }
    .note {
      margin-top: 1rem;
      font-size: 0.875rem;
      color: #666;
    }
  </style>
</head>
<body>
  <div class="login-box">
    <h1>NRLC.ai Admin Login</h1>
    
    <?php if ($error): ?>
      <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    
    <form method="POST">
      <label>
        Username
        <input type="text" name="username" required autofocus>
      </label>
      
      <label>
        Password
        <input type="password" name="password" required>
      </label>
      
      <input type="hidden" name="redirect" value="<?= htmlspecialchars($redirect) ?>">
      
      <button type="submit">Login</button>
    </form>
    
    <div class="note">
      <strong>Default credentials (change in production):</strong><br>
      Admin: admin / admin<br>
      Client: client / client
    </div>
  </div>
</body>
</html>


<?php
/**
 * NRLC AI Case Study System - User Configuration
 * 
 * Copy this file to users.php and set your passwords.
 * DO NOT commit users.php to version control.
 * 
 * In production, use environment variables or database.
 */

return [
  [
    'id' => 1,
    'username' => 'admin',
    'password_hash' => password_hash('CHANGE_THIS_PASSWORD', PASSWORD_DEFAULT),
    'role' => 'admin',
    'name' => 'Admin'
  ],
  [
    'id' => 2,
    'username' => 'client',
    'password_hash' => password_hash('CHANGE_THIS_PASSWORD', PASSWORD_DEFAULT),
    'role' => 'client',
    'name' => 'Client'
  ]
];


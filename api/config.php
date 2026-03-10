<?php
// Configure session cookie settings BEFORE starting session
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_samesite', 'Lax');
ini_set('session.use_only_cookies', 1);

session_start();

// LOCAL MySQL settings (XAMPP / WAMP typical)
$servername = "localhost";
$username   = "root";          // 👈 default local user
$password   = "";              // 👈 empty password
$database   = "cs2team56_db";  // make sure this database exists

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    http_response_code(500);
    die(json_encode([
        'success' => false,
        'error'   => 'Database connection failed: ' . $conn->connect_error
    ]));
}

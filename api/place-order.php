<?php
// Configure session cookies BEFORE starting session
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_samesite', 'Lax');
ini_set('session.use_only_cookies', 1);

session_start();

// clear cart to simulate order completion
$_SESSION["cart"] = [];

echo json_encode([
    "success" => true,
    "message" => "Order placed successfully!"
]);
?>

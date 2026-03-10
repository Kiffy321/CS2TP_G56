<?php
// Configure session cookies BEFORE starting session
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_samesite', 'Lax');
ini_set('session.use_only_cookies', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
    header('Access-Control-Allow-Credentials: true');
}
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

$data = json_decode(file_get_contents('php://input'), true);
$index = intval($data['index'] ?? -1);

if ($index < 0 || !isset($_SESSION['cart'][$index])) {
    echo json_encode(['error' => 'Invalid item']);
    exit;
}

// Remove item from cart
array_splice($_SESSION['cart'], $index, 1);

echo json_encode([
    'success' => true,
    'message' => 'Item removed from cart'
]);
?>

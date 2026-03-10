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
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

error_reporting(E_ALL);
ini_set('display_errors', 1);

$cartItems = [];
$total = 0;

if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $subtotal = floatval($item['price']) * intval($item['quantity']);
        $total += $subtotal;
        
        $cartItems[] = [
            'name' => $item['name'],
            'quantity' => intval($item['quantity']),
            'price' => floatval($item['price']),
            'subtotal' => $subtotal
        ];
    }
}

echo json_encode([
    'items' => $cartItems,
    'total' => $total,
    'count' => count($cartItems),
    'sessionId' => session_id(),
    'debug' => [
        'cartExists' => isset($_SESSION['cart']),
        'cartIsArray' => is_array($_SESSION['cart'] ?? null),
        'cartCount' => count($_SESSION['cart'] ?? [])
    ]
]);
?>

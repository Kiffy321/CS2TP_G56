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
error_reporting(E_ALL);
ini_set('display_errors', 1);

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['index']) || !isset($data['quantity'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Index and quantity required']);
    exit;
}

$index = intval($data['index']);
$quantity = intval($data['quantity']);

if ($quantity < 1) {
    http_response_code(400);
    echo json_encode(['error' => 'Quantity must be at least 1']);
    exit;
}

if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart']) || !isset($_SESSION['cart'][$index])) {
    http_response_code(400);
    echo json_encode(['error' => 'Item not found in cart']);
    exit;
}

$_SESSION['cart'][$index]['quantity'] = $quantity;

echo json_encode([
    'success' => true,
    'message' => 'Quantity updated',
    'newSubtotal' => $_SESSION['cart'][$index]['quantity'] * $_SESSION['cart'][$index]['price']
]);
?>

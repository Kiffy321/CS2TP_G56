<?php
// Configure session cookies BEFORE starting session
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_samesite', 'Lax');
ini_set('session.use_only_cookies', 1);

// Start session FIRST before any headers
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');
// Allow credentials with CORS
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
    header('Access-Control-Allow-Credentials: true');
}
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get raw input
$rawInput = file_get_contents('php://input');
$data = json_decode($rawInput, true);

// Check if JSON is valid
if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON format', 'details' => json_last_error_msg()]);
    exit;
}

// Validate required fields
if (!isset($data['productName']) || empty(trim($data['productName']))) {
    http_response_code(400);
    echo json_encode(['error' => 'Product name is required']);
    exit;
}

if (!isset($data['quantity'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Quantity is required']);
    exit;
}

if (!isset($data['price'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Price is required']);
    exit;
}

$productName = trim($data['productName']);
$quantity = intval($data['quantity']);
$price = floatval($data['price']);

// Validate values
if ($quantity < 1 || $quantity > 1000) {
    http_response_code(400);
    echo json_encode(['error' => 'Quantity must be between 1 and 1000']);
    exit;
}

if ($price < 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Price cannot be negative']);
    exit;
}

// Initialize cart in session
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Check if product already exists in cart
$found = false;
foreach ($_SESSION['cart'] as $key => &$item) {
    if (isset($item['name']) && $item['name'] === $productName) {
        $_SESSION['cart'][$key]['quantity'] += $quantity;
        $found = true;
        break;
    }
}

// If product not in cart, add it
if (!$found) {
    $_SESSION['cart'][] = [
        'name' => $productName,
        'quantity' => $quantity,
        'price' => $price
    ];
}

// Return success response
http_response_code(200);

// Calculate total quantity in cart
$totalQuantity = 0;
foreach ($_SESSION['cart'] as $item) {
    $totalQuantity += $item['quantity'];
}

echo json_encode([
    'success' => true,
    'message' => 'Product added to cart',
    'cartCount' => $totalQuantity,
    'cartTotal' => array_sum(array_map(function($item) { return $item['quantity'] * $item['price']; }, $_SESSION['cart'])),
    'sessionId' => session_id(),
    'debugCart' => $_SESSION['cart']
]);
?>

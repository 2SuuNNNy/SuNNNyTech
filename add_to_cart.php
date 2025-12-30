<?php
session_start();
require_once 'db_connect.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please log in to add items to cart']);
    exit;
}

// Check if product_id and quantity are set
if (!isset($_POST['product_id']) || !is_numeric($_POST['product_id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid product ID']);
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = (int)$_POST['product_id'];
$quantity = isset($_POST['quantity']) ? max(1, (int)$_POST['quantity']) : 1;

// Check if product exists
$product_check = mysqli_query($conn, "SELECT id FROM products WHERE id = $product_id");
if (mysqli_num_rows($product_check) == 0) {
    echo json_encode(['success' => false, 'message' => 'Product not found']);
    exit;
}

// Check if product is already in cart
$cart_check = mysqli_query($conn, "SELECT quantity FROM cart WHERE user_id = $user_id AND product_id = $product_id");
if (mysqli_num_rows($cart_check) > 0) {
    // Update quantity
    $row = mysqli_fetch_assoc($cart_check);
    $new_quantity = $row['quantity'] + $quantity;
    mysqli_query($conn, "UPDATE cart SET quantity = $new_quantity WHERE user_id = $user_id AND product_id = $product_id");
} else {
    // Add new item
    mysqli_query($conn, "INSERT INTO cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, $quantity)");
}

// Get updated cart count
$result = mysqli_query($conn, "SELECT SUM(quantity) as total FROM cart WHERE user_id = $user_id");
$row = mysqli_fetch_assoc($result);
$cart_count = $row['total'] ?? 0;

echo json_encode(['success' => true, 'cart_count' => $cart_count]);
?>


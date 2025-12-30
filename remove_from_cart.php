<?php
session_start();
require_once 'db_connect.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please log in to remove items from cart']);
    exit;
}

// Check if product_id is provided
if (!isset($_POST['product_id'])) {
    echo json_encode(['success' => false, 'message' => 'Product ID is required']);
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = intval($_POST['product_id']);

// Remove item from cart
$query = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ii", $user_id, $product_id);
$success = mysqli_stmt_execute($stmt);

if ($success) {
    // Get updated cart count
    $result = mysqli_query($conn, "SELECT SUM(quantity) as total FROM cart WHERE user_id = $user_id");
    $row = mysqli_fetch_assoc($result);
    $cart_count = $row['total'] ?? 0;
    
    echo json_encode(['success' => true, 'cart_count' => $cart_count]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to remove item from cart']);
}
?>
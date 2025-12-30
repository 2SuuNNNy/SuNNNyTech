<?php
session_start();
require_once 'db_connect.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login first']);
    exit();
}

$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents("php://input"), true);
$product_id = isset($data['product_id']) ? (int)$data['product_id'] : 0;

// Validate product_id
if ($product_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid product']);
    exit();
}

// Remove the item from the cart
$delete_query = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
$delete_stmt = mysqli_prepare($conn, $delete_query);
mysqli_stmt_bind_param($delete_stmt, "ii", $user_id, $product_id);
mysqli_stmt_execute($delete_stmt);

echo json_encode(['success' => true, 'message' => 'Item removed from cart']);
?>

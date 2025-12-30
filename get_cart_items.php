<?php
session_start();
require_once 'db_connect.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please log in to view cart', 'items' => [], 'total' => 0]);
    exit;
}

$user_id = $_SESSION['user_id'];
$items = [];
$total = 0;

// Get cart items
$query = "SELECT c.product_id, c.quantity, p.name, p.price, p.image_url 
          FROM cart c 
          JOIN products p ON c.product_id = p.id 
          WHERE c.user_id = $user_id";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $items[] = [
        'product_id' => $row['product_id'],
        'name' => $row['name'],
        'price' => $row['price'],
        'quantity' => $row['quantity'],
        'image_url' => $row['image_url']
    ];
    $total += $row['price'] * $row['quantity'];
}

echo json_encode([
    'success' => true,
    'items' => $items,
    'total' => $total
]);
?>
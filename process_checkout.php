<?php
session_start();

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}

// Example: connect to your database (edit with your own credentials)
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "sunnnytech"; // Assuming you're using this DB

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Save order to the database
$cart = $_SESSION['cart'];
$order_total = 0;
foreach ($cart as $item) {
    $order_total += $item['price'] * $item['quantity'];
}

// Insert into `orders` table (you can customize this table schema)
$conn->query("INSERT INTO orders (total_price, created_at) VALUES ($order_total, NOW())");
$order_id = $conn->insert_id;

// Insert each item into `order_items` (if you have such a table)
foreach ($cart as $item) {
    $name = $conn->real_escape_string($item['name']);
    $price = $item['price'];
    $quantity = $item['quantity'];

    $conn->query("INSERT INTO order_items (order_id, product_name, price, quantity) 
                  VALUES ($order_id, '$name', $price, $quantity)");
}

// Clear cart
unset($_SESSION['cart']);

// Redirect to thank-you page
header("Location: thank_you.php");
exit();
?>

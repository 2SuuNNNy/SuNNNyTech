<?php
session_start();
include 'db_connect.php';

$cart_total = 0;
if (isset($_SESSION['user_id'])) {
    $uid = $_SESSION['user_id'];
    $query = "SELECT c.product_id, c.quantity, p.name, p.price, p.image_url 
              FROM cart c 
              JOIN products p ON c.product_id = p.id 
              WHERE c.user_id = $uid";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $item_total = $row['price'] * $row['quantity'];
        $cart_total += $item_total;
        echo '<div class="cart-item">';
        echo '<img src="' . htmlspecialchars($row['image_url']) . '" alt="' . htmlspecialchars($row['name']) . '">';
        echo '<div class="cart-item-details">';
        echo '<h4>' . htmlspecialchars($row['name']) . '</h4>';
        echo '<p>Qty: ' . $row['quantity'] . ' × $' . number_format($row['price'], 2) . '</p>';
        echo '<p>Total: $' . number_format($item_total, 2) . '</p>';
        echo '</div>';
        echo '<button class="remove-item" data-product-id="' . $row['product_id'] . '">Remove</button>';
        echo '</div>';
    }
    echo '<div class="cart-subtotal"><p>Total: $' . number_format($cart_total, 2) . '</p></div>';
} else {
    echo "<p>Your cart is empty.</p>";
}
?>
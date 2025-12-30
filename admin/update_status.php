<?php
include '../db_connect.php';

if (isset($_GET['id']) && isset($_GET['status'])) {
    $order_id = $_GET['id'];
    $status = $_GET['status'];

    // Update the order status in the orders table
    $sql = "UPDATE orders SET status = '$status' WHERE id = $order_id";

    if (mysqli_query($conn, $sql)) {
        header("Location: view_all_orders.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

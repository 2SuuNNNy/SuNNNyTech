<?php
include '../db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard| SuNNNyTech</title>
    <link rel="stylesheet" href="/SuNNNyTech/admin/css/admin-style.css">
    <link rel="icon" type="image/png" href="/SuNNNyTech/images/header/STicon.png">
</head>
<body>
    <div class="container">
        <div class="account-card">
            <h3>Admin Dashboard</h3>
            <div class="line1"></div>
            <ul>
                <li><a href="/SuNNNyTech/admin/Admin Dashboard.php">Admin Dashboard</a></li>
                <li><a href="/SuNNNyTech/admin/manage_users.php">Manage Users</a></li>
                <li><a href="/SuNNNyTech/admin/Manage Products.php">Manage Products</a></li>
                <li><a href="/SuNNNyTech/admin/view_all_orders.php">View All Orders</a></li>
            </ul>
        </div>

        <div class="account-card">
            <h4>Welcome to the Admin Panel</h4>
            <p style="text-align: center;">Use the navigation above to manage users, products, and orders efficiently.</p>
        </div>
    </div>
</body>
</html>

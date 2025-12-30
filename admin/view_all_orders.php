<?php
include '../db_connect.php';

// Fetch orders with order items
$sql = "SELECT orders.id AS order_id, orders.user_id, orders.total_amount, orders.order_date, 
        orders.shipping_name, orders.shipping_address, orders.shipping_phone, orders.shipping_city, orders.shipping_zip, 
        orders.status,
        order_items.product_id, order_items.quantity, order_items.price
        FROM orders
        LEFT JOIN order_items ON orders.id = order_items.order_id";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
<link rel="icon" type="image/png" href="/SuNNNyTech/images/header/STicon.png">
    <title>View All Orders | SuNNNyTech Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            margin: 20px auto;
            padding: 20px;
            background-color: black;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Header Styling */
        h2 {
            font-size: 28px;
            color: cyan;
            text-align: center;
            margin-bottom: 20px;
            font-family: 'Arial', sans-serif;
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-family: 'Arial', sans-serif;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
        }

        /* Table Header Styling */
        thead {
            background-color: cyan;
            color: #fff;
        }

        thead th {
            padding: 12px;
            text-align: left;
            font-weight: bold;
            font-size: 14px;
        }

        /* Table Body Styling */
        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tbody tr:hover {
            background-color: #ddd;
        }

        tbody td {
            padding: 10px;
            text-align: left;
            font-size: 14px;
            color: #333;
        }

        /* Action Buttons Styling */
        .btn {
            padding: 8px 15px;
            margin: 5px;
            text-decoration: none;
            font-size: 14px;
            color: #fff;
            border-radius: 5px;
            background-color: cyan;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #2196F3;
        }

        .btn:active {
            background-color: cyan;
        }

        /* Table Data (Product Info, Price) Styling */
        td:nth-child(10),
        td:nth-child(11),
        td:nth-child(12) {
            font-weight: bold;
        }

        /* Status Styling */
        td:nth-child(13) {
            font-weight: bold;
            color: #f44336;
        }

        td:nth-child(13):not(.delivered) {
            color: #4CAF50;
        }

        td:nth-child(13).delivered {
            color: #2196F3;
        }

        /* Styling for the actions */
        .actions {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .actions a {
            display: inline-block;
            padding: 6px 12px;
            text-decoration: none;
            font-size: 14px;
            border-radius: 5px;
            background-color: #f44336;
            color: #fff;
            transition: background-color 0.3s ease;
        }

        .actions a:hover {
            background-color: #d32f2f;
        }

        .actions a:active {
            background-color: #b71c1c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>All Orders</h2>

        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User ID</th>
                    <th>Total Amount</th>
                    <th>Order Date</th>
                    <th>Shipping Name</th>
                    <th>Shipping Address</th>
                    <th>Shipping Phone</th>
                    <th>Shipping City</th>
                    <th>Shipping Zip</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['order_id']; ?></td>
                    <td><?php echo $row['user_id']; ?></td>
                    <td>$<?php echo $row['total_amount']; ?></td>
                    <td><?php echo $row['order_date']; ?></td>
                    <td><?php echo $row['shipping_name']; ?></td>
                    <td><?php echo $row['shipping_address']; ?></td>
                    <td><?php echo $row['shipping_phone']; ?></td>
                    <td><?php echo $row['shipping_city']; ?></td>
                    <td><?php echo $row['shipping_zip']; ?></td>
                    <td><?php echo $row['product_id']; ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td>$<?php echo $row['price']; ?></td>
                    <td><?php echo ucfirst($row['status']); ?></td>
                    <td>
                        <?php if ($row['status'] != 'delivered'): ?>
                            <a href="update_status.php?id=<?php echo $row['order_id']; ?>&status=delivered" class="btn">Mark as Delivered</a>
                        <?php endif; ?>
                        <?php if ($row['status'] != 'cancelled'): ?>
                            <a href="update_status.php?id=<?php echo $row['order_id']; ?>&status=cancelled" class="btn">Cancel Order</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

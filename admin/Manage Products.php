<?php
include '../db_connect.php';

// Fetch products
$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Products | SuNNNyTech Admin</title>
    <link rel="stylesheet" href="/SuNNNyTech/admin/css/admin-style.css">
    <link rel="icon" type="image/png" href="/SuNNNyTech/images/header/STicon.png">
</head>
<body>
    <div class="container">
        <h2>Manage Products</h2>

        <a href="/SuNNNyTech/admin/Add Product.php" class="btn">Add Product</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Rating</th>
                    <th>Hot Release</th>
                    <th>Latest Release</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['category']); ?></td>
                    <td>$<?php echo $row['price']; ?></td>
                    <td><?php echo $row['rating']; ?></td>
                    <td><?php echo $row['is_hot_release'] ? 'Yes' : 'No'; ?></td>
                    <td><?php echo $row['is_latest_release'] ? 'Yes' : 'No'; ?></td>
                    <td>
                        <a href="/SuNNNyTech/admin/Edit Product.php?id=<?php echo $row['id']; ?>" class="btn edit">Edit</a>
                        <a href="/SuNNNyTech/admin/delete_product.php?id=<?php echo $row['id']; ?>" class="btn delete" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

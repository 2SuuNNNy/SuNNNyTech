<?php
require_once 'db_connect.php';
echo "Database connection successful!";
$query = "SELECT * FROM products WHERE id = 1";
$result = mysqli_query($conn, $query);
if ($row = mysqli_fetch_assoc($result)) {
    echo "<br>Product found: " . htmlspecialchars($row['name']);
} else {
    echo "<br>No product found with ID 1.";
}
mysqli_close($conn);
?>
<?php
include '../db_connect.php';

// Check if product ID is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch product details to get image URLs before deleting
    $sql = "SELECT * FROM products WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    // Check if the product exists
    if (mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);

        // Delete product images from the server (optional)
        $image_paths = [
            $product['image_url'], 
            $product['image_url1'], 
            $product['image_url2'], 
            $product['image_url3']
        ];

        foreach ($image_paths as $image_path) {
            if (!empty($image_path) && file_exists($_SERVER['DOCUMENT_ROOT'] . $image_path)) {
                unlink($_SERVER['DOCUMENT_ROOT'] . $image_path); // Delete the image file
            }
        }

        // Delete product from the database
        $sql = "DELETE FROM products WHERE id = $id";

        if (mysqli_query($conn, $sql)) {
            // Redirect back to manage products page after successful deletion
            header("Location: manage_products.php");
            exit;
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Product not found.";
    }
} else {
    echo "Product ID not specified.";
}
?>

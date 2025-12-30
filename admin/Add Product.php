<?php
include '../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $rating = $_POST['rating'];
    $description = $_POST['description'];
    $details = $_POST['details'];
    $image_url = $_POST['image_url'];
    $image_url1 = $_POST['image_url1'];
    $image_url2 = $_POST['image_url2'];
    $image_url3 = $_POST['image_url3'];
    $specs_cpu = $_POST['specs_cpu'];
    $specs_gpu = $_POST['specs_gpu'];
    $specs_ram = $_POST['specs_ram'];
    $specs_storage = $_POST['specs_storage'];
    $is_hot_release = isset($_POST['is_hot_release']) ? 1 : 0;
    $is_latest_release = isset($_POST['is_latest_release']) ? 1 : 0;

    // Insert into the database
    $sql = "INSERT INTO products (name, category, price, rating, description, details, image_url, image_url1, image_url2, image_url3, is_hot_release, is_latest_release)
            VALUES ('$name', '$category', '$price', '$rating', '$description', '$details', '$image_url', '$image_url1', '$image_url2', '$image_url3', '$is_hot_release', '$is_latest_release')";

    if (mysqli_query($conn, $sql)) {
        header("Location: manage_products.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="icon" type="image/png" href="/SuNNNyTech/images/header/STicon.png">
    <title>Add Product | SuNNNyTech Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1000px;
            margin: 50px auto;
            background-color: black;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: cyan;
        }

        label {
            font-size: 16px;
            margin-bottom: 8px;
            display: block;
            color: white;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }

        input[type="checkbox"] {
            width: auto;
        }

        button {
            background-color: #0097a7;
            color: white;
            border: none;
            padding: 15px;
            width: 100%;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background-color: #007b8f;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add New Product</h2>
        <form action="" method="POST">
            <label for="name">Product Name:</label>
            <input type="text" name="name" required>

            <label for="category">Category:</label>
            <input type="text" name="category">

            <label for="price">Price:</label>
            <input type="number" step="0.01" name="price" required>

            <label for="rating">Rating:</label>
            <input type="number" step="0.1" name="rating">

            <label for="description">Description:</label>
            <textarea name="description"></textarea>

            <label for="details">Details:</label>
            <textarea name="details"></textarea>

            <label for="specs_cpu">Specs_CPU:</label>
            <input type="text" name="specs_cpu">

            <label for="specs_gpu">Specs_GPU:</label>
            <input type="text" name="specs_gpu">

            <label for="specs_ram">Specs_RAM:</label>
            <input type="text" name="specs_ram">

            <label for="specs_storage">Specs_Storage:</label>
            <input type="text" name="specs_storage">

            <label for="image_url">Image URL 1:</label>
            <input type="text" name="image_url">

            <label for="image_url1">Image URL 2:</label>
            <input type="text" name="image_url1">

            <label for="image_url2">Image URL 3:</label>
            <input type="text" name="image_url2">

            <label for="image_url3">Image URL 4:</label>
            <input type="text" name="image_url3">

            <label for="is_hot_release">Hot Release:</label>
            <input type="checkbox" name="is_hot_release">

            <label for="is_latest_release">Latest Release:</label>
            <input type="checkbox" name="is_latest_release">

            <button type="submit">Add Product</button>
        </form>
    </div>
</body>
</html>


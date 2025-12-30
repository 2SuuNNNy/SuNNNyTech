<?php
session_start();
require_once '../db_connect.php';

$product_id = basename($_SERVER['PHP_SELF'], '.php');
$query = "SELECT name, image_url, price, rating, description FROM products WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $product_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    die("Product not found");
}

$page_title = htmlspecialchars($product['name']) . " | SuNNNyTech";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="../src/css/main.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="image/png" href="../images/header/STicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <?php include '../header.php'; ?>

    <div class="small-container">
        <div class="child">
            <div class="halfchild">
                <img src="<?php echo htmlspecialchars($product['image_url']); ?>" class="offer-img">
            </div>
            <div class="halfchild">
                <h1><?php echo htmlspecialchars($product['name']); ?></h1>
                <div class="rating">
                    <?php
                    $rating = $product['rating'];
                    for ($i = 1; $i <= 5; $i++) {
                        if ($rating >= $i) {
                            echo '<i class="fa fa-star"></i>';
                        } elseif ($rating >= $i - 0.5) {
                            echo '<i class="fa fa-star-half-o"></i>';
                        } else {
                            echo '<i class="fa fa-star-o"></i>';
                        }
                    }
                    ?>
                </div>
                <p>$<?php echo number_format($product['price'], 2); ?></p>
                <p><?php echo htmlspecialchars($product['description']); ?></p>
                <form action="/SuNNNyTech/cart.php" method="POST">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                    <input type="number" name="quantity" value="1" min="1">
                    <button type="submit" class="btn">BUY →</button>
                </form>
                <!--
                <script>
                document.getElementById('add-to-cart-form').addEventListener('submit', function(e) {
                    e.preventDefault();
                    var productId = this.product_id.value;
                    var quantity = this.quantity.value;
                    addToCart(productId, quantity);
                });
                </script>
                -->
            </div>
        </div>
    </div>

    <?php include '../footer.php'; ?>
    <script src="../src/js/script.js"></script>
    <?php mysqli_close($conn); ?>
</body>
</html>
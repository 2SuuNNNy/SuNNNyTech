<?php
session_start();
require_once 'db_connect.php';

$search = isset($_GET['q']) ? mysqli_real_escape_string($conn, $_GET['q']) : '';
$query = "SELECT id, name, image_url, price, rating FROM products WHERE name LIKE ?";
$stmt = mysqli_prepare($conn, $query);
$search_param = "%$search%";
mysqli_stmt_bind_param($stmt, "s", $search_param);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$page_title = "Search Results | SuNNNyTech";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <link rel="stylesheet" href="./src/css/main.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="image/png" href="./images/header/STicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="small-container">
    <div style="height: 200px;"></div> 
    <nav class="breadcrumb" style="margin-left: 500px; margin-top: 20px; margin-bottom: 20px; text-align: left;">
    <a href="/SuNNNyTech/index.php">Home</a> /
    <span style="color: cyan;">
        <?php 
            $page = basename($_SERVER['PHP_SELF'], ".php");
            $page = str_replace('_', ' ', $page);
            echo ucwords($page);
        ?>
    </span>
</nav>  
        <h2>Search Results for "<?php echo htmlspecialchars($search); ?>"</h2>
        <div class="line1"></div>
        <div class="child-pro">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($product = mysqli_fetch_assoc($result)): ?>
                    <div class="childprods">
                        <a href="./src/pages/<?php echo htmlspecialchars($product['id']); ?>.php"><img src="<?php echo htmlspecialchars($product['image_url']); ?>"></a>
                        <h4><?php echo htmlspecialchars($product['name']); ?></h4>
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
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No products found.</p>
            <?php endif; ?>
        </div>
    </div>
    <img src="/SuNNNyTech/images/logos/rbg-line.gif" alt="Description" width="1080" height="5" style="display: block; margin: 0 auto;">
    <div style="height: 20px;"></div>
    <?php include('brand-slider.php'); ?>
    <img src="/SuNNNyTech/images/logos/rbg-line.gif" alt="Divider" width="1920" height="5" style="display: block; margin: 0 auto;">
    <?php include 'footer.php'; ?>
    <script src="./src/js/script.js"></script>
    <?php mysqli_close($conn); ?>
</body>
</html>
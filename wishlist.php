<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: account.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;

    if ($action === 'add') {
        $check_query = "SELECT id FROM wishlist WHERE user_id = ? AND product_id = ?";
        $check_stmt = mysqli_prepare($conn, $check_query);
        mysqli_stmt_bind_param($check_stmt, "ii", $user_id, $product_id);
        mysqli_stmt_execute($check_stmt);
        $result = mysqli_stmt_get_result($check_stmt);

        if (mysqli_num_rows($result) === 0) {
            $insert_query = "INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)";
            $insert_stmt = mysqli_prepare($conn, $insert_query);
            mysqli_stmt_bind_param($insert_stmt, "ii", $user_id, $product_id);
            mysqli_stmt_execute($insert_stmt);
        }
        $response['success'] = true;

    } elseif ($action === 'remove') {
        $delete_query = "DELETE FROM wishlist WHERE user_id = ? AND product_id = ?";
        $delete_stmt = mysqli_prepare($conn, $delete_query);
        mysqli_stmt_bind_param($delete_stmt, "ii", $user_id, $product_id);
        mysqli_stmt_execute($delete_stmt);
        $response['success'] = true;

    } elseif ($action === 'move_to_cart') {
        // Remove from wishlist
        $delete_query = "DELETE FROM wishlist WHERE user_id = ? AND product_id = ?";
        $delete_stmt = mysqli_prepare($conn, $delete_query);
        mysqli_stmt_bind_param($delete_stmt, "ii", $user_id, $product_id);
        mysqli_stmt_execute($delete_stmt);

        // Add to cart or update quantity
        $check_cart_query = "SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?";
        $check_cart_stmt = mysqli_prepare($conn, $check_cart_query);
        mysqli_stmt_bind_param($check_cart_stmt, "ii", $user_id, $product_id);
        mysqli_stmt_execute($check_cart_stmt);
        $cart_result = mysqli_stmt_get_result($check_cart_stmt);

        if ($row = mysqli_fetch_assoc($cart_result)) {
            $new_quantity = $row['quantity'] + 1;
            $update_cart = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
            $update_stmt = mysqli_prepare($conn, $update_cart);
            mysqli_stmt_bind_param($update_stmt, "iii", $new_quantity, $user_id, $product_id);
            mysqli_stmt_execute($update_stmt);
        } else {
            $insert_cart = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)";
            $insert_stmt = mysqli_prepare($conn, $insert_cart);
            mysqli_stmt_bind_param($insert_stmt, "ii", $user_id, $product_id);
            mysqli_stmt_execute($insert_stmt);
        }

        $response['success'] = true;
    }

    if (isset($_POST['ajax'])) {
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    } else {
        header("Location: wishlist.php");
        exit();
    }
}

$wishlist_query = "
    SELECT p.id AS product_id, p.name, p.price, p.image_url 
    FROM wishlist w 
    JOIN products p ON w.product_id = p.id 
    WHERE w.user_id = ?";
$wishlist_stmt = mysqli_prepare($conn, $wishlist_query);
mysqli_stmt_bind_param($wishlist_stmt, "i", $user_id);
mysqli_stmt_execute($wishlist_stmt);
$wishlist_result = mysqli_stmt_get_result($wishlist_stmt);

$page_title = "Wishlist | SuNNNyTech";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./src/css/main.css">
    <link rel="icon" type="image/png" href="./images/header/STicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .wishlist-container {
            max-width: 1000px;
            margin: 150px auto 40px;
            padding: 20px;
        }

        .wishlist-container h2 {
            font-size: 1.8rem;
            color: white;
        }

        .line1 {
            margin: 25px auto;
            border-radius: 15px;
            width: 120px;
            height: 7px;
            background: linear-gradient(90deg, #5ce1e6, #ffffff);
            box-shadow: 0 0 20px rgba(92, 225, 230, 0.9);
        }

        .cart-item {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }

        .cart-item img {
            width: 180px;
            height: 180px;
            object-fit: contain;
            margin-right: 15px;
        }

        .item-details {
            flex-grow: 1;
        }

        .item-details h3 {
            font-size: 1.1rem;
            color: white;
            margin-bottom: 5px;
        }

        .item-price {
            font-size: 1.2rem;
            color: #5ce1e6;
            font-weight: bold;
        }

        .wishlist-buttons {
            margin-top: 10px;
        }

        .wishlist-buttons button {
            padding: 6px 12px;
            margin-right: 10px;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
            border-radius: 4px;
        }

        .remove-from-wishlist {
            background-color: #ff4d4d;
            color: white;
        }

        .move-to-cart {
            background-color: #5ce1e6;
            color: black;
        }

        .empty-cart {
            text-align: center;
            color: #fff;
            font-size: 1.2rem;
            margin: 40px 0;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="wishlist-container">
        <h2>Your Wishlist</h2>
        <div class="line1"></div>
        <div class="cart-items">
            <?php if (mysqli_num_rows($wishlist_result) > 0): ?>
                <?php while ($item = mysqli_fetch_assoc($wishlist_result)): ?>
                    <div class="cart-item" data-id="<?php echo $item['product_id']; ?>">
                        <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                        <div class="item-details">
                            <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                            <div class="item-price">$<?php echo number_format($item['price'], 2); ?></div>
                            <div class="wishlist-buttons">
                                <button class="move-to-cart" data-product-id="<?php echo $item['product_id']; ?>">Move to Cart</button>
                                <button class="remove-from-wishlist" data-product-id="<?php echo $item['product_id']; ?>">Remove</button>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="empty-cart">Your wishlist is empty.</p>
            <?php endif; ?>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <!-- Notification container -->
    <div id="notif" class="notification"></di>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.remove-from-wishlist').forEach(button => {
            button.addEventListener('click', function () {
                const productId = this.dataset.productId;
                const item = this.closest('.cart-item');

                fetch('wishlist.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({
                        ajax: 1,
                        action: 'remove',
                        product_id: productId
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        item.remove();
                        if (!document.querySelector('.cart-item')) {
                            document.querySelector('.cart-items').innerHTML = "<p class='empty-cart'>Your wishlist is empty.</p>";
                        }
                    } else {
                        alert("Failed to remove item.");
                    }
                });
            });
        });

        document.querySelectorAll('.move-to-cart').forEach(button => {
            button.addEventListener('click', function () {
                const productId = this.dataset.productId;
                const item = this.closest('.cart-item');

                fetch('wishlist.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({
                        ajax: 1,
                        action: 'move_to_cart',
                        product_id: productId
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        item.remove();
                        if (!document.querySelector('.cart-item')) {
                            document.querySelector('.cart-items').innerHTML = "<p class='empty-cart'>Your wishlist is empty.</p>";
                        }
                    } else {
                        alert("Failed to move item to cart.");
                    }
                });
            });
        });
    });
    </script>
</body>
</html>

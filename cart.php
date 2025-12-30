<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: account.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Example cart array in session (you would load this from the database or add items dynamically)
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [
        ['id' => 1, 'name' => 'Product 1', 'quantity' => 1, 'price' => 199.99],
        ['id' => 2, 'name' => 'Product 2', 'quantity' => 2, 'price' => 89.99],
    ];
}

// Function to retrieve cart data (for example, in your updateCart function above)
function getCartItems() {
    return isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
}
// Handle cart updates (add/update/remove) via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $response = ['success' => false, 'total' => 0, 'message' => ''];

    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;

        if ($action === 'add' || $action === 'update') {
            $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

            // Check if item exists in cart
            $check_query = "SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?";
            $check_stmt = mysqli_prepare($conn, $check_query);
            mysqli_stmt_bind_param($check_stmt, "ii", $user_id, $product_id);
            mysqli_stmt_execute($check_stmt);
            $check_result = mysqli_stmt_get_result($check_stmt);

            if (mysqli_num_rows($check_result) > 0) {
                // Update quantity
                $row = mysqli_fetch_assoc($check_result);
                $new_quantity = ($action === 'add') ? $row['quantity'] + $quantity : $quantity;

                if ($new_quantity <= 0) {
                    $delete_query = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
                    $delete_stmt = mysqli_prepare($conn, $delete_query);
                    mysqli_stmt_bind_param($delete_stmt, "ii", $user_id, $product_id);
                    mysqli_stmt_execute($delete_stmt);
                    $response['success'] = true;
                } else {
                    $update_query = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
                    $update_stmt = mysqli_prepare($conn, $update_query);
                    mysqli_stmt_bind_param($update_stmt, "iii", $new_quantity, $user_id, $product_id);
                    mysqli_stmt_execute($update_stmt);
                    $response['success'] = true;
                }
            } else {
                // Add new item
                if ($quantity > 0) {
                    $insert_query = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
                    $insert_stmt = mysqli_prepare($conn, $insert_query);
                    mysqli_stmt_bind_param($insert_stmt, "iii", $user_id, $product_id, $quantity);
                    mysqli_stmt_execute($insert_stmt);
                    $response['success'] = true;
                }
            }
        } elseif ($action === 'remove') {
            $delete_query = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
            $delete_stmt = mysqli_prepare($conn, $delete_query);
            mysqli_stmt_bind_param($delete_stmt, "ii", $user_id, $product_id);
            mysqli_stmt_execute($delete_stmt);
            $response['success'] = true;
        }

        // Calculate total
        $total_query = "SELECT SUM(c.quantity * p.price) as total 
                        FROM cart c 
                        JOIN products p ON c.product_id = p.id 
                        WHERE c.user_id = ?";
        $total_stmt = mysqli_prepare($conn, $total_query);
        mysqli_stmt_bind_param($total_stmt, "i", $user_id);
        mysqli_stmt_execute($total_stmt);
        $total_result = mysqli_stmt_get_result($total_stmt);
        $response['total'] = mysqli_fetch_assoc($total_result)['total'] ?? 0;
    }

    if (isset($_POST['ajax'])) {
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    } else {
        header("Location: cart.php");
        exit();
    }
}

// Fetch cart items
$cart_query = "SELECT c.id, c.product_id, c.quantity, p.name, p.price, p.image_url 
               FROM cart c 
               JOIN products p ON c.product_id = p.id 
               WHERE c.user_id = ?";
$cart_stmt = mysqli_prepare($conn, $cart_query);
mysqli_stmt_bind_param($cart_stmt, "i", $user_id);
mysqli_stmt_execute($cart_stmt);
$cart_result = mysqli_stmt_get_result($cart_stmt);

$total_price = 0;

$page_title = "Cart | SuNNNyTech";
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
    <style>
        /* Cart-specific styles inspired by pccomponentes.com */
        .cart-container {
            max-width: 1000px;
            margin: 150px auto 20px;
            padding: 20px;
            background-color: transparent;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .cart-container h2 {
            font-size: 1.8rem;
            color: white;
            margin-bottom: 20px;
        }

        .line1 {
            margin: 25px auto;
            border-radius: 15px;
            width: 120px;
            height: 7px;
            background: linear-gradient(90deg, #5ce1e6, #ffffff);
            box-shadow: 0 0 20px rgba(92, 225, 230, 0.9);;
        }

        .cart-item {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }

        .cart-item img {
            width:180px;
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

        .quantity-control {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 10px 0;
        }

        .quantity-control button {
            background-color: #5ce1e6;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 1rem;
            border-radius: 4px;
        }

        .quantity-control button:hover {
            background-color: #ccc;
        }

        .quantity-control span {
            font-size: 1rem;
            min-width: 30px;
            text-align: center;
        }

        .remove-item {
            background: none;
            border: none;
            color: red;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .remove-item:hover {
            text-decoration: underline;
        }

        .item-subtotal {
            font-size: 1.1rem;
            color: white;
            min-width: 100px;
            text-align: right;
        }

        .cart-summary {
            margin-top: 30px;
            text-align: right;
        }

        .cart-summary h3 {
            font-size: 1.3rem;
            color: #ffffff;
        }

        .checkout-btn {
            background: linear-gradient(90deg, var(--neon-primary, #5ce1e6), var(--neon-secondary, #030000), var(--neon-primary, #5ce1e6));
            background-size: 200% 100%;
            padding: 12px 50px;
            margin: 40px 0;
            border-radius: 60px;
            border: 2px solid rgba(92, 225, 230, 0.8);
            color: #eefdfd;
            text-decoration: none;
            cursor: pointer;
            box-shadow: 0 0 20px var(--neon-primary, #5ce1e6), 0 0 40px var(--neon-secondary, #050000);
            position: relative;
             overflow: hidden;
             animation: shimmer 3.5s linear infinite, buttonGlow 4s infinite alternate;
        }

        .checkout-btn:hover {
            transform: scale(1.15);
            box-shadow: 0 0 40px rgba(92, 225, 230, 1), 0 0 80px rgba(92, 225, 230, 0.7);
            text-shadow: 0 0 15px rgba(92, 225, 230, 0.9);
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
    <div class="cart-container">
        <h2>Your Shopping Cart</h2>
        <div class="line1"></div>
        <?php if (mysqli_num_rows($cart_result) > 0): ?>
            <div class="cart-items">
                <?php while ($item = mysqli_fetch_assoc($cart_result)): ?>
                    <?php 
                        $subtotal = $item['price'] * $item['quantity']; 
                        $total_price += $subtotal; 
                    ?>
                    <div class="cart-item" data-id="<?php echo $item['product_id']; ?>">
                        <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                        <div class="item-details">
                            <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                            <div class="item-price">$<?php echo number_format($item['price'], 2); ?></div>
                            <div class="quantity-control">
                                <button onclick="updateQuantity(<?php echo $item['product_id']; ?>, <?php echo $item['quantity'] - 1; ?>)">-</button>
                                <span><?php echo $item['quantity']; ?></span>
                                <button onclick="updateQuantity(<?php echo $item['product_id']; ?>, <?php echo $item['quantity'] + 1; ?>)">+</button>
                            </div>
                            <button class="remove-item" onclick="removeItem(<?php echo $item['product_id']; ?>)">Remove</button>
                        </div>
                        <div class="item-subtotal">$<?php echo number_format($subtotal, 2); ?></div>
                    </div>
                <?php endwhile; ?>
            </div>
            <div class="cart-summary">
                <h3>Total: $<span id="cart-total"><?php echo number_format($total_price, 2); ?></span></h3>
                <button class="checkout-btn" onclick="window.location.href='checkout.php'">Proceed to Checkout</button>
            </div>
        <?php else: ?>
            <p class="empty-cart">Your cart is empty.</p>
        <?php endif; ?>
    </div>
    <div style="height: 150px;"></div>
    <?php include 'footer.php'; ?>
    <script src="./src/js/script.js"></script>
    <script>
        function updateQuantity(productId, quantity) {
            if (quantity < 0) return; // Prevent negative quantities
            fetch('cart.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `ajax=true&action=update&product_id=${productId}&quantity=${quantity}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update total
                    document.getElementById('cart-total').textContent = parseFloat(data.total).toFixed(2);

                    // Update or remove item
                    const item = document.querySelector(`.cart-item[data-id="${productId}"]`);
                    if (item) {
                        if (quantity === 0) {
                            item.remove();
                        } else {
                            item.querySelector('.quantity-control span').textContent = quantity;
                            const price = parseFloat(item.querySelector('.item-price').textContent.replace('$', ''));
                            item.querySelector('.item-subtotal').textContent = `$${ (price * quantity).toFixed(2) }`;
                        }
                    }

                    // Show empty cart message if needed
                    if (!document.querySelector('.cart-item')) {
                        document.querySelector('.cart-items').outerHTML = '<p class="empty-cart">Your cart is empty.</p>';
                    }
                } else {
                    alert('Error updating cart.');
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function removeItem(productId) {
            fetch('cart.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `ajax=true&action=remove&product_id=${productId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update total
                    document.getElementById('cart-total').textContent = parseFloat(data.total).toFixed(2);

                    // Remove item
                    const item = document.querySelector(`.cart-item[data-id="${productId}"]`);
                    if (item) item.remove();

                    // Show empty cart message if needed
                    if (!document.querySelector('.cart-item')) {
                        document.querySelector('.cart-items').outerHTML = '<p class="empty-cart">Your cart is empty.</p>';
                    }
                } else {
                    alert('Error removing item.');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
</body>
</html>
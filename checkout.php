<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: account.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$cart_query = "SELECT c.product_id, c.quantity, p.name, p.price, p.image_url  
               FROM cart c 
               JOIN products p ON c.product_id = p.id 
               WHERE c.user_id = ?";
$stmt = $conn->prepare($cart_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$total = 0;
$items = [];
while ($row = $result->fetch_assoc()) {
    $row['subtotal'] = $row['quantity'] * $row['price'];
    $total += $row['subtotal'];
    $items[] = $row;
}

$page_title = "Checkout | SuNNNyTech";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./src/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="icon" type="image/png" href="./images/header/STicon.png">
    <style>
        body {
            background-color: #000;
        }

        .checkout-container {
            max-width: 1200px;
            margin: 150px auto 40px;
            display: flex;
            gap: 30px;
            padding: 30px;
            background-color: transparent;
            border-radius: 8px;
        }

        .checkout-left {
            flex: 2;
        }

        .checkout-right {
            flex: 1;
            background: rgba(255, 255, 255, 0.05);
            padding: 20px;
            border-radius: 15px;
            color: #fff;
            box-shadow: 0 0 20px rgba(92, 225, 230, 0.4);
        }

        .checkout-right h3 {
            color: #5ce1e6;
            margin-bottom: 15px;
            font-size: 1.3rem;
        }

        .info-line {
            margin: 12px 0;
            border-bottom: 1px solid rgba(255,255,255,0.2);
            padding-bottom: 8px;
        }

        .line1 {
            margin: 25px auto;
            border-radius: 15px;
            width: 120px;
            height: 7px;
            background: linear-gradient(90deg, #5ce1e6, #ffffff);
            box-shadow: 0 0 20px rgba(92, 225, 230, 0.9);
        }

        .checkout-list {
            list-style: none;
            padding: 0;
            margin: 20px 0;
            color: white;
        }

        .checkout-item {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 15px;
            background: rgba(255, 255, 255, 0.05);
            padding: 15px;
            border-radius: 10px;
        }

        .checkout-item img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            border-radius: 10px;
            background: #fff;
        }

        .item-info {
            flex-grow: 1;
        }

        .item-info span {
            display: block;
            font-size: 1rem;
        }

        .item-subtotal {
            color: #5ce1e6;
            font-weight: bold;
            font-size: 1.1rem;
        }

        .total-price {
            font-size: 1.3rem;
            color: #5ce1e6;
            margin-top: 20px;
        }

        .form-group {
            margin-top: 20px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
        }

        .form-label {
            color: white;
            font-size: 1rem;
        }

        .confirm-btn {
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
            font-size: 1rem;
        }

        .confirm-btn:hover {
            transform: scale(1.15);
            box-shadow: 0 0 40px rgba(92, 225, 230, 1), 0 0 80px rgba(92, 225, 230, 0.7);
            text-shadow: 0 0 15px rgba(92, 225, 230, 0.9);
        }

        .empty-message {
            color: #fff;
            font-size: 1.2rem;
            text-align: center;
            margin: 40px 0;
        }

        #credit-card-fields {
            display: none;
        }

        @media (max-width: 768px) {
            .checkout-container {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>
<div class="checkout-container">
    <div class="checkout-left">
        <h2 style="color:white;">Checkout</h2>
        <div class="line1"></div>
        <?php if (count($items) > 0): ?>
            <ul class="checkout-list">
                <?php foreach ($items as $item): ?>
                    <li class="checkout-item">
                        <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                        <div class="item-info">
                            <span><strong><?php echo htmlspecialchars($item['name']); ?></strong></span>
                            <span>Quantity: <?php echo $item['quantity']; ?></span>
                            <span class="item-subtotal">$<?php echo number_format($item['subtotal'], 2); ?></span>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="total-price">
                <strong>Total: $<?php echo number_format($total, 2); ?></strong>
            </div>
            <form method="POST" action="place_order.php">
                <div class="form-group">
                    <label class="form-label" for="shipping_name">Full Name</label>
                    <input type="text" name="shipping_name" id="shipping_name" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="shipping_address">Shipping Address</label>
                    <input type="text" name="shipping_address" id="shipping_address" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="shipping_city">City</label>
                    <input type="text" name="shipping_city" id="shipping_city" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="shipping_zip">Zip Code</label>
                    <input type="text" name="shipping_zip" id="shipping_zip" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="shipping_phone">Phone Number</label>
                    <input type="text" name="shipping_phone" id="shipping_phone" required>
                </div>

                <!-- Payment Method -->
                <div class="form-group">
                    <label class="form-label" for="payment_method">Payment Method</label>
                    <select name="payment_method" id="payment_method" required onchange="toggleCardFields()">
                        <option value="">-- Select Payment Method --</option>
                        <option value="credit_card">Pay with Credit Card</option>
                        <option value="cod">Pay on Delivery</option>
                    </select>
                </div>

                <!-- Credit Card Fields -->
                <div id="credit-card-fields">
                    <div class="form-group">
                        <label class="form-label" for="card_number">Card Number</label>
                        <input type="text" name="card_number" id="card_number" placeholder="1234 5678 9012 3456">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="card_name">Cardholder Name</label>
                        <input type="text" name="card_name" id="card_name" placeholder="John Doe">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="expiry">Expiry Date</label>
                        <input type="text" name="expiry" id="expiry" placeholder="MM/YY">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="cvv">CVV</label>
                        <input type="text" name="cvv" id="cvv" placeholder="123">
                    </div>
                </div>

                <button type="submit" class="confirm-btn">Confirm Order</button>
            </form>
        <?php else: ?>
            <p class="empty-message">Your cart is empty.</p>
        <?php endif; ?>
    </div>
    <div class="checkout-right">
        <h3>Need to Know</h3>
        <div class="info-line"><strong>Delivery:</strong> Estimated 3–5 business days</div>
        <div class="info-line"><strong>Support:</strong> 24/7 Live Chat</div>
        <div class="info-line"><strong>Secure Checkout:</strong> SSL & encrypted payment</div>
        <div class="info-line"><strong>Returns:</strong> 7-day return policy</div>
    </div>
</div>
<div style="height: 150px;"></div>
<?php include 'footer.php'; ?>

<!-- JavaScript to toggle card fields -->
<script>
    function toggleCardFields() {
        const paymentMethod = document.getElementById('payment_method').value;
        const cardFields = document.getElementById('credit-card-fields');
        cardFields.style.display = paymentMethod === 'credit_card' ? 'block' : 'none';
    }
</script>
</body>
</html>

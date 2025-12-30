<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: account.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get user details (e.g., email)
$user_query = "SELECT email FROM users WHERE id = ?";
$user_stmt = $conn->prepare($user_query);
if ($user_stmt === false) {
    // Handle error
    echo "Error preparing statement: " . $conn->error;
    exit;
}
$user_stmt->bind_param("i", $user_id);
$user_stmt->execute();
$user_result = $user_stmt->get_result();
$user = $user_result->fetch_assoc();
$user_email = $user['email'];

// Check if shipping info is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $shipping_name = $_POST['shipping_name'];
    $shipping_address = $_POST['shipping_address'];
    $shipping_city = $_POST['shipping_city'];
    $shipping_zip = $_POST['shipping_zip'];
    $shipping_phone = $_POST['shipping_phone'];

    // Get cart items
    $cart_query = "SELECT c.product_id, c.quantity, p.name, p.price, p.image_url
                   FROM cart c 
                   JOIN products p ON c.product_id = p.id 
                   WHERE c.user_id = ?";
    $stmt = $conn->prepare($cart_query);
    if ($stmt === false) {
        echo "Error preparing statement: " . $conn->error;
        exit;
    }
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

    // Insert shipping info into the orders table
    $order_stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, shipping_name, shipping_address, shipping_phone, shipping_city, shipping_zip) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if ($order_stmt === false) {
        // Handle error
        echo "Error preparing order statement: " . $conn->error;
        exit;
    }
    $order_stmt->bind_param("idsssss", $user_id, $total, $shipping_name, $shipping_address, $shipping_phone, $shipping_city, $shipping_zip);
    if (!$order_stmt->execute()) {
        // Handle error executing order query
        echo "Error executing order statement: " . $order_stmt->error;
        exit;
    }
    $order_id = $conn->insert_id;
    $_SESSION['last_order_id'] = $order_id;

    // Insert each item into order_items
    $item_stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    if ($item_stmt === false) {
        echo "Error preparing item statement: " . $conn->error;
        exit;
    }
    foreach ($items as $item) {
        $item_stmt->bind_param("iiid", $order_id, $item['product_id'], $item['quantity'], $item['price']);
        if (!$item_stmt->execute()) {
            echo "Error executing item statement: " . $item_stmt->error;
            exit;
        }
    }

    // Clear user's cart
    $clear_stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
    if ($clear_stmt === false) {
        echo "Error preparing clear cart statement: " . $conn->error;
        exit;
    }
    $clear_stmt->bind_param("i", $user_id);
    if (!$clear_stmt->execute()) {
        echo "Error executing clear cart statement: " . $clear_stmt->error;
        exit;
    }

    // Send email receipt to user
    $subject = "Your Order Confirmation - SuNNNyTech";
    $message = "<html><body>";
    $message .= "<h2>Thank you for your order!</h2>";
    $message .= "<p>Your order has been successfully placed. Below are the details:</p>";
    $message .= "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
    $message .= "<tr><th>Product</th><th>Quantity</th><th>Price</th><th>Subtotal</th></tr>";
    
    foreach ($items as $item) {
        $message .= "<tr>";
        $message .= "<td>" . htmlspecialchars($item['name']) . "</td>";
        $message .= "<td>" . $item['quantity'] . "</td>";
        $message .= "<td>$" . number_format($item['price'], 2) . "</td>";
        $message .= "<td>$" . number_format($item['subtotal'], 2) . "</td>";
        $message .= "</tr>";
    }

    $message .= "</table>";
    $message .= "<p><strong>Total Paid: $" . number_format($total, 2) . "</strong></p>";
    $message .= "<p><strong>Shipping Information:</strong><br>";
    $message .= "Name: " . htmlspecialchars($shipping_name) . "<br>";
    $message .= "Address: " . htmlspecialchars($shipping_address) . "<br>";
    $message .= "City: " . htmlspecialchars($shipping_city) . "<br>";
    $message .= "Zip: " . htmlspecialchars($shipping_zip) . "<br>";
    $message .= "Phone: " . htmlspecialchars($shipping_phone) . "</p>";
    $message .= "<p>Thank you for shopping with us! You will receive a shipping confirmation email soon.</p>";
    $message .= "<p>Best Regards,<br>SuNNNyTech</p>";
    $message .= "</body></html>";

    // Set headers for the email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
    $headers .= "From: SuNNNyTech <no-reply@sunnnytech.com>" . "\r\n";

    // Send email
    if (mail($user_email, $subject, $message, $headers)) {
        echo "Order confirmation email sent successfully.";
    } else {
        echo "Failed to send order confirmation email.";
    }
}

$page_title = "Order Placed | SuNNNyTech";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($page_title); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/SuNNNyTech/images/header/STicon.png">
    <link rel="stylesheet" href="./src/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        body { background-color: #0a0a0a; color: #fff; }
        .order-container {
            max-width: 1000px;
            margin: 150px auto 40px;
            padding: 30px;
            background-color: #111;
            border-radius: 12px;
        }
        h2 {
            text-align: center;
            color: #5ce1e6;
            margin-bottom: 20px;
        }
        .line1 {
            width: 100px;
            height: 6px;
            background: linear-gradient(90deg, #5ce1e6, #ffffff);
            border-radius: 6px;
            margin: 0 auto 30px;
            box-shadow: 0 0 20px #5ce1e6;
        }
        .order-list {
            list-style: none;
            padding: 0;
        }
        .order-item {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
            background: #222;
            border-radius: 10px;
            padding: 15px;
        }
        .order-item img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            border-radius: 10px;
            background: #fff;
        }
        .item-info span {
            display: block;
            margin: 3px 0;
        }
        .item-subtotal {
            color: #5ce1e6;
            font-weight: bold;
        }
        .total-price {
            text-align: right;
            font-size: 1.3rem;
            color: #5ce1e6;
            margin-top: 30px;
        }
        .success-message {
            text-align: center;
            font-size: 1.2rem;
            margin-top: 25px;
        }
        .btn-group {
            text-align: center;
            margin-top: 30px;
        }
        .btn-group a {
            display: inline-block;
            margin: 10px;
            padding: 12px 30px;
            background: linear-gradient(90deg, #5ce1e6, #030000, #5ce1e6);
            border: 2px solid #5ce1e6;
            border-radius: 50px;
            color: white;
            text-decoration: none;
            font-weight: bold;
            transition: transform 0.2s ease;
            box-shadow: 0 0 15px #5ce1e6;
        }
        .btn-group a:hover {
            transform: scale(1.08);
        }
        .delivery-tracker {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }
        .tracker-item {
            text-align: center;
            position: relative;
        }
        .tracker-item::before {
            content: '';
            position: absolute;
            top: 50%;
            left: -10px;
            height: 10px;
            width: 10px;
            border-radius: 50%;
            background-color: #5ce1e6;
            transform: translateY(-50%);
        }
        .tracker-item.complete::before {
            background-color: green;
        }
        .tracker-item span {
            display: block;
            color: #fff;
            font-size: 1rem;
            margin-top: 10px;
        }
    </style>
</head>
<body data-aos="fade-up">
    <?php include 'header.php'; ?>
    <div class="order-container" data-aos="fade-up">
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
        <h2>Your Order is Confirmed!</h2>
        <div class="line1"></div>

        <?php if (!empty($items)): ?>
            <ul class="order-list">
                <?php foreach ($items as $item): ?>
                    <li class="order-item">
                        <img src="<?= htmlspecialchars($item['image_url']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                        <div class="item-info">
                            <span><strong><?= htmlspecialchars($item['name']) ?></strong></span>
                            <span>Qty: <?= $item['quantity'] ?></span>
                            <span class="item-subtotal">$<?= number_format($item['subtotal'], 2) ?></span>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="total-price"><strong>Total Paid: $<?= number_format($total, 2) ?></strong></div>
            <p class="success-message">Thank you for your purchase! Check your email for the confirmation.</p>
            <div class="btn-group">
                <a href="index.php">Continue Shopping</a>
                <a href="generate_receipt.php?order_id=<?= $_SESSION['last_order_id'] ?>" target="_blank">Download Receipt (PDF)</a>
            </div>
        <?php else: ?>
            <p class="success-message">Your cart seems empty or was already checked out.</p>
            <div class="btn-group">
                <a href="index.php">Shop Now</a>
            </div>
        <?php endif; ?>

        <div class="delivery-tracker">
            <div class="tracker-item complete" data-aos="fade-right">
                <span>Order Confirmed</span>
            </div>
            <div class="tracker-item" data-aos="fade-right" data-aos-delay="200">
                <span>Shipped</span>
            </div>
            <div class="tracker-item" data-aos="fade-left" data-aos-delay="400">
                <span>Delivered</span>
            </div>
        </div>
    </div>
    <div style="height: 150px;"></div>
              <!-- Loading Screen -->
  <div id="loading-screen">
    <div class="loader">
      <svg viewBox="0 0 80 80">
        <circle cx="40" cy="40" r="32"></circle>
      </svg>
    </div>

    <div class="loader triangle">
      <svg viewBox="0 0 86 80">
        <polygon points="43 8 79 72 7 72"></polygon>
      </svg>
    </div>

    <div class="loader">
      <svg viewBox="0 0 80 80">
        <rect x="8" y="8" width="64" height="64"></rect>
      </svg>
    </div>
  </div>

  <!-- Your main page content -->
  <div id="page-content">
  </div>

  <script>
    const minLoadingTime = 2000; // 2 seconds minimum
    const startTime = performance.now();

    window.addEventListener('load', () => {
      const loader = document.getElementById('loading-screen');
      const content = document.getElementById('page-content');

      function hideLoader() {
        loader.classList.add('hide');
        setTimeout(() => {
          loader.style.display = 'none';
          content.style.display = 'block';
        }, 500); // match fade out duration
      }

      const elapsedTime = performance.now() - startTime;
      const timeLeft = minLoadingTime - elapsedTime;

      if (timeLeft > 0) {
        setTimeout(hideLoader, timeLeft);
      } else {
        hideLoader();
      }
    });
  </script>
    <img src="./images/logos/rbg-line.gif" alt="Line" width="1920" height="5">
    <?php include 'footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>

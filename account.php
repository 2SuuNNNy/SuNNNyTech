<?php
session_start();
require_once('db_connect.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$query = "SELECT id, name, email, role, address, phone FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);  // Use the user_id parameter to prevent SQL injection
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Check if 'role' is set in the user array
if (isset($user['role'])) {
    // Store the role in a variable
    $role = $user['role'];
} else {
    // Handle case where role is missing
    $role = 'user';  // Default to 'user' if no role is found
}

// Fetch order history with product images
$order_query = "SELECT 
                    o.id AS order_id, 
                    o.order_date, 
                    o.total_amount, 
                    o.status,                    -- ✅ Add status
                    oi.product_id, 
                    p.name, 
                    p.image_url
                FROM orders o 
                JOIN order_items oi ON o.id = oi.order_id 
                JOIN products p ON oi.product_id = p.id 
                WHERE o.user_id = ?";

$order_stmt = $conn->prepare($order_query);
$order_stmt->bind_param("i", $user_id);
$order_stmt->execute();
$order_result = $order_stmt->get_result();

$orders = [];
while ($row = $order_result->fetch_assoc()) {
    $order_id = $row['order_id'];
    
    // Assign order-level data once
    if (!isset($orders[$order_id])) {
        $orders[$order_id] = [
            'order_date' => $row['order_date'],
            'total_amount' => $row['total_amount'],
            'status' => $row['status'],       // ✅ Store the status per order
            'products' => []
        ];
    }

    // Add product to order
    $orders[$order_id]['products'][] = [
        'name' => $row['name'],
        'image_url' => $row['image_url']
    ];
}

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    $update_query = "UPDATE users SET name = ?, email = ?, address = ?, phone = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("ssssi", $name, $email, $address, $phone, $user_id);
    
    if ($update_stmt->execute()) {
        $user['name'] = $name;
        $user['email'] = $email;
        $user['address'] = $address;
        $user['phone'] = $phone;
        $success = "Profile updated successfully!";
    } else {
        $error = "Error updating profile.";
    }
}

// Fetch recommended products
$recommended_products = [];
$query_recommended = "SELECT id, name, image_url, price, rating FROM products ORDER BY RAND() LIMIT 4";
$result_recommended = $conn->query($query_recommended);
if ($result_recommended) {
    while ($row = $result_recommended->fetch_assoc()) {
        $recommended_products[] = $row;
    }
} else {
    error_log("Failed to fetch recommended products: " . $conn->error);
}

$page_title = "My Account | SuNNNyTech";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="src/css/main.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="image/png" href="/SuNNNyTech/images/header/STicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .account-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 30px 15px;
        }
        .account-header {
            text-align: center;
            margin-bottom: 30px;
            animation: fadeIn 0.5s ease-in;
        }
        .account-header h1 {
            font-size: 2.5rem;
            color: #5ce1e6;
            margin-bottom: 10px;
        }
        .account-header p {
            font-size: 1.2rem;
            color: white;
        }
        .account-card {
            background: black;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            padding: 25px;
            margin-bottom: 30px;
            transition: transform 0.3s ease;
            border: 3px solid cyan;
            box-shadow: 0px 0px 15px cyan,
                0px 0px 15px cyan inset;
        }
        .account-card:hover {
            transform: translateY(-5px);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-weight: 600;
            color: white;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            font-size: 1rem;
            color: black;
            transition: border-color 0.3s ease;
        }
        .form-group input:focus {
            outline: none;
            border-color: #ff523b;
        }
        .button-group {
            display: flex;
            gap: 10px;
            justify-content: flex-start;
        }
        .btn:hover {
            background: #e63e2a;
        }
        .logout-btn {
            background: #5ce1e6;
            text-decoration: none;
        }
        .logout-btn:hover {
            background: #5ce1e6;
            text-decoration: none;
        }
        .message {
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 0.9rem;
        }
        .message.success {
            background: #e6f4ea;
            color: #2e7d32;
        }
        .message.error {
            background: #fce4e4;
            color: #c62828;
        }
        .recommended-products-horizontal {
            display: flex;
            overflow-x: auto;
            gap: 20px;
            padding: 15px 0;
            scrollbar-width: thin;
        }
        .recommended-product-item {
            flex: 0 0 160px;
            text-align: center;
            background: transparent;
            border-radius: 8px;
            padding: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }
        .recommended-product-item:hover {
            transform: scale(1.05);
        }
        .recommended-product-item a {
            text-decoration: none;
            color: white;
        }
        .recommended-product-item img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 6px;
            margin-bottom: 8px;
        }
        .recommended-product-item h5 {
            font-size: 0.85rem;
            margin: 0;
            line-height: 1.3;
        }
        .recommended-product-item .rating {
            font-size: 0.75rem;
            margin: 5px 0;
        }
        .recommended-product-item p {
            font-size: 0.9rem;
            margin: 0;
            color: #ff523b;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @media (max-width: 600px) {
            .account-card {
                padding: 15px;
            }
            .account-header h1 {
                font-size: 1.8rem;
            }
            .recommended-product-item {
                flex: 0 0 140px;
            }
        }
        .address {
                color: #333;
                font-size: 16px;
                font-family: Arial, sans-serif;
                font-weight: normal;
                    }
                    /* Styling for Order History Card */
                /* Order history table styling */
                .order-history-card {
            background-color: black;
            padding: 25px;
            margin-bottom: 30px;
            border-radius: 12px;
            border: 3px solid cyan;
            box-shadow: 0px 0px 15px cyan, 0px 0px 15px cyan inset;
        }
        .order-history-card h3 {
            color: #5ce1e6;
            margin-bottom: 15px;
        }
        .order-history-card .divider-line {
            width: 100%;
            height: 2px;
            background-color: #5ce1e6;
            margin-bottom: 20px;
        }
        .order-table {
            width: 100%;
            border-collapse: collapse;
        }
        .order-table th, .order-table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        .order-table th {
            background-color: #5ce1e6;
            color: white;
        }
        .order-table td {
            background-color: #222;
            color: white;
        }
        .order-table img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
            margin-right: 8px;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>
<img src="/SuNNNyTech/images/logos/rbg-line.gif" width="1920" height="5" style="display: block; margin: 0 auto;">
<div style="height: 150px;"></div>
    <!-- Breadcrumb section -->
    <nav class="breadcrumb" style="margin-left: 350px; margin-top: 20px; margin-bottom: 20px; text-align: left;">
    <a href="/SuNNNyTech/index.php">Home</a> /
    <span style="color: cyan;">
        <?php 
            $page = basename($_SERVER['PHP_SELF'], ".php");
            $page = str_replace('_', ' ', $page);
            echo ucwords($page);
        ?>
    </span>
</nav>
<div class="small-container account-container">
    <div class="account-header">
        <h1>My Account</h1>
        <p>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</p>
    </div>

    <?php if (isset($success)): ?>
        <div class="message success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <div class="message error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

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

    <!-- Profile Update Form -->
    <div class="account-card">
        <form action="account.php" method="POST">
            <div class="form-group"><label for="name">Full Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required></div>
            <div class="form-group"><label for="email">Email Address</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required></div>
            <div class="form-group"><label for="address">Address</label>
                <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" required></div>
            <div class="form-group"><label for="phone">Phone</label>
                <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required></div>
            <div class="button-group">
                <button type="submit" name="update_profile" class="btn">Update Profile</button>
                <a href="logout.php" class="btn logout-btn">Log Out</a>
            </div>
        </form>
    </div>

    <!-- Admin or Support Panel -->
    <?php if ($role === 'admin'): ?>
        <div class="account-card">
    <h3>Admin Panel</h3>
    <div class="line1"></div> <!-- Optional line below the title -->
    <ul style="list-style: disc; padding-left: 20px; color: white;">
        <li><a href="/SuNNNyTech/admin/Admin Dashboard.php" style="color: cyan;">Admin Dashboard</a></li>
        <li><a href="/SuNNNyTech/admin/manage_users.php" style="color: cyan;">Manage Users</a></li>
        <li><a href="/SuNNNyTech/admin/Manage Products.php" style="color: cyan;">Manage Products</a></li>
        <li><a href="/SuNNNyTech/admin/view_all_orders.php" style="color: cyan;">View All Orders</a></li>
    </ul>
</div>
    <?php elseif ($role === 'support'): ?>
    <div class="account-card">
        <h3>Support Panel</h3>
        <div class="line1"></div>
        <ul style="list-style: disc; padding-left: 20px; color: white;">
            <li><a href="support/tickets.php" style="color: cyan;">View Support Tickets</a></li>
        </ul>
    </div>
    <?php endif; ?>


    <img src="/SuNNNyTech/images/logos/rbg-line.gif" alt="Description" width="1080" height="5" style="display: block; margin: 0 auto; margin-bottom: 40px;">
        
    <!-- Order History Section -->
    <div class="order-history-card" style="margin-top: 40px;">
    <h3 style="font-size: 24px; margin-bottom: 10px; color: cyan;">Order History</h3>
    <div class="divider-line" style="height: 3px; background-color: cyan; margin-bottom: 20px;"></div>

    <?php if (!empty($orders)) { ?>
        <style>
            .order-table {
                border-collapse: collapse;
                width: 100%;
                border-radius: 20px;
                overflow: hidden;
                border: 3px solid cyan;
                font-family: Arial, sans-serif;
            }

            .order-table th,
            .order-table td {
                padding: 12px;
                text-align: left;
                background-color: transparent;
                color: white;
                vertical-align: top;
            }

            .order-table th {
                font-weight: bold;
                border-bottom: 2px solid cyan;
            }

            .order-table tr {
                border-bottom: 1px solid #444;
            }

            .order-table tr:last-child {
                border-bottom: none;
            }

            .product-item {
                display: flex;
                align-items: center;
                gap: 10px;
                margin-bottom: 8px;
            }

            .product-item img {
                width: 60px;
                height: 60px;
                object-fit: cover;
                border-radius: 8px;
                border: 2px solid #ccc;
            }

            .order-status {
                font-weight: bold;
                padding: 4px 8px;
                border-radius: 6px;
                display: inline-block;
            }

            .status-delivered {
                color: #4caf50;
            }

            .status-pending {
                color: #ffc107;
            }

            .status-cancelled {
                color: #dc3545;
            }
        </style>

        <table class="order-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Products</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                 <?php foreach ($orders as $order_id => $order) { 
                        $status = strtolower($order['status'] ?? 'pending'); // fallback to 'pending' if not set

                        $status_class = match ($status) {
                            'delivered' => 'status-delivered',
                            'cancelled' => 'status-cancelled',
                            default     => 'status-pending'
                        };
                 ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order_id); ?></td>
                        <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                        <td>
                            <?php foreach ($order['products'] as $product) { ?>
                                <div class="product-item">
                                    <img src="<?php echo $product['image_url']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                    <span><?php echo htmlspecialchars($product['name']); ?></span>
                                </div>
                            <?php } ?>
                        </td>
                        <td><?php echo htmlspecialchars($order['total_amount']); ?> $</td>
                        <td><span class="order-status <?php echo $status_class; ?>"><?php echo ucfirst($status); ?></span></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p style="color: gray;">You have no orders yet.</p>
    <?php } ?>
</div>


    <div style="height: 50px;"></div>

    <!-- Recommended Products Section -->
    <h3>Recommended for You</h3>
<div class="recommended-products-horizontal">
        <?php foreach ($recommended_products as $product) { ?>
            <div class="recommended-product-item">
                <a href="product_details.php?id=<?php echo $product['id']; ?>">
                    <img src="<?php echo $product['image_url']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <h5><?php echo htmlspecialchars($product['name']); ?></h5>
                    <div class="rating">
                        <span class="fa fa-star"></span> 
                        <span class="fa fa-star"></span> 
                        <span class="fa fa-star"></span> 
                        <span class="fa fa-star"></span> 
                        <span class="fa fa-star"></span>
                    </div>
                    <p>$<?php echo number_format($product['price'], 2); ?></p>
                </a>
            </div>
        <?php } ?>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>

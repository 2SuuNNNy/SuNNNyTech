<?php
// Sample shipping policy content (customize as per your actual shipping policy)
$shipping_policy = "
    <h2>SuNNNyTech Shipping Policy</h2>
    <p>At SuNNNyTech, we want your order to reach you quickly and safely. Below is our shipping policy to help you understand how we process your orders.</p>
    
    <h3>1. Shipping Methods</h3>
    <p>We offer the following shipping methods:</p>
    <ul>
        <li><strong>Standard Shipping:</strong> 5-7 business days. Available for most locations.</li>
        <li><strong>Expedited Shipping:</strong> 2-3 business days. Faster delivery for urgent orders.</li>
        <li><strong>Same-Day Shipping:</strong> Orders placed before 2:00 PM will be shipped out the same day. Available for local orders only.</li>
    </ul>

    <h3>2. Shipping Fees</h3>
    <p>Shipping fees are calculated at checkout based on the shipping method and destination. We offer free standard shipping on orders over $100.</p>

    <h3>3. Order Processing Time</h3>
    <p>Orders are typically processed within 1-2 business days. Please note that orders placed on weekends or holidays will be processed the following business day.</p>

    <h3>4. International Shipping</h3>
    <p>We currently offer international shipping to select countries. Shipping times and fees may vary depending on your location. Please review the available options at checkout.</p>

    <h3>5. Tracking Your Order</h3>
    <p>Once your order has shipped, you will receive an email with tracking information. You can use this to track your order's progress. If you have any questions regarding your shipment, feel free to contact us.</p>

    <h3>6. Delivery Issues</h3>
    <p>If your package is lost or damaged during transit, please contact us as soon as possible. We will work with the carrier to resolve the issue and ensure your order is delivered safely.</p>

    <h3>7. PO Boxes and APO/FPO Addresses</h3>
    <p>We do ship to PO Boxes and APO/FPO addresses, but please note that some shipping methods may not be available for these addresses. You will be notified of any restrictions during checkout.</p>

    <h3>8. Customer Responsibility</h3>
    <p>It is the customer's responsibility to provide a correct and complete shipping address. If an order is returned due to an incorrect address, additional shipping fees may apply to reship the package.</p>

    <p>If you have any questions or concerns about shipping, please contact us via <a href='mailto:support@sunnnytech.com'>support@sunnnytech.com</a>.</p>
";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping Policy | SuNNNyTech</title>
    <link rel="stylesheet" href="./src/css/main.css"> <!-- Link to your SuNNNyTech theme CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="image/png" href="./images/header/STicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <!-- Include your SuNNNyTech header -->
    <?php include('header.php'); ?>

    <div class="shipping-container">
    <div style="height: 100px;"></div>
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
    <img src="/SuNNNyTech/images/logos/rbg-line.gif" alt="Description" width="1080" height="5" style="display: block; margin: 0 auto;">
        <div class="shipping-policy-section">
            <h1 class="page-title">Shipping Policy</h1>
            <div class="line1"></div>
            
            <!-- Displaying the shipping policy content -->
            <div class="shipping-content">
                <?php echo $shipping_policy; ?>
            </div>
        </div>
    </div>
    <div style="height: 100px;"></div>
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
    <img src="./images/logos/rbg-line.gif" alt="Description" width="1920" height="5">
    <!-- Include your SuNNNyTech footer -->
    <?php include('footer.php'); ?>

</body>
</html>

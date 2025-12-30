<?php
// Sample return policy content (you can customize this further as per your actual return policy)
$return_policy = "
    <h2>SuNNNyTech Return Policy</h2>
    <p>At SuNNNyTech, we want you to be completely satisfied with your purchase. If for any reason you are not satisfied, we are happy to offer returns and exchanges under the following conditions:</p>
    
    <h3>1. Return Period</h3>
    <p>You may return items within 30 days of the delivery date for a full refund or exchange. After 30 days, we will no longer be able to accept returns.</p>

    <h3>2. Eligibility for Returns</h3>
    <p>To be eligible for a return, your item must be unused and in the same condition that you received it. It must also be in the original packaging.</p>

    <h3>3. Non-returnable Items</h3>
    <p>Some items are non-returnable, including:</p>
    <ul>
        <li>Gift cards</li>
        <li>Downloadable software products</li>
        <li>Personalized or custom-built products</li>
    </ul>

    <h3>4. How to Initiate a Return</h3>
    <p>To initiate a return, please log in to your account, go to your order history, and select the Return option next to the product you wish to return. If you do not have an account, please contact our customer service team via <a href='mailto:support@sunnytech.com'>support@sunnnytech.com</a>.</p>

    <h3>5. Refund Process</h3>
    <p>Once we receive and inspect your returned item, we will send you an email to notify you of the approval or rejection of your refund. If approved, your refund will be processed to your original payment method within 5-7 business days.</p>

    <h3>6. Shipping Costs</h3>
    <p>Shipping costs are non-refundable. If you receive a refund, the cost of return shipping will be deducted from your refund, unless the return is due to an error on our part.</p>

    <h3>7. Damaged or Defective Items</h3>
    <p>If your product arrives damaged or defective, please contact us immediately. We will provide a prepaid shipping label for returns and send a replacement product at no extra cost.</p>

    <h3>8. Exchanges</h3>
    <p>If you would like to exchange an item, please return the original product and place a new order for the item you'd like instead. Exchanges are subject to availability.</p>

    <p>If you have any questions regarding our return policy, feel free to reach out to us via <a href='mailto:support@sunnnytech.com'>support@sunnnytech.com</a>.</p>
";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Policy | SuNNNyTech</title>
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

    <div class="policy-container">
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
    <img src="/SuNNNyTech/images/logos/rbg-line.gif" alt="Description" width="1080" height="5" style="display: block; margin: 0 auto;">
        <div class="return-policy-section">
            <h1 class="page-title">Return Policy</h1>
            <div class="line1"></div>
            
            <!-- Displaying the return policy content -->
            <div class="policy-content">
                <?php echo $return_policy; ?>
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

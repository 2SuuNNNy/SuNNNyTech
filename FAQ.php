<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: account.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Sample array of FAQ categories and questions
$faq_data = [
    'Product Information' => [
        ['question' => 'What are the specs of the latest gaming PC?', 'answer' => 'Our latest gaming PC comes with a high-performance Intel i9 CPU, NVIDIA RTX 3080 GPU, 32GB RAM, and 1TB SSD.'],
        ['question' => 'How do I find the right components for my build?', 'answer' => 'Visit our product section where we offer various guides for selecting compatible components.'],
    ],
    'Orders & Shipping' => [
        ['question' => 'How do I place an order?', 'answer' => 'Simply browse our products, add items to your cart, and proceed to checkout.'],
        ['question' => 'What are the available shipping methods?', 'answer' => 'We offer standard, expedited, and same-day delivery. You can select the shipping method during checkout.'],
    ],
    'Returns & Exchanges' => [
        ['question' => 'Can I return or exchange an item?', 'answer' => 'Yes, items can be returned within 30 days of purchase, provided they are unused and in original packaging.'],
        ['question' => 'How do I initiate a return?', 'answer' => 'Log in to your account, go to your order history, and click the "Return" button next to the item you wish to return.'],
    ],
    'Account Support' => [
        ['question' => 'How do I create an account?', 'answer' => 'Click on the "Sign Up" button on the top right of the page and fill out your details.'],
        ['question' => 'I forgot my password, what do I do?', 'answer' => 'Click on "Forgot Password" on the login page and follow the instructions to reset it.'],
    ],
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ | SuNNNyTech</title>
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
    <div class="faq-container">
    <div style="height: 200px;"></div>
    <img src="/SuNNNyTech/images/logos/rbg-line.gif" alt="Description" width="1080" height="5" style="display: block; margin: 0 auto;">
        <div class="faq-section">
            <h1 class="page-title">Frequently Asked Questions</h1>
            <div class="line1"></div>
            <div style="height: 50px;"></div>
            <!-- Search Bar -->
            <div class="search-bar">
                <input type="text" id="faqSearch" placeholder="Search for a question..." onkeyup="searchFAQ()">
            </div>

            <!-- FAQ Content -->
            <?php foreach ($faq_data as $category => $faqs): ?>
                <div class="faq-category">
                    <h2 class="category-title"><?php echo htmlspecialchars($category); ?></h2>

                    <?php foreach ($faqs as $faq): ?>
                        <div class="faq-item">
                            <h4 class="question"><?php echo htmlspecialchars($faq['question']); ?></h4>
                            <div class="answer">
                                <p><?php echo htmlspecialchars($faq['answer']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div style="height: 200px;"></div>
    <img src="./images/logos/rbg-line.gif" alt="Description" width="1920" height="5">
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
    <!-- Include your SuNNNyTech footer -->
    <?php include('footer.php'); ?>

    <script>
        // Toggle FAQ answers
        $(document).ready(function() {
            $(".faq-item .question").click(function() {
                $(this).next(".answer").slideToggle();
            });
        });

        // Search FAQ
        function searchFAQ() {
            var input, filter, categories, faqItems, question, answer, i, txtValue;
            input = document.getElementById('faqSearch');
            filter = input.value.toUpperCase();
            categories = document.querySelectorAll('.faq-category');
            
            categories.forEach(function(category) {
                faqItems = category.getElementsByClassName('faq-item');
                Array.from(faqItems).forEach(function(item) {
                    question = item.querySelector('.question');
                    answer = item.querySelector('.answer');
                    txtValue = question.textContent || question.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        item.style.display = "";
                    } else {
                        item.style.display = "none";
                    }
                });
            });
        }
    </script>

</body>
</html>
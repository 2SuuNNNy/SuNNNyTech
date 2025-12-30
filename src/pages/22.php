<?php
session_start();
require_once('../../db_connect.php');

$product_id = basename($_SERVER['PHP_SELF'], '.php');
$query = "SELECT name, image_url, image_url1, image_url2, image_url3, price, rating, description, details FROM products WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $product_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    die("Product not found");
}

$page_title = htmlspecialchars($product['name']) . " | SuNNNyTech";

// Fetch related products
$related_products = []; // Initialize as empty array
$query_related = "SELECT id, name, image_url, price, rating FROM products WHERE id != ? ORDER BY RAND() LIMIT 4";
$stmt_related = mysqli_prepare($conn, $query_related);
if ($stmt_related) {
    mysqli_stmt_bind_param($stmt_related, "i", $product_id);
    mysqli_stmt_execute($stmt_related);
    $result_related = mysqli_stmt_get_result($stmt_related);
    while ($row = mysqli_fetch_assoc($result_related)) {
        $related_products[] = $row;
    }
    mysqli_stmt_close($stmt_related);
} else {
    error_log("Failed to prepare related products query: " . mysqli_error($conn));
}

// Fetch customer reviews for this product
$reviews = [];
$query_reviews = "SELECT r.id, r.customer_name, r.rating, r.review_text, r.review_date 
                 FROM reviews r 
                 WHERE r.product_id = ? 
                 ORDER BY r.review_date DESC 
                 LIMIT 5";
$stmt_reviews = mysqli_prepare($conn, $query_reviews);
if ($stmt_reviews) {
    mysqli_stmt_bind_param($stmt_reviews, "i", $product_id);
    mysqli_stmt_execute($stmt_reviews);
    $result_reviews = mysqli_stmt_get_result($stmt_reviews);
    while ($row = mysqli_fetch_assoc($result_reviews)) {
        $reviews[] = $row;
    }
    mysqli_stmt_close($stmt_reviews);
} else {
    error_log("Failed to prepare reviews query: " . mysqli_error($conn));
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="image/png" href="/SuNNNyTech/images/header/STicon.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <?php include '../../header.php'; ?>
    <img src="/SuNNNyTech/images/logos/rbg-line.gif" alt="Description" width="1920" height="5" style="display: block; margin: 0 auto;">
    <div style="height: 250px;"></div>
<nav class="breadcrumb" style="margin-left: 300px; margin-top: 20px; margin-bottom: 20px; text-align: left;">
    <a href="/SuNNNyTech/index.php">Home</a> /
    <a href="/SuNNNyTech/Desktops.php">Desktops</a> /
    <span style="color: cyan;">
        <?php echo isset($product['name']) ? htmlspecialchars($product['name']) : 'Product'; ?>
    </span>
</nav>
    <div class="small-container">
    <div class="child">
        <div class="halfchild">
            <!-- Name Above the Product Image -->
            <div class="product-info" style="text-align: center; margin-bottom: 0px;">
                <!-- Smaller Product Name -->
                <h1 style="font-size: 1.5rem; margin-bottom: -50px;"><?php echo htmlspecialchars($product['name']); ?></h1>
                <!-- Main Product Image -->
                <img src="<?php echo htmlspecialchars($product['image_url']); ?>" class="offer-img" alt="<?php echo htmlspecialchars($product['name']); ?>">

                <!-- Display Additional Images Below the Main Image -->
                <div class="product-images" style="margin-top: -80px; display: flex; gap: 20px;">
                    <div class="product-image" style="flex: 1;">
                        <img src="<?php echo htmlspecialchars($product['image_url1']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?> Image 1" style="width: 100%; border-radius: 10px;">
                    </div>
                    <div class="product-image" style="flex: 1;">
                        <img src="<?php echo htmlspecialchars($product['image_url2']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?> Image 2" style="width: 100%; border-radius: 10px;">
                    </div>
                    <div class="product-image" style="flex: 1;">
                        <img src="<?php echo htmlspecialchars($product['image_url3']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?> Image 3" style="width: 100%; border-radius: 10px;">
                    </div>
                </div>
            </div>
        </div>

        <div class="halfchild">
            <!-- Price in Larger Font -->
            <div style="text-align: right; margin-bottom: 10px;text-shadow: 0 0 12px rgba(92, 225, 230, 0.9); font-family: 'Impact', serif;">
    <!-- Price in Larger Font with smaller superscript decimals -->
    <p style="font-size: 4rem; color: #5ce1e6; font-weight: bold; margin-top: -60px;text-shadow: 0 0 12px rgba(92, 225, 230, 0.9);">
        $<?php 
            $price = number_format($product['price'], 2, ',', ''); // Format price as 511,50
            $price_parts = explode(',', $price); // Split at the comma
            echo $price_parts[0]; // Whole number part (511)
        ?><span style="font-size: 2rem; color: white; vertical-align: super;"><?php echo ',' . $price_parts[1]; ?></span>
    </p>
</div>
            <!-- Rating Label Above the Rating -->
            <p style="font-size: 0.9rem; margin: 10px 0;">Rating:</p>
            
            <!-- Rating Stars -->
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
            <div style="height: 20px;"></div>
            <!-- Description -->
            <p><?php echo htmlspecialchars($product['description']); ?></p>

            <!-- Add to Cart Form -->
            <div style="display: flex; align-items: center; gap: 20px;">

                <!-- Add to Cart Form -->
                <form action="/SuNNNyTech/cart.php" method="POST" style="display: flex; flex-direction: column; align-items: flex-start; gap: 5px;">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                    <div style="display: flex; align-items: center; gap: 5px;">
                        <input type="number" name="quantity" value="1" min="1" style="width: 60px;">
                        <button type="submit" class="btn-buy">BUY →</button>
                    </div>
                    <button type="button" class="add-to-cart-btn" onclick="addToCart(<?php echo $product_id; ?>)" style="width: 280px; margin-top: 0px;">Add to Cart</button>
                    <div class="shipping-info">
                    <i class="fa fa-truck"></i> Free shipping on orders over $150
                </div>
                </form>


                <!-- Wishlist Button Form -->
                <form action="/SuNNNyTech/wishlist.php" method="POST">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                    <button type="submit" class="wishlist-btn" title="Add to Wishlist">
                        <i class="fa-regular fa-heart"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

    <!-- Details OUTSIDE the child div -->
    <?php if (!empty($product['details'])): ?>
    <div class="product-details" style="margin-top: 50px; background: transparent; padding: 25px; border-radius: 10px; margin-bottom: 30px;">
            <h3>Product Details:</h3>
            <p><?php echo nl2br(htmlspecialchars($product['details'])); ?></p>
    </div>
    <?php endif; ?>
    
    <!-- Customer Reviews Section - Moved here -->
    <div class="customer-reviews-section" style="margin-top: 30px; margin-bottom: 50px;">
        <h2 class="title">Customer Reviews</h2>
        <div class="reviews-container" style="display: flex; flex-direction: column; gap: 20px; max-width: 800px; margin: 0 auto;">
            <div class="overall-rating" style="display: flex; align-items: center; gap: 15px; background: rgba(10, 42, 51, 0.3); padding: 15px; border-radius: 10px; border: 1px solid rgba(92, 225, 230, 0.3); box-shadow: 0 0 10px rgba(92, 225, 230, 0.2);">
                <div style="font-size: 48px; font-weight: bold; color: #5ce1e6; text-shadow: 0 0 10px rgba(92, 225, 230, 0.8);">
                    <?php echo number_format($product['rating'], 1); ?>
                </div>
                <div style="display: flex; flex-direction: column; gap: 5px;">
                    <div class="rating" style="font-size: 24px; color: #5ce1e6;">
                        <?php
                        $rating = $product['rating'];
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= $rating) {
                                echo '<i class="fa fa-star"></i>';
                            } elseif ($i - 0.5 <= $rating) {
                                echo '<i class="fa fa-star-half-o"></i>';
                            } else {
                                echo '<i class="fa fa-star-o"></i>';
                            }
                        }
                        ?>
                    </div>
                    <div style="color: #fff; font-size: 14px;">Based on <?php echo count($reviews); ?> reviews</div>
                </div>
                <div style="margin-left: auto;">
                    <button onclick="showReviewForm()" class="write-review-btn" style="background: linear-gradient(90deg, #5ce1e6, #030000, #5ce1e6); background-size: 200% 100%; color: white; border: none; padding: 10px 20px; border-radius: 30px; cursor: pointer; font-weight: bold; animation: shimmer 2.5s linear infinite; box-shadow: 0 0 15px rgba(92, 225, 230, 0.5);">
                        <?php echo isset($_SESSION['user_id']) ? 'Write a Review' : 'Login to Review'; ?>
                    </button>
                </div>
            </div>
            
            <?php if (count($reviews) > 0): ?>
                <div class="review-list" style="display: flex; flex-direction: column; gap: 15px;">
                    <?php foreach ($reviews as $review): ?>
                        <div class="review-item" style="background: rgba(10, 42, 51, 0.2); padding: 20px; border-radius: 10px; border: 1px solid rgba(92, 225, 230, 0.2);">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                <div style="font-weight: bold; color: #5ce1e6; font-size: 18px;"><?php echo htmlspecialchars($review['customer_name']); ?></div>
                                <div style="color: #aaa; font-size: 14px;"><?php echo date('M d, Y', strtotime($review['review_date'])); ?></div>
                            </div>
                            <div style="display: flex; margin-bottom: 15px;">
                                <?php
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $review['rating']) {
                                        echo '<i class="fa fa-star" style="color: #5ce1e6; margin-right: 3px;"></i>';
                                    } else {
                                        echo '<i class="fa fa-star-o" style="color: #5ce1e6; margin-right: 3px;"></i>';
                                    }
                                }
                                ?>
                            </div>
                            <div style="color: #fff; line-height: 1.6;"><?php echo htmlspecialchars($review['review_text']); ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div style="text-align: center; padding: 30px; color: #aaa; background: rgba(10, 42, 51, 0.2); border-radius: 10px;">
                    <i class="fa fa-comment-o" style="font-size: 48px; margin-bottom: 15px; color: #5ce1e6;"></i>
                    <p>No reviews yet. Be the first to review this product!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
 
   <div style="height: 20px;"></div>
   <img src="/SuNNNyTech/images/banner/Windows11_banner.webp" alt="Description" width="1200" height="319"style="display: block; margin: 0 auto;">
   <div style="height: 20px;"></div>
    <img src="/SuNNNyTech/images/logos/rbg-line.gif" alt="Description" width="1080" height="5" style="display: block; margin: 0 auto;">

    <!-- Related Products Section -->
    <div class="small-container">
        <h2 class="title">Related Products</h2> 
        <div class="related-products-horizontal" style="display: flex; overflow-x: auto; gap: 30px; padding: 40px 0;">
            <?php if (!empty($related_products)): ?>
                <?php foreach ($related_products as $related): ?>
                    <div class="related-product-item" style="flex: 0 0 150px; text-align: center;">
                        <a href="<?php echo htmlspecialchars($related['id']); ?>.php" style="text-decoration: none; color: inherit;">
                            <img src="<?php echo htmlspecialchars($related['image_url']); ?>" alt="<?php echo htmlspecialchars($related['name']); ?>" style="width: 250px; height: 250px; object-fit: cover; margin-bottom: 15px;">
                            <h5 style="margin: 0; font-size: 16px;"><?php echo htmlspecialchars($related['name']); ?></h5>
                            <div class="rating" style="font-size: 10px; margin: 3px 0;">
                                <?php
                                $related_rating = $related['rating'];
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($related_rating >= $i) {
                                        echo '<i class="fa fa-star"></i>';
                                    } elseif ($related_rating >= $i - 0.5) {
                                        echo '<i class="fa fa-star-half-o"></i>';
                                    } else {
                                        echo '<i class="fa fa-star-o"></i>';
                                    }
                                }
                                ?>
                            </div>
                            <p style="margin: 0; font-size: 12px;">$<?php echo number_format($related['price'], 2); ?></p>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No related products found.</p>
            <?php endif; ?>
        </div>
    </div>

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
    const minLoadingTime = 500; // 2 seconds minimum
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

    <img src="/SuNNNyTech/images/logos/rbg-line.gif" alt="Description" width="1920" height="5" style="display: block; margin: 0 auto;">
    <?php include '../../footer.php'; ?>
    <script src="../src/js/script.js"></script>
    <?php mysqli_close($conn); ?>
</body>
</html>

    <script>
        function showReviewForm() {
            <?php if (isset($_SESSION['user_id'])): ?>
            // User is logged in, show the review form
            // Create modal overlay
            const overlay = document.createElement('div');
            overlay.className = 'review-modal-overlay';
            overlay.style.position = 'fixed';
            overlay.style.top = '0';
            overlay.style.left = '0';
            overlay.style.width = '100%';
            overlay.style.height = '100%';
            overlay.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
            overlay.style.zIndex = '9999';
            overlay.style.display = 'flex';
            overlay.style.justifyContent = 'center';
            overlay.style.alignItems = 'center';
            
            // Create modal content
            const modal = document.createElement('div');
            modal.className = 'review-modal';
            modal.style.width = '500px';
            modal.style.backgroundColor = '#0a2a33';
            modal.style.borderRadius = '10px';
            modal.style.padding = '30px';
            modal.style.boxShadow = '0 0 20px rgba(92, 225, 230, 0.5)';
            modal.style.border = '1px solid rgba(92, 225, 230, 0.3)';
            
            // Create modal header
            const header = document.createElement('div');
            header.style.display = 'flex';
            header.style.justifyContent = 'space-between';
            header.style.alignItems = 'center';
            header.style.marginBottom = '20px';
            
            const title = document.createElement('h3');
            title.textContent = 'Write a Review';
            title.style.color = '#5ce1e6';
            title.style.margin = '0';
            
            const closeBtn = document.createElement('button');
            closeBtn.innerHTML = '&times;';
            closeBtn.style.background = 'none';
            closeBtn.style.border = 'none';
            closeBtn.style.color = '#5ce1e6';
            closeBtn.style.fontSize = '24px';
            closeBtn.style.cursor = 'pointer';
            closeBtn.style.position = 'absolute';
            closeBtn.style.right = '20px';
            closeBtn.style.top = '15px';
            closeBtn.onclick = function() {
                document.body.removeChild(overlay);
            };
            
            header.appendChild(title);
            header.appendChild(closeBtn);
            
            // Create form
            const form = document.createElement('form');
            form.action = '/SuNNNyTech/submit_review.php';
            form.method = 'POST';
            
            // Name input
            const nameLabel = document.createElement('label');
            nameLabel.textContent = 'Your Name:';
            nameLabel.style.display = 'block';
            nameLabel.style.color = '#fff';
            nameLabel.style.marginBottom = '5px';
            
            const nameInput = document.createElement('input');
            nameInput.type = 'text';
            nameInput.name = 'customer_name';
            nameInput.required = true;
            nameInput.style.width = '100%';
            nameInput.style.padding = '10px';
            nameInput.style.marginBottom = '15px';
            nameInput.style.backgroundColor = 'rgba(255, 255, 255, 0.1)';
            nameInput.style.border = '1px solid rgba(92, 225, 230, 0.3)';
            nameInput.style.borderRadius = '5px';
            nameInput.style.color = '#fff';
            
            // Rating input
            const ratingLabel = document.createElement('label');
            ratingLabel.textContent = 'Rating:';
            ratingLabel.style.display = 'block';
            ratingLabel.style.color = '#fff';
            ratingLabel.style.marginBottom = '5px';
            
            const ratingContainer = document.createElement('div');
            ratingContainer.style.display = 'flex';
            ratingContainer.style.marginBottom = '15px';
            
            for (let i = 1; i <= 5; i++) {
                const star = document.createElement('span');
                star.innerHTML = '&#9734;'; // Empty star
                star.style.fontSize = '30px';
                star.style.color = '#5ce1e6';
                star.style.cursor = 'pointer';
                star.style.marginRight = '5px';
                star.dataset.value = i;
                
                star.onmouseover = function() {
                    // Fill stars up to this one
                    const stars = ratingContainer.children;
                    const value = this.dataset.value;
                    
                    for (let j = 0; j < stars.length; j++) {
                        if (j < value) {
                            stars[j].innerHTML = '&#9733;'; // Filled star
                        } else {
                            stars[j].innerHTML = '&#9734;'; // Empty star
                        }
                    }
                };
                
                star.onclick = function() {
                    ratingInput.value = this.dataset.value;
                    // Keep stars filled after click
                    const stars = ratingContainer.children;
                    const value = this.dataset.value;
                    
                    for (let j = 0; j < stars.length; j++) {
                        if (j < value) {
                            stars[j].innerHTML = '&#9733;'; // Filled star
                        } else {
                            stars[j].innerHTML = '&#9734;'; // Empty star
                        }
                    }
                };
                
                ratingContainer.appendChild(star);
            }
            
            const ratingInput = document.createElement('input');
            ratingInput.type = 'hidden';
            ratingInput.name = 'rating';
            ratingInput.value = '5'; // Default value
            
            // Review text input
            const reviewLabel = document.createElement('label');
            reviewLabel.textContent = 'Your Review:';
            reviewLabel.style.display = 'block';
            reviewLabel.style.color = '#fff';
            reviewLabel.style.marginBottom = '5px';
            
            const reviewInput = document.createElement('textarea');
            reviewInput.name = 'review_text';
            reviewInput.required = true;
            reviewInput.rows = '5';
            reviewInput.style.width = '100%';
            reviewInput.style.padding = '10px';
            reviewInput.style.marginBottom = '20px';
            reviewInput.style.backgroundColor = 'rgba(255, 255, 255, 0.1)';
            reviewInput.style.border = '1px solid rgba(92, 225, 230, 0.3)';
            reviewInput.style.borderRadius = '5px';
            reviewInput.style.color = '#fff';
            reviewInput.style.resize = 'vertical';
            
            // Hidden product ID input
            const productIdInput = document.createElement('input');
            productIdInput.type = 'hidden';
            productIdInput.name = 'product_id';
            productIdInput.value = '<?php echo $product_id; ?>';
            
            // Submit button
            const submitBtn = document.createElement('button');
            submitBtn.type = 'submit';
            submitBtn.textContent = 'Submit Review';
            submitBtn.style.background = 'linear-gradient(90deg, #5ce1e6, #030000, #5ce1e6)';
            submitBtn.style.backgroundSize = '200% 100%';
            submitBtn.style.width = '100%';
            submitBtn.style.padding = '12px';
            submitBtn.style.border = 'none';
            submitBtn.style.borderRadius = '30px';
            submitBtn.style.color = '#fff';
            submitBtn.style.fontWeight = 'bold';
            submitBtn.style.cursor = 'pointer';
            submitBtn.style.animation = 'shimmer 2.5s linear infinite';
            submitBtn.style.boxShadow = '0 0 15px rgba(92, 225, 230, 0.5)';
            
            // Append all elements to form
            form.appendChild(nameLabel);
            form.appendChild(nameInput);
            form.appendChild(ratingLabel);
            form.appendChild(ratingContainer);
            form.appendChild(ratingInput);
            form.appendChild(reviewLabel);
            form.appendChild(reviewInput);
            form.appendChild(productIdInput);
            form.appendChild(submitBtn);
            
            // Append header and form to modal
            modal.appendChild(header);
            modal.appendChild(form);
            
            // Append modal to overlay
            overlay.appendChild(modal);
            
            // Append overlay to body
            document.body.appendChild(overlay);
            <?php endif; ?>
        }
    </script>
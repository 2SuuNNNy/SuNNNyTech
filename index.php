<?php
session_start();
require_once 'db_connect.php';

$hot_releases_query = "SELECT id, name, image_url, price, rating FROM products WHERE is_hot_release = 1 LIMIT 4";
$hot_releases_result = mysqli_query($conn, $hot_releases_query);

$latest_releases_query = "SELECT id, name, image_url, price, rating FROM products WHERE is_latest_release = 1 LIMIT 12";
$latest_releases_result = mysqli_query($conn, $latest_releases_query);

$testimonials_query = "SELECT name, comment, rating, image_url FROM testimonials LIMIT 3";
$testimonials_result = mysqli_query($conn, $testimonials_query);

$page_title = "Home | SuNNNyTech | Premium Gaming PC Gamer, Laptops & Accessories at Best Prices";
$current_year = date("Y");
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">

    <!-- AOS CSS for scroll-triggered animations -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.css" />
    
    <style>
        .swiper {
            width: 100%;
            max-width: 1200px;
            height: 100px;
            margin: 20px auto;
            margin-bottom: 100px;
        }
        .swiper-slide {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .swiper-slide img {
            max-width: 120px;
            max-height: 60px;
            object-fit: contain;
        }
    </style>
</head>
<body>
    <div id="particles-js"></div>
    <?php include 'header.php'; ?>
    <div class="headerimg">
      <video autoplay loop muted>
        <source src="./images/header/headervid.mp4" type="video/mp4">
        Your browser does not support the video tag.
      </video>
    </div> 
    <div class="header-content">
       <h1>If you have everything under control, you're not computing fast enough!</h1>
       <h3>Experience performance like never before. Try our cutting-edge computers starting at just $599*</h3>
        <a href="./Desktops.php" button class="btn" data-aos="fade-up" data-aos-delay="200">Explore Now →</a>
    </div>
     <div class="center-container">
    </div> 

    <div class="banner-container">
    <div class="banner top-banner">
  <div class="swiper top-banner-swiper">
    <div class="swiper-wrapper">
        <!-- Slide 1 -->
      <div class="banner-slide">
        <img src="\SuNNNyTech\images\header\laptop.webp" alt="Slide 1">
        <div class="banner-text">
          <h2>Gaming Laptop Deals</h2>
          <p>Get the best prices on high-performance laptops</p>
          <a href="./laptops.php" class="cta-button">Shop Now</a>
        </div>
      </div>
      <!-- Slide 2 -->
      <div class="banner-slide">
        <img src="\SuNNNyTech\images\header\RTX-5070.webp" alt="Slide 2">
        <div class="banner-text">
          <h2>Next-Gen RTX 5070</h2>
          <p>RTX 50 Series Inside</p>
          <a href="/GPU.php" class="cta-button">Shop Now</a>
        </div>
      </div>
      <!-- Slide 3 -->
      <div class="banner-slide">
        <img src="\SuNNNyTech\images\header\PC.webp" alt="Slide 3">
        <div class="banner-text">
          <h2>Thin & Powerful</h2>
          <p>For Gamers</p>
          <a href="./Desktops.php" class="cta-button">Shop Now</a>
        </div>
      </div>
    </div>
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
    const minLoadingTime = 4500; // 4 seconds minimum
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

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
  new Swiper('.top-banner-swiper', {
    loop: true,
    autoplay: {
      delay: 3000,
      disableOnInteraction: false
    },
    effect: 'coverflow',
    coverflowEffect: {
    rotate: 50,
    stretch: 0,
    depth: 100,
    modifier: 1,
    slideShadows: true,
},
    slideClass: 'banner-slide' // Tells Swiper to use your custom slide class
  });
</script>
        <div class="right-column">
            <div class="banner top-banner-1">
            <img src="\SuNNNyTech\images\header\pcs.webp" alt="Top Banner 1">
            <div class="banner-text">
            <h2>Power Your Play with Aurora</h2>
                <p>Backed by ASUS</p>
                <a href="./Desktops.php" button class="cta-button">Buy Now</a>
            </div>
        </div>
    <div class="bottom-banners">
      <div class="banner bottom-banner">
        <img src="\SuNNNyTech\images\header\PC.webp" alt="Bottom Banner">
        <div class="banner-text">
            <h2>HIGH HZ MONITOR</h2>
            <a href="./Accessoires.php" button class="cta-button secondary">View Details</a>
        </div>
    </div>
    <div class="banner bottom-banner-1">
                <img src="\SuNNNyTech\images\header\gpu.jpg" alt="Bottom Banner 1">
            <div class="banner-text">
                <h2>BEST GPU BEST PERFORMANCE</h2>
                <a href="./Accessoires.php" button class="cta-button secondary">View Details</a>
            </div>
            </div>
            </div>
        </div>
    </div>

    <img src="/SuNNNyTech/images/logos/rbg-line.gif" alt="Description" width="1080" height="5" style="display: block; margin: 0 auto;">

    <div class="swiper brand-swiper" data-aos="fade-up">
        <div class="swiper-wrapper">
            <div class="swiper-slide"><img src="/SuNNNyTech/images/logos/logo-razer.png" alt="Brand 1"></div>
            <div class="swiper-slide"><img src="/SuNNNyTech/images/logos/logo-msi.png" alt="Brand 2"></div>
            <div class="swiper-slide"><img src="/SuNNNyTech/images/logos/logo-rfg.png" alt="Brand 3"></div>
            <div class="swiper-slide"><img src="/SuNNNyTech/images/logos/logo-logi.png" alt="Brand 4"></div>
            <div class="swiper-slide"><img src="/SuNNNyTech/images/logos/logo-assus.png" alt="Brand 5"></div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper('.brand-swiper', {
            slidesPerView: 2,
            spaceBetween: 10,
            breakpoints: {
                640: { slidesPerView: 3, spaceBetween: 20 },
                1024: { slidesPerView: 4, spaceBetween: 30 }
            },
            loop: true,
            autoplay: { delay: 2000, disableOnInteraction: false }
        });
    </script>
    <div class="offer" data-aos="fade-up">
        <div class="small-container">
            <div class="child">
                <div class="halfchild">
                    <img src="./images/promos/exclusive.png" class="offer-img" data-aos="fade-right">
                </div>
                <div class="halfchild" data-aos="fade-left">
                    <p>Exclusively available here</p>
                    <h1>ForgeFlex Pro Desktop</h1>
                    <small>
                    Step into a new era of computing with the ForgeFlex Pro Desktop (Ryzen 9 9950X3D). Powered by the latest AMD Ryzen 9 9950X3D processor, this powerhouse delivers unparalleled performance, speed, and efficiency, making it perfect for professionals, content creators, and gamers alike.<br>
                    </small>
                    <a href="/SuNNNyTech/src/pages/14.php" class="btn">Buy Now →</a>
                </div>
            </div>
        </div>
    </div>

    <img src="/SuNNNyTech/images/logos/rbg-line.gif" alt="Description" width="1080" height="5" style="display: block; margin: 0 auto;">
    <div class="small-container">
        <h2 data-aos="fade-up">Hot Releases</h2>
        <div class="line1"></div>
        <div class="child" data-aos="fade-up">
            <?php while ($product = mysqli_fetch_assoc($hot_releases_result)): ?>
                <div class="childprods">
                    <a href="./src/pages/<?php echo htmlspecialchars($product['id']); ?>.php"><img src="<?php echo htmlspecialchars($product['image_url']); ?>" data-aos="zoom-in"></a>
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
        </div>

        <img src="/SuNNNyTech/images/logos/rbg-line.gif" alt="Description" width="1080" height="5" style="display: block; margin: 0 auto;">
        <h2 data-aos="fade-up">Latest Releases</h2>
        <div class="line1"></div>
        <div class="child" data-aos="fade-up">
            <?php while ($product = mysqli_fetch_assoc($latest_releases_result)): ?>
                <div class="childprods">
                    <a href="./src/pages/<?php echo htmlspecialchars($product['id']); ?>.php"><img src="<?php echo htmlspecialchars($product['image_url']); ?>" data-aos="zoom-in"></a>
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
        </div>
    </div>
    <img src="/SuNNNyTech/images/logos/rbg-line.gif" alt="Description" width="1080" height="5" style="display: block; margin: 0 auto;">
    <div style="height: 50px;"></div>
    <div class="offer" data-aos="fade-up">
        <div class="small-container">
            <div class="child">
                <div class="halfchild">
                    <img src="./images/promos/exclusive2.png" class="offer-img" data-aos="fade-right">
                </div>
                <div class="halfchild" data-aos="fade-left">
                    <p>Exclusively available here</p>
                    <h1>ApexTech Gaming pc</h1>
                    <small>
                    Power through any challenge with the ApexTech Phantom Gaming PC — featuring ultra-fast processors, RTX graphics, and sleek RGB design. Built for gamers who demand the best.<br>
                    </small>
                    <a href="/SuNNNyTech/src/pages/1.php" class="btn">Buy Now →</a>
                </div>
            </div>
        </div>
    </div>
    <img src="/SuNNNyTech/images/logos/rbg-line.gif" alt="Description" width="1080" height="5" style="display: block; margin: 0 auto;">
    <h2 data-aos="fade-up">PC Components</h2>
    <div class="line1"></div>
    <div class="child" data-aos="fade-up"></div>
    <div class="card-container">
      <div class="card">
        <img src="/SuNNNyTech/images/cards/3.jpg">
      </div>
      <div class="card">
        <img src="/SuNNNyTech/images/cards/2.jpg">
      </div>
      <div class="card">
        <img src="/SuNNNyTech/images/cards/1.jpg">
      </div>
      <div class="card">
        <img src="/SuNNNyTech/images/cards/4.jpg">
      </div>
      <div class="card">
        <img src="/SuNNNyTech/images/cards/5.webp">
      </div>
    </div>
    <img src="/SuNNNyTech/images/logos/rbg-line.gif" alt="Description" width="1080" height="5" style="display: block; margin: 0 auto;">
    <div style="height: 20px;"></div>
   <img src="/SuNNNyTech/images/banner/Windows11_banner.webp" alt="Description" width="1200" height="319"style="display: block; margin: 0 auto;">
   <div style="height: 20px;"></div>
    <img src="/SuNNNyTech/images/logos/rbg-line.gif" alt="Description" width="1080" height="5" style="display: block; margin: 0 auto;">
    <div class="testimonial" data-aos="fade-up">
        <div class="small-container">
            <h3><i class="fa fa-quote-left"></i>  See what our clients say about us -</h3>
            <div class="child" data-aos="fade-up">
                <?php while ($testimonial = mysqli_fetch_assoc($testimonials_result)): ?>
                    <div class="testchild">
                        <p><?php echo htmlspecialchars($testimonial['comment']); ?></p>
                        <div class="rating">
                            <?php
                            $rating = $testimonial['rating'];
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
                        <img src="<?php echo htmlspecialchars($testimonial['image_url']); ?>">
                        <h3><?php echo htmlspecialchars($testimonial['name']); ?></h3>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      height: 100%;
    }

    h1 {
      margin: 20px;
    }

    /* The back-to-top button */
    #backToTopBtn {
      position: fixed;
      bottom: 30px;
      right: 40px;
      display: none;
      font-size: 18px;
      background-color: #5ce1e6;
      color: white;
      border: none;
      padding: 15px 20px;
      border-radius: 50%;
      cursor: pointer;
      z-index: 1000;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
      transition: opacity 0.3s;
    }

    #backToTopBtn:hover {
      background-color: #0056b3;
    }
  </style>
  
  <!-- Back to Top Button -->
  <button id="backToTopBtn" title="Go to top">↑</button>

  <!-- JavaScript to show/hide and scroll -->
  <script>
    const backToTopBtn = document.getElementById("backToTopBtn");

    // Show button when scrolled down 300px
    window.onscroll = function () {
        if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
            backToTopBtn.style.display = "block";
        } else {
            backToTopBtn.style.display = "none";
        }
    };

    // Custom smooth scroll function with control over speed
    function smoothScrollToTop(duration) {
        let start = window.scrollY;
        let startTime = performance.now();

        function scroll() {
            let currentTime = performance.now();
            let timeElapsed = currentTime - startTime;
            let progress = timeElapsed / duration;

            if (progress < 1) {
                window.scrollTo(0, start - (start * progress));
                requestAnimationFrame(scroll);
            } else {
                window.scrollTo(0, 0); // Ensure we reach exactly the top
            }
        }

        requestAnimationFrame(scroll);
    }

    // Scroll to the top when the button is clicked
    backToTopBtn.onclick = function () {
        smoothScrollToTop(800);  // Speed is controlled by duration in milliseconds
    };
  </script>
  <img src="./images/logos/rbg-line.gif" alt="Description" width="1920" height="5">
    <?php include 'footer.php'; ?>

    <script src="./src/js/script.js"></script>

    <!-- AOS Script for scroll animations -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1200, // Animation duration
            easing: 'ease', // Animation easing
            once: true, // Trigger animations only once
        });
    </script>

    <?php mysqli_close($conn); ?>
    
</body>
</html>

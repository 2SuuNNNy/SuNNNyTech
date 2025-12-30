<?php
$current_year = date("Y");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SuNNNyTech Footer</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/SuNNNyTech/css/footer.css"> <!-- Link to your footer CSS -->
</head>
<body>

<div class="footer-section">
    <!-- Features Section -->
    <div class="features-section">
        <div class="feature-box">
            <div class="icon"><i class="fas fa-shield-alt"></i></div>
            <h5>Secure Shopping</h5>
            <p>256-bit SSL encryption protects your personal information</p>
        </div>
        <div class="feature-box">
            <div class="icon"><i class="fas fa-truck"></i></div>
            <h5>Fast Delivery</h5>
            <p>Free shipping on orders over $100, delivered within 2-3 days</p>
        </div>
        <div class="feature-box">
            <div class="icon"><i class="fas fa-undo"></i></div>
            <h5>Easy Returns</h5>
            <p>30-day return policy with free return shipping</p>
        </div>
        <div class="feature-box">
            <div class="icon"><i class="fas fa-headset"></i></div>
            <h5>24/7 Support</h5>
            <p>Round-the-clock customer service for all your needs</p>
        </div>
    </div>
</div>

<style>
.features-section {
    display: flex;
    justify-content: center; /* Centers the boxes */
    gap: 180px; /* Adds a gap between boxes */
    background-color: transparent;
    padding: 5px;
    width: 110%;
    box-sizing: border-box;
}

.feature-box {
    background-color: transparent;
    border: 2px solid #00c4cc;
    border-radius: 10px;
    width: 450px; /* Fixed width for consistent sizing */
    text-align: center;
    padding: 15px;
    color: transparent;
    box-sizing: border-box;
    display: inline-block;
    margin: 0; /* Ensures no additional margin */
}

.feature-box .icon {
    background-color: #006666;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    margin: 0 auto 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.feature-box .icon i {
    color: #00c4cc;
    font-size: 20px;
}

.feature-box h5 {
    color: #fff;
    font-size: 16px;
    margin-bottom: 5px;
    font-weight: normal;
}

.feature-box p {
    color: #a0a0a0;
    font-size: 12px;
    line-height: 1.3;
    margin: 0;
}
</style>
    <div style="height: -40px;"></div>
    <div class="footer-branding">
        <img src="/SuNNNyTech/images/footer/logo.gif" alt="NEXT LEVEL PC Logo" class="footer-logo">
        <p class="footer-description">
        SuNNNyTech is a tech store made for final project of my studies, specialized in the sale and purchase of computer hardware in Morocco.
        Whether it’s desktop PCs, laptops, or gaming PCs SuNNNyTech has it all. Components, 
        peripherals, and custom-built systems for every level of user.
        </p>
    </div>

    <!-- Footer Main -->
    <div class="footer-top">
        <div class="footer-logo-contact">
            <img src="/SuNNNyTech/images/header/complogo.gif" alt="SuNNNyTech Logo" class="footer-logo">
            <div class="footer-social-icons-1">
            <a href="https://instagram.com"><i class="fab fa-instagram"></i></a>
            <a href="https://facebook.com"><i class="fab fa-facebook-f"></i></a>
            <a href="https://twitter.com"><i class="fab fa-twitter"></i></a>
        </div>
    </div>

        <div class="footer-column">
            <h4>CATEGORIES</h4>
            <ul>
                <li><a href="./Desktops.php">Desktops</a></li>
                <li><a href="./Laptops.php">Laptops</a></li>
                <li><a href="./Accessoires.php">Accessoires</a></li>
            </ul>
        </div>

        <div class="footer-column">
            <h4>Help</h4>
            <ul>
                <li><a href="./payments.php">Payments</a></li>
                <li><a href="./Return Policy.php">Garantie & Retours</a></li>
                <li><a href="./shipping.php">Shipping</a></li>
            </ul>
        </div>

        <div class="footer-column">
            <h4>YOUR ACCOUNT</h4>
            <ul>
                <li><a href="./account.php">Personal information</a></li>
                <li><a href="./account.php">Orders</a></li>
                <li><a href="./wishlist.php">My wishlist</a></li>
            </ul>
        </div>

        <div class="footer-newsletter">
            <h4>NEWSLETTER</h4>
            <form>
                <input type="email" placeholder="Your mail address">
                <button type="submit">Subscribe</button>
            </form>
            <p>You can unsubscribe at any time. You can find our contact information in the terms of use or website.</p>
        </div>
    </div>

    <div class="footer-bottom">
        <p>© <?php echo $current_year; ?> SuNNNyTech. BNGT (Bigfaine Next Generation Tech), Dev SuNNNy_r(Amine Bigfaine), – All rights reserved.</p>
        <div class="footer-social-icons">
            <a href="https://instagram.com"><i class="fab fa-instagram"></i></a>
            <a href="https://facebook.com"><i class="fab fa-facebook-f"></i></a>
            <a href="https://twitter.com"><i class="fab fa-twitter"></i></a>
        </div>
    </div>
</footer>

</body>
</html>

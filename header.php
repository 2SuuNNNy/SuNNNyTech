<?php
require_once 'db_connect.php';

function calculateCartTotal($cart) {
    if (!is_array($cart) || empty($cart)) return 0;
    return array_sum(array_map(function ($item) {
        $price = isset($item['price']) ? floatval($item['price']) : 0;
        $quantity = isset($item['quantity']) ? max(1, intval($item['quantity'])) : 1;
        return $price * $quantity;
    }, $cart));
}

$firstLetter = strtoupper(substr($_SESSION['name'] ?? 'P', 0, 1));

// Wishlist count
$wishlist_count = 0;
if (isset($_SESSION['user_id'])) {
    $uid = $_SESSION['user_id'];
    $result = mysqli_query($conn, "SELECT COUNT(*) AS count FROM wishlist WHERE user_id = $uid");
    $row = mysqli_fetch_assoc($result);
    $wishlist_count = $row['count'];
}
?>
 <link rel="stylesheet" href="./src/css/main.css">
<!-- MAIN HEADER -->
<div class="header">
    <div class="container">
        <div class="navbar">
            <div class="logo">
                <a href="/SuNNNyTech/index.php"><img src="/SuNNNyTech/images/header/complogo.gif" alt="comp" width="235px"></a>
            </div>
            <div class="header-icons">
            <!-- Support & Delivery Icons -->
                <div class="icon-text"><img src="/SuNNNyTech/images/header/express-delivery.png" alt="Delivery" height="50px"><span>Fast Delivery</span></div>
                <div class="icon-text"><img src="/SuNNNyTech/images/header/24support.png" alt="Delivery" height="50px"><span>24 Support</span></div>
                <style>
                .header-icons {
                display: flex;
                align-items: center;
                gap: 1.5rem;
                }
                .icon-text {
                    display: flex;
                    align-items: center;
                    gap: 0.2rem;
                    font-size: 0.95rem;
                    color: #9ca0a4;
                }
                </style>
            </div>
            <nav>
            <div class="mobile-menu-toggle" onclick="toggleMobileMenu()">☰</div>
            <script>
                function toggleMobileMenu() {
                    const menu = document.querySelector('.nav-menu');
                    menu.classList.toggle('active');
                }

                function toggleCart() {
                    const miniCart = document.getElementById('mini-cart');
                    const overlay = document.getElementById('cart-overlay');
                    miniCart.classList.toggle('hidden');
                    overlay.classList.toggle('active');
                }
            </script>
                <ul class="nav-menu">
                    <li class="nav-item">
                        <form class="search-form" action="/SuNNNyTech/search.php" method="GET">
                            <input type="text" name="q" placeholder="Search" class="search-input">
                            <a href="#" class="search-toggle"><i class="fas fa-search"></i></a>
                        </form>
                    </li>
                    <li class="nav-item">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a href="/SuNNNyTech/account.php" class="account-link">
                                <img src="/SuNNNyTech/images/header/account.png" alt="Account" class="account-icon">
                            </a>
                        <?php else: ?>
                            <a href="/SuNNNyTech/login.php" class="account-link">
                            <img src="/SuNNNyTech/images/header/account.png" alt="Account" class="account-icon">
                            </a>
                        <?php endif; ?>
                        <style>
                            .account-icon {
                            width: 32px;
                            height: 32px;
                            border-radius: 50%;
                            object-fit: cover;
                            cursor: pointer;
                        }
                        </style>
                    </li>
                    <li class="nav-item">
                        <a href="/SuNNNyTech/wishlist.php" class="wishlist">
                            <i class="fa-solid fa-heart"></i>
                            <span id="wishlist-count" class="wishlist-count"><?php echo $wishlist_count; ?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <div class="cart-icon" onclick="toggleCart()">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <span id="cart-count" class="cart-count">
                                <?php
                                $cart_count = 0;
                                if (isset($_SESSION['user_id'])) {
                                    $uid = $_SESSION['user_id'];
                                    $result = mysqli_query($conn, "SELECT SUM(quantity) as total FROM cart WHERE user_id = $uid");
                                    if ($row = mysqli_fetch_assoc($result)) {
                                        $cart_count = $row['total'] ?? 0;
                                    }
                                }
                                echo $cart_count;
                                ?>
                            </span>
                        </div>

                        <div id="cart-overlay" onclick="toggleCart()"></div>
                        <div id="mini-cart" class="hidden">
                            <div class="cart-header">
                                <h3>Your Cart</h3>
                                <button class="close-cart" onclick="toggleCart()"><i class="fas fa-times"></i></button>
                            </div>
                            <div id="cart-items">
                                <?php
                                $cart_items = [];
                                $cart_total = 0;
                                if (isset($_SESSION['user_id']) && $cart_count > 0) {
                                    $uid = $_SESSION['user_id'];
                                    $query = "SELECT c.product_id, c.quantity, p.name, p.price, p.image_url 
                                            FROM cart c 
                                            JOIN products p ON c.product_id = p.id 
                                            WHERE c.user_id = $uid";
                                    $result = mysqli_query($conn, $query);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $cart_items[] = $row;
                                ?>
                                        <div class="cart-item">
                                            <img src="<?php echo htmlspecialchars($row['image_url']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
                                            <div class="cart-item-details">
                                                <h4><?php echo htmlspecialchars($row['name']); ?></h4>
                                                <p>Qty: <?php echo $row['quantity']; ?> × $<?php echo number_format($row['price'], 2); ?></p>
                                                <p>Total: $<?php echo number_format($row['quantity'] * $row['price'], 2); ?></p>
                                            </div>
                                            <button class="remove-item" data-product-id="<?php echo $row['product_id']; ?>">Remove</button>
                                        </div>
                                <?php
                                        $cart_total += $row['quantity'] * $row['price'];
                                    }
                                } else {
                                    echo "<p>Your cart is empty.</p>";
                                }
                                ?>
                            </div>
                            <div class="cart-subtotal">
                                <p>Total: $<?php echo number_format($cart_total, 2); ?></p>
                            </div>
                            <div class="mini-cart-footer">
                                <a href="/SuNNNyTech/cart.php" class="btn-view-cart">View Cart</a>
                                <a href="/SuNNNyTech/checkout.php" class="btn-checkout">Checkout</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<!-- SECOND HEADER (MENU) -->
<nav class="sub-header-menu">
    <ul>
    <li class="dropdown">
            <a href="/SuNNNyTech/CPU.php">CPU</a>
            <div class="dropdown-content">
                <?php
                $CPU_query = "SELECT id, name, image_url, price FROM products WHERE category = 'CPUs' LIMIT 3";
                $CPU_result = mysqli_query($conn, $CPU_query);
                while ($CPU = mysqli_fetch_assoc($CPU_result)) {
                    echo '<a href="/SuNNNyTech/src/pages/' . htmlspecialchars($CPU['id']) . '.php" class="product-item">';
                    echo    '<img src="' . htmlspecialchars($CPU['image_url']) . '" alt="Product" />';
                    echo    '<div class="info">';
                    echo        '<span class="name">' . htmlspecialchars($CPU['name']) . '</span>';
                    echo        '<span class="price">$' . number_format($CPU['price'], 2) . '</span>';
                    echo    '</div>';
                    echo '</a>';
                }
                ?>
            </div>
        </li>
        <li><a href="/SuNNNyTech/GPU.php">GPU</a></li>
        <li><a href="/SuNNNyTech/RAM.php">RAM</a></li>
        <li><a href="/SuNNNyTech/Motherbord.php">Motherbord</a></li>
        <li><a href="/SuNNNyTech/Harddisk.php">Hard disk</a></li>
        <li class="dropdown">
            <a href="/SuNNNyTech/Desktops.php">Desktops</a>
            <div class="dropdown-content">
                <?php
                $desktop_query = "SELECT id, name, image_url, price FROM products WHERE category = 'Desktops' LIMIT 3";
                $desktop_result = mysqli_query($conn, $desktop_query);
                while ($desktop = mysqli_fetch_assoc($desktop_result)) {
                    echo '<a href="/SuNNNyTech/src/pages/' . htmlspecialchars($desktop['id']) . '.php" class="product-item">';
                    echo    '<img src="' . htmlspecialchars($desktop['image_url']) . '" alt="Product" />';
                    echo    '<div class="info">';
                    echo        '<span class="name">' . htmlspecialchars($desktop['name']) . '</span>';
                    echo        '<span class="price">$' . number_format($desktop['price'], 2) . '</span>';
                    echo    '</div>';
                    echo '</a>';
                }
                ?>
            </div>
        </li>
        <li class="dropdown">
            <a href="/SuNNNyTech/Laptops.php">Laptops</a>
            <div class="dropdown-content">
                <?php
                $laptop_query = "SELECT id, name, image_url, price FROM products WHERE category = 'Laptops' LIMIT 3";
                $laptop_result = mysqli_query($conn, $laptop_query);
                while ($laptop = mysqli_fetch_assoc($laptop_result)) {
                    echo '<a href="/SuNNNyTech/src/pages/' . htmlspecialchars($laptop['id']) . '.php" class="product-item">';
                    echo    '<img src="' . htmlspecialchars($laptop['image_url']) . '" alt="Product" />';
                    echo    '<div class="info">';
                    echo        '<span class="name">' . htmlspecialchars($laptop['name']) . '</span>';
                    echo        '<span class="price">$' . number_format($laptop['price'], 2) . '</span>';
                    echo    '</div>';
                    echo '</a>';
                }
                ?>
            </div>
        </li>
        <li class="dropdown">
            <a href="/SuNNNyTech/Accessoires.php">Accessoires</a>
            <div class="dropdown-content">
                <?php
                $Accessoire_query = "SELECT id, name, image_url, price FROM products WHERE category = 'Accessoires' LIMIT 3";
                $Accessoire_result = mysqli_query($conn, $Accessoire_query);
                while ($Accessoire = mysqli_fetch_assoc($Accessoire_result)) {
                    echo '<a href="/SuNNNyTech/src/pages/' . htmlspecialchars($Accessoire['id']) . '.php" class="product-item">';
                    echo    '<img src="' . htmlspecialchars($Accessoire['image_url']) . '" alt="Product" />';
                    echo    '<div class="info">';
                    echo        '<span class="name">' . htmlspecialchars($Accessoire['name']) . '</span>';
                    echo        '<span class="price">$' . number_format($Accessoire['price'], 2) . '</span>';
                    echo    '</div>';
                    echo '</a>';
                }
                ?>
            </div>
        </li>
        <div class="footer-social-icons-1">
            <span>Contact Us</span>
            <a href="https://instagram.com"><i class="fab fa-instagram"></i></a>
            <a href="https://facebook.com"><i class="fab fa-facebook-f"></i></a>
            <a href="https://twitter.com"><i class="fab fa-twitter"></i></a>
        </div>
    </ul>
</nav>

<script>
// Toggle cart visibility
function toggleCart() {
    const miniCart = document.getElementById('mini-cart');
    const overlay = document.getElementById('cart-overlay');
    
    if (miniCart.classList.contains('hidden')) {
        // Show cart
        miniCart.style.visibility = 'visible';
        miniCart.style.zIndex = '2147483647'; // Ensure maximum z-index
        
        // Trigger reflow before adding the visible class for smooth animation
        void miniCart.offsetWidth;
        
        miniCart.classList.remove('hidden');
        miniCart.classList.add('visible');
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden'; // Prevent scrolling
    } else {
        // Hide cart
        miniCart.classList.remove('visible');
        miniCart.classList.add('hidden');
        overlay.classList.remove('active');
        document.body.style.overflow = ''; // Allow scrolling
        
        // Hide after animation completes
        setTimeout(function() {
            if (miniCart.classList.contains('hidden')) {
                miniCart.style.visibility = 'hidden';
            }
        }, 800); // Match this to your transition time (0.8s = 800ms)
    }
}

// Make sure cart is hidden on page load
document.addEventListener('DOMContentLoaded', function() {
    const miniCart = document.getElementById('mini-cart');
    const overlay = document.getElementById('cart-overlay');
    
    // Ensure cart is hidden initially
    miniCart.classList.add('hidden');
    miniCart.classList.remove('visible');
    overlay.classList.remove('active');
    
    // Force the cart to be hidden with inline style as a fallback
    miniCart.style.transform = 'translateX(100%)';
    miniCart.style.visibility = 'hidden';
    
    // Add event listeners to remove buttons
    const removeButtons = document.querySelectorAll('.remove-item');
    removeButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation(); // Prevent cart from closing
            const productId = this.getAttribute('data-product-id');
            removeFromCart(productId);
        });
    });
});

// Remove from cart functionality
function removeFromCart(productId) {
    fetch('/SuNNNyTech/remove_from_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `product_id=${productId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update cart count
            document.getElementById('cart-count').textContent = data.cart_count;
            
            // Update cart items
            updateCartItems();
        } else {
            alert(data.message || 'Failed to remove item from cart');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Add to cart functionality
function addToCart(productId, quantity = 1) {
    // Send AJAX request to add item to cart
    fetch('/SuNNNyTech/add_to_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `product_id=${productId}&quantity=${quantity}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update cart count
            document.getElementById('cart-count').textContent = data.cart_count;
            
            // Update cart items
            updateCartItems();
            
            // Show mini cart
            toggleCart();
        } else {
            alert(data.message || 'Failed to add item to cart');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Update cart items
function updateCartItems() {
    fetch('/SuNNNyTech/get_cart_items.php')
    .then(response => response.json())
    .then(data => {
        const cartItemsContainer = document.getElementById('cart-items');
        const cartSubtotal = document.querySelector('.cart-subtotal p');
        
        if (data.items && data.items.length > 0) {
            let itemsHTML = '';
            data.items.forEach(item => {
                itemsHTML += `
                <div class="cart-item">
                    <img src="${item.image_url}" alt="${item.name}">
                    <div class="cart-item-details">
                        <h4>${item.name}</h4>
                        <p>Qty: ${item.quantity} × $${parseFloat(item.price).toFixed(2)}</p>
                        <p>Total: $${(item.quantity * item.price).toFixed(2)}</p>
                    </div>
                    <button class="remove-item" data-product-id="${item.product_id}" onclick="removeFromCart(${item.product_id})">Remove</button>
                </div>`;
            });
            cartItemsContainer.innerHTML = itemsHTML;
            cartSubtotal.textContent = `Total: $${parseFloat(data.total).toFixed(2)}`;
        } else {
            cartItemsContainer.innerHTML = '<p>Your cart is empty.</p>';
            cartSubtotal.textContent = 'Total: $0.00';
        }
        
        // Re-attach event listeners to new remove buttons
        const removeButtons = document.querySelectorAll('.remove-item');
        removeButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.stopPropagation(); // Prevent cart from closing
                const productId = this.getAttribute('data-product-id');
                removeFromCart(productId);
            });
        });
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
</script>
<?php
// Close any open PHP tags and ensure proper file ending
?>
<style>
    /* Mini Cart Styling */
    #mini-cart {
        position: fixed;
        top: -20px;
        right: 70px;
        width: 350px;
        height: 100vh;
        background-color: #0a0a0a;
        border-left: 1px solid #00ffff;
        z-index: 199900; /* Reduced from maximum value */
        transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        flex-direction: column;
        transform: translateX(100%);
        visibility: hidden;
        box-shadow: -5px 0 15px rgba(0, 255, 255, 0.2);
    }
    
    #mini-cart.hidden {
        transform: translateX(100%);
    }
    
    #mini-cart.visible {
        transform: translateX(0);
    }
    
    #cart-overlay {
        position: fixed;
        top: 0;
        left: -300px;
        width: 2800%;
        height: 1920%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 11899px;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.6s ease, visibility 0.6s ease;
    }
    
    #cart-overlay.active {
        opacity: 1;
        visibility: visible;
    }
    
    /* Responsive mini-cart for all resolutions */
    @media (min-width: 1200px) {
        #mini-cart {
            width: 400px; /* Larger on very big screens */
            right: 130px; /* Moved 50px more to the right from 180px */
            top: -20px;
        }
    }
    
    @media (max-width: 1199px) and (min-width: 992px) {
        #mini-cart {
            width: 350px;
            right: 100px; /* Moved 50px more to the right from 150px */
            top: -20px;
        }
    }
    
    @media (max-width: 991px) and (min-width: 768px) {
        #mini-cart {
            width: 320px;
            right: 70px; /* Moved 50px more to the right from 120px */
            top: -20px;
        }
    }
    
    @media (max-width: 767px) and (min-width: 576px) {
        #mini-cart {
            width: 300px;
            right: 30px; /* Moved 50px more to the right from 80px */
            top: -20px;
        }
    }
    
    /* Keep mobile view percentage-based */
    @media (max-width: 575px) {
        #mini-cart {
            width: 90%;
            right: 5%;
            top: -20px;
        }
    }
    
    .cart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px;
        border-bottom: 1px solid #333;
        background: linear-gradient(to right, #000, #111);
    }
    
    .cart-header h3 {
        margin: 0;
        color: #00ffff;
        font-family: 'Orbitron', sans-serif;
        font-size: 18px;
    }
    
    .close-cart {
        background: none;
        border: none;
        color: #00ffff;
        font-size: 20px;
        cursor: pointer;
        transition: color 0.2s;
    }
    
    .close-cart:hover {
        color: #ff0066;
    }
    
    #cart-items {
        padding: 15px;
        flex: 1;
        overflow-y: auto;
    }
    
    .cart-item {
        display: flex;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #222;
        position: relative;
    }
    
    .cart-item img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border: 1px solid #333;
        border-radius: 4px;
        background-color: #111;
    }
    
    .cart-item-details {
        margin-left: 15px;
        flex-grow: 1;
    }
    
    .cart-item-details h4 {
        margin: 0 0 5px;
        font-size: 14px;
        color: #fff;
    }
    
    .cart-item-details p {
        margin: 0;
        font-size: 12px;
        color: #aaa;
    }
    
    .remove-item {
        background: none;
        border: none;
        color: #ff3366;
        font-size: 12px;
        cursor: pointer;
        position: absolute;
        right: 0;
        bottom: 15px;
        transition: color 0.2s;
    }
    
    .remove-item:hover {
        color: #ff0066;
        text-decoration: underline;
    }
    
    .cart-subtotal {
        padding: 15px;
        border-top: 1px solid #333;
        text-align: right;
        background-color: #111;
    }
    
    .cart-subtotal p {
        margin: 0;
        font-weight: bold;
        color: #00ffff;
        font-size: 16px;
    }
    
    .mini-cart-footer {
        display: flex;
        padding: 15px;
        gap: 10px;
        background-color: #0a0a0a;
        border-top: 1px solid #222;
    }
    
    .btn-view-cart, .btn-checkout {
        flex: 1;
        padding: 10px;
        text-align: center;
        border-radius: 4px;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 12px;
        transition: all 0.3s;
        text-decoration: none;
        font-family: 'Orbitron', sans-serif;
    }
    
    .btn-view-cart {
        background-color: #222;
        color: #00ffff;
        border: 1px solid #00ffff;
    }
    
    .btn-view-cart:hover {
        background-color: #333;
    }
    
    .btn-checkout {
        background-color: #00ffff;
        color: #000;
        border: 1px solid #00ffff;
    }
    
    .btn-checkout:hover {
        background-color: #5ce1e6;
    }
        /* Cart icon styling to match wishlist */
        .cart-icon {
        position: relative;
        display: inline-block;
        cursor: pointer;
    }
    
    .cart-icon i {
        font-size: 20px;
        color: #fff;
    }
    
    .cart-count {
        position: absolute;
        top: -8px;
        right: -8px;
        background-color: #5ce1e6;
        color: white;
        border-radius: 50%;
        width: 18px;
        height: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
    }
    
    /* Make sure wishlist has the same styling */
    .wishlist {
        position: relative;
        display: inline-block;
    }
    
    .wishlist i {
        font-size: 20px;
        color: #fff;
    }
    
    .wishlist-count {
        position: absolute;
        top: -8px;
        right: -8px;
        background-color: #5ce1e6;
        color: while;
        border-radius: 50%;
        width: 18px;
        height: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
    }
</style>
</script>
<?php
// Close any open PHP tags and ensure proper file ending
?>
<div class="mobile-menu-toggle">
    <i class="fas fa-bars"></i>
</div>


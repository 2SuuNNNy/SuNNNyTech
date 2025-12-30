// Header adjustment for <768px
const toggle = document.querySelector(".toggle");
const menu = document.querySelector(".nav-menu");

function toggleMenu() {
    if (menu.classList.contains("active")) {
        menu.classList.remove("active");
        // add hamburger icon
        toggle.innerHTML = `<i class="fa fa-bars"></i>`;
    } else {
        menu.classList.add("active");
        // add X icon
        toggle.innerHTML = `<i class="fa fa-times"></i>`;
    }
}

if (toggle) {
    toggle.addEventListener("click", toggleMenu, false);
} else {
    console.warn("Navbar toggle not found. Check '.toggle' in HTML.");
}

// Account Page, hide and show elements when, and if required.
var logForm = document.getElementById("loginForm");
var regForm = document.getElementById("registerForm");
var remLog = document.getElementById("removeLog");
var remReg = document.getElementById("removeReg");

function login() {
    if (remLog && remReg && logForm && regForm) {
        remLog.style.display = "none";
        remReg.style.display = "block";
        logForm.style.display = "flex";
        regForm.style.display = "none";
    }
}

function register() {
    if (remLog && remReg && logForm && regForm) {
        remReg.style.display = "none";
        remLog.style.display = "block";
        regForm.style.display = "flex";
        logForm.style.display = "none";
    }
}

// Preview images for the same product slider
var prodImg = document.getElementById("prodImg");
var smallImg = document.getElementsByClassName("small-img");
if (smallImg[0]) smallImg[0].onclick = function () {
    prodImg.src = smallImg[0].src;
}
if (smallImg[1]) smallImg[1].onclick = function () {
    prodImg.src = smallImg[1].src;
}
if (smallImg[2]) smallImg[2].onclick = function () {
    prodImg.src = smallImg[2].src;
}
if (smallImg[3]) smallImg[3].onclick = function () {
    prodImg.src = smallImg[3].src;
}

// Search bar toggle and submit
const searchToggle = document.querySelector('.search-toggle');
const searchInput = document.querySelector('.search-input');
const searchForm = document.querySelector('.search-form');

if (searchToggle && searchInput && searchForm) {
    console.log('Search elements found, attaching listeners.');
    searchToggle.addEventListener('click', function(e) {
        e.preventDefault();
        console.log('Search icon clicked.');
        if (searchInput.classList.contains('active')) {
            console.log('Input visible, checking submission.');
            const query = searchInput.value.trim();
            if (!query) {
                alert('Please enter a search term');
                console.log('Empty input, submission blocked.');
            } else {
                console.log('Submitting form with query:', query);
                searchForm.submit();
            }
        } else {
            console.log('Showing input field.');
            searchInput.classList.add('active');
            searchInput.focus();
        }
    });

    // Hide input when clicking outside
    document.addEventListener('click', function(e) {
        if (!searchForm.contains(e.target) && searchInput.classList.contains('active')) {
            console.log('Clicked outside, hiding input.');
            searchInput.classList.remove('active');
        }
    });
} else {
    console.error('Search elements missing. Check HTML for .search-form, .search-input, .search-toggle.');
}

// Scroll effects for fade, slide, and zoom
const scrollElements = document.querySelectorAll('.scroll-fade, .scroll-slide, .scroll-zoom');

const scrollObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
        if (!entry.isIntersecting) return;
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
    });
}, {
    threshold: 0.1,
    rootMargin: "0px 0px -50px 0px"
});

scrollElements.forEach(el => scrollObserver.observe(el));

// Cart popup toggle
document.addEventListener('DOMContentLoaded', function () {
    const cartIcon = document.querySelector('.cart-icon');
    const cartDropdown = document.getElementById('cartDropdown');

    if (!cartIcon || !cartDropdown) {
        console.error('Cart icon or dropdown not found');
        return;
    }

    cartIcon.addEventListener('click', function (e) {
        e.preventDefault();
        cartDropdown.classList.toggle('show');
    });

    document.addEventListener('click', function (e) {
        if (!cartDropdown.contains(e.target) && !cartIcon.contains(e.target)) {
            cartDropdown.classList.remove('show');
        }
    });
});

const minSlider = document.getElementById('minPrice');
const maxSlider = document.getElementById('maxPrice');
const minVal = document.getElementById('minPriceVal');
const maxVal = document.getElementById('maxPriceVal');

minSlider.addEventListener('input', () => {
    if (parseInt(minSlider.value) > parseInt(maxSlider.value)) {
        minSlider.value = maxSlider.value;
    }
    minVal.textContent = minSlider.value;
});

maxSlider.addEventListener('input', () => {
    if (parseInt(maxSlider.value) < parseInt(minSlider.value)) {
        maxSlider.value = minSlider.value;
    }
    maxVal.textContent = maxSlider.value;
});

document.addEventListener('DOMContentLoaded', () => {
    const elements = document.querySelectorAll('.scroll-fade, .scroll-slide, .scroll-zoom');
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1 });
    elements.forEach(el => observer.observe(el));
});

function addToCart(productId, quantity) {
    fetch('cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=add&product_id=${productId}&quantity=${quantity}&ajax=1`
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        if (data.success) {
            location.reload();  // Refresh cart
        }
    });
}
document.addEventListener("DOMContentLoaded", function () {
    const notifBox = document.getElementById("notif");

    function showNotification(message) {
        notifBox.textContent = message;
        notifBox.classList.add("show");

        setTimeout(() => {
            notifBox.classList.remove("show");
        }, 3000);
    }

    document.querySelectorAll('.remove-from-wishlist').forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.dataset.productId;
            const item = this.closest('.cart-item');

            fetch('wishlist.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({
                    ajax: 1,
                    action: 'remove',
                    product_id: productId
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    item.remove();
                    showNotification("Removed from wishlist.");
                    if (!document.querySelector('.cart-item')) {
                        document.querySelector('.cart-items').innerHTML = "<p class='empty-cart'>Your wishlist is empty.</p>";
                    }
                } else {
                    showNotification("Failed to remove item.");
                }
            });
        });
});
})

document.getElementById('wishlistBtn').addEventListener('click', function() {
    this.classList.add('active');
});

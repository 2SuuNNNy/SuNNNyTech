<?php
session_start();
require_once 'db_connect.php';

// Number of products per page
$productsPerPage = 4;

// Get current page from URL, default is 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;

// Calculate the offset for SQL
$offset = ($page - 1) * $productsPerPage;

// Get total CPUs count for pagination
$totalQuery = "SELECT COUNT(*) AS total FROM products WHERE category = 'Desktops'";
$totalResult = mysqli_query($conn, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalProducts = $totalRow['total'];

// Calculate total pages
$totalPages = ceil($totalProducts / $productsPerPage);

// Fetch CPUs limited to current page
$Desktops_query = "SELECT id, name, image_url, price, rating, specs_cpu, specs_gpu, specs_ram, specs_storage 
               FROM products 
               WHERE category = 'Desktops' 
               ORDER BY price ASC 
               LIMIT $productsPerPage OFFSET $offset";

$Desktops_result = mysqli_query($conn, $Desktops_query);

$page_title = "Desktop's | SuNNNyTech";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <link rel="stylesheet" href="./src/css/main.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="icon" type="image/png" href="./images/header/STicon.png" />
    <style>
        body {
            font-family: 'Orbitron', sans-serif;
            background: #f8fafd;
            margin: 0; padding: 0;
            color: #0a2a33;
        }
        .container {
            display: flex;
            max-width: 1200px;
            margin: 80px auto 40px; /* increased top margin here */
            gap: 30px;
        }
        .sidebar {
            position: relative;
            right: 20px;
            width: 480px;
            top: 60px;
            height: 800px;
            background: #0a2a33;
            border-radius: 12px;
            padding: 24px;
            color: #5ce1e6;
            box-shadow: 0 0 20px rgba(92, 225, 230, 0.18);
        }
        .sidebar h3 {
            font-size: 1.8rem;
            margin-bottom: 20px;
            font-weight: 700;
        }
        .sidebar label {
            display: block;
            margin: 12px 0;
            cursor: pointer;
            font-weight: 500;
            font-size: 1rem;
        }
        .sidebar input[type=checkbox] {
            margin-right: 10px;
            accent-color: #5ce1e6;
        }
        .sidebar input[type=range] {
            width: 100%;
            accent-color: #5ce1e6;
        }
        .main-content {
            flex-grow: 1;
        }
        .sort-bar {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 20px;
            gap: 12px;
            font-size: 0.9rem;
        }
        .sort-bar select,
        .sort-bar button {
            padding: 6px 12px;
            border-radius: 6px;
            border: 1px solid #5ce1e6;
            background: white;
            color: #0a2a33;
            cursor: pointer;
            font-family: 'Orbitron', sans-serif;
            font-weight: 600;
            box-shadow: 0 0 10px #5ce1e6;
        }
        .sort-bar button.active {
            background: #5ce1e6;
            color: white;
        }
        .product-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .product-row {
            background: transparent;
            border-radius: 12px;
            display: flex;
            padding: 20px;
            align-items: center;
            box-shadow: 0 0 15px rgba(92, 225, 230, 0.15);
            gap: 20px;
        }
        .product-image {
            flex: 0 0 140px;
            height: 140px;
            background: transparent;
            border-radius: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            box-shadow: inset 0 0 5px #b8cfd8;
        }
        .product-image img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        .product-details {
            flex-grow: 1;
            display: flex;
            flex-wrap: wrap;
            gap: 12px 30px;
            align-items: center;
            font-size: 0.95rem;
        }
        .product-title {
            font-weight: 700;
            font-size: 1.2rem;
            flex-basis: 100%;
            margin-bottom: 6px;
            color: white;
        }
        .spec-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #9a9a9a;
            flex: 1 1 140px;
            min-width: 140px;
        }
        .spec-item i {
            color: #5ce1e6;
            font-size: 1.1rem;
            min-width: 20px;
        }
        .price-block {
            flex: 0 0 160px;
            text-align: right;
            font-weight: 700;
            font-size: 1.3rem;
            color: #5ce1e6;
        }
        .price-block small {
            display: block;
            font-weight: 400;
            font-size: 0.85rem;
            color: #444;
            margin-top: 4px;
        }
        .product-actions {
            flex: 0 0 150px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            align-items: flex-end;
        }

        .pagination {
            margin-top: 30px;
            text-align: center;
            font-family: 'Orbitron', sans-serif;
        }
        .pagination a button {
            all: unset;
            cursor: pointer;
            padding: 8px 16px;
            margin: 0 6px;
            font-weight: 700;
            border-radius: 8px;
            box-shadow: 0 0 10px #5ce1e6;
            border: 1px solid #5ce1e6;
            color: #5ce1e6;
            font-family: 'Orbitron', sans-serif;
            text-align: center;
            display: inline-block;
        }
        .pagination a button:hover,
        .pagination a button.active {
            background: #5ce1e6;
            color: white;
        }
        .pagination button[disabled] {
            opacity: 0.5;
            cursor: default;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>
<div style="height: 250px;"></div>
<div class="container">

    <!-- Sidebar filter -->
    <aside class="sidebar">
        <h3>Price Range</h3>
        <input type="range" min="0" max="5000" value="2500" id="priceRange" />
        <div style="margin-top: 10px; color: #5ce1e6;">
            $0 — $5000
        </div>

        <h3 style="margin-top: 40px;">Processor</h3>
        <label><input type="checkbox" name="processor[]" value="Intel" /> Intel</label>
        <label><input type="checkbox" name="processor[]" value="AMD" /> AMD</label>

        <h3 style="margin-top: 40px;">Graphic Card</h3>
        <label><input type="checkbox" name="graphic[]" value="NVIDIA " /> Nvidia</label>
        <label><input type="checkbox" name="graphic[]" value="AMD" /> AMD</label>
        <label><input type="checkbox" name="graphic[]" value="INTEL" /> Intel</label>


        <h3 style="margin-top: 30px;">RAM</h3>
        <label><input type="checkbox" name="ram[]" value="8GB" /> 8 GB</label>
        <label><input type="checkbox" name="ram[]" value="16GB" /> 16 GB</label>
        <label><input type="checkbox" name="ram[]" value="32GB" /> 32 GB</label>

        <h3 style="margin-top: 30px;">Storage Type</h3>
        <label><input type="checkbox" name="storage[]" value="SSD" /> SSD</label>
        <label><input type="checkbox" name="storage[]" value="HDD" /> HDD</label>

    </aside>

    <!-- Main product listing -->
    <div style="height: 350px;"></div>
    <section class="main-content">
        <div class="sort-bar">
            <label for="sort">Sort by:</label>
            <select id="sort" name="sort">
                <option value="price-asc" selected>Price: Low to High</option>
                <option value="price-desc">Price: High to Low</option>
                <option value="rating-desc">Rating: High to Low</option>
            </select>
            <button class="active" id="btnListView">List</button>
        </div>

        <div class="product-list">
            <?php if (mysqli_num_rows($Desktops_result) > 0): ?>
                <?php while ($product = mysqli_fetch_assoc($Desktops_result)): ?>
                    <article class="product-row">
                        <div class="product-image">
                            <a href="./src/pages/<?php echo htmlspecialchars($product['id']); ?>.php">
                                <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" />
                            </a>
                        </div>
                        <div class="product-details">
                            <h2 class="product-title"><?php echo htmlspecialchars($product['name']); ?></h2>
                            <div class="spec-item"><i class="fa fa-microchip"></i> <?php echo htmlspecialchars($product['specs_cpu'] ?? 'N/A'); ?></div>
                            <div class="spec-item"><i class="fa fa-video"></i> <?php echo htmlspecialchars($product['specs_gpu'] ?? 'N/A'); ?></div>
                            <div class="spec-item"><i class="fa fa-memory"></i> <?php echo htmlspecialchars($product['specs_ram'] ?? 'N/A'); ?></div>
                            <div class="spec-item"><i class="fa fa-hdd"></i> <?php echo htmlspecialchars($product['specs_storage'] ?? 'N/A'); ?></div>
                        </div>
                        <div class="price-block">
                            $<?php echo number_format($product['price'], 2); ?>
                            <small>Free shipping</small>
                        </div>
                    </article>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No Desktops found.</p>
            <?php endif; ?>
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
        <!-- Pagination -->
        <div class="pagination">
            <?php if($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>"><button>Previous</button></a>
            <?php else: ?>
                <button disabled>Previous</button>
            <?php endif; ?>

            <?php
            for ($i = 1; $i <= $totalPages; $i++):
            ?>
                <a href="?page=<?php echo $i; ?>">
                    <button class="<?php echo ($i == $page) ? 'active' : ''; ?>"><?php echo $i; ?></button>
                </a>
            <?php endfor; ?>

            <?php if($page < $totalPages): ?>
                <a href="?page=<?php echo $page + 1; ?>"><button>Next</button></a>
            <?php else: ?>
                <button disabled>Next</button>
            <?php endif; ?>
        </div>
    </section>
</div>
<div style="height: 150px;"></div>
<?php include 'footer.php'; ?>

<script>
    document.getElementById('btnListView').addEventListener('click', () => {
        // Add your logic here
    });
    document.getElementById('btnGridView').addEventListener('click', () => {
        // Add your logic here
    });

    document.querySelectorAll('.btn-addcart').forEach(btn => {
        btn.addEventListener('click', () => {
            const pid = btn.getAttribute('data-product-id');
            alert(`Add product ID ${pid} to cart - implement AJAX or form submit`);
        });
    });
</script>

</body>
</html>
<?php mysqli_close($conn); ?>

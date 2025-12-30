<?php
session_start();
require_once('db_connect.php');

if (isset($_SESSION['user_id'])) {
    header("Location: account.php");
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $error = "Both email and password are required.";
    } else {
        $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($user = $result->fetch_assoc()) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                header("Location: account.php");
                exit();
            } else {
                $error = "Invalid email or password.";
            }
        } else {
            $error = "Invalid email or password.";
        }
        $stmt->close();
    }
}

$page_title = "Login | SuNNNyTech";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= $page_title ?></title>
  <script src="https://cdn.tailwindcss.com/3.4.16"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
  <link rel="icon" href="/SuNNNyTech/images/header/STicon.png" type="image/png">
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
  <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: '#3b82f6',
                    secondary: '#1e40af'
                },
                borderRadius: {
                    'button': '8px'
                }
            }
        }
    }
  </script>
</head>
<body class="min-h-screen bg-white">
  <div class="flex min-h-screen">
    <!-- Left Image Section -->
    <div class="hidden lg:flex lg:w-1/2 relative bg-cover bg-center" style="background-image: url('/SuNNNyTech/images/banner/login.jpg');">
      <div class="absolute inset-0 bg-gradient-to-r from-black/30 to-transparent"></div>
      <div class="relative z-10 flex flex-col justify-between p-12 text-white">
        <a href="index.php">
            <img src="/SuNNNyTech/images/header/complogo.gif" alt="SuNNNyTech Logo" class="w-32">
        </a>
        <div class="space-y-6">
          <h2 class="text-4xl font-bold leading-tight">Welcome Back</h2>
          <p class="text-xl opacity-90">Login to manage your orders and wishlist with SuNNNyTech</p>
          <div class="flex items-center justify-between space-x-4 text-gray-200 text-sm mt-4">
            <div class="flex items-center space-x-2">
              <i class="ri-shield-check-line text-green-400 text-xl"></i>
              <span>Secure Login</span>
            </div>
            <div class="flex items-center space-x-2">
              <i class="ri-truck-line text-blue-400 text-xl"></i>
              <span>Fast Access</span>
            </div>
            <div class="flex items-center space-x-2">
              <i class="ri-customer-service-2-line text-yellow-400 text-xl"></i>
              <span>Support Anytime</span>
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

    <!-- Right Form Section -->
    <div class="flex-1 flex items-center justify-center px-8 py-12 lg:px-16">
      <div id="login-panel" class="w-full max-w-md space-y-8 bg-white/0 rounded-lg p-8 shadow-lg transition-colors duration-[1500ms]">
        <div class="lg:hidden text-center">
          <div class="font-['Pacifico'] text-3xl font-bold text-gray-900">SuNNNyTech</div>
        </div>

        <div class="text-center">
          <h1 class="text-3xl font-bold text-gray-900">Sign In to Your Account</h1>
          <p class="mt-2 text-gray-600">Manage your tech journey with ease</p>
        </div>

        <?php if (!empty($error)): ?>
          <div class="text-sm text-red-600 bg-red-100 border border-red-200 px-4 py-2 rounded">
            <?= htmlspecialchars($error) ?>
          </div>
        <?php endif; ?>

        <form action="login.php" method="POST" class="space-y-6">
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
            <input type="email" id="email" name="email" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>"
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary outline-none text-sm" required placeholder="you@example.com">
          </div>

          <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
            <input type="password" id="password" name="password"
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary outline-none text-sm" required placeholder="Enter your password">
          </div>

          <button type="submit"
            class="w-full bg-primary hover:bg-secondary text-white font-medium py-3 px-4 rounded-button transition-all duration-200 focus:ring-2 focus:ring-offset-2 focus:ring-primary outline-none">
            Login
          </button>

          <!-- Social logins -->
          <div class="relative">
            <div class="absolute inset-0 flex items-center">
              <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
              <span class="px-4 bg-white text-gray-500">Or login with</span>
            </div>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <a href="google-login.php"
              class="flex items-center justify-center py-3 border border-gray-300 rounded-button hover:bg-gray-100 transition-colors">
              <i class="ri-google-fill text-red-500 text-xl"></i>
            </a>
            <a href="fb-login.php"
              class="flex items-center justify-center py-3 border border-gray-300 rounded-button hover:bg-gray-100 transition-colors">
              <i class="ri-facebook-fill text-blue-600 text-xl"></i>
            </a>
          </div>

          <div class="text-center">
            <p class="text-sm text-gray-600">
              Don’t have an account?
              <a href="register.php" class="text-primary hover:text-secondary font-medium transition-colors">Register here</a>
            </p>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    window.addEventListener('load', () => {
      const panel = document.getElementById('login-panel');
      panel.offsetHeight;
      panel.classList.remove('bg-white/0');
      panel.classList.add('bg-white');
    });
  </script>
  <?php if (isset($conn)) mysqli_close($conn); ?>
</body>
</html>

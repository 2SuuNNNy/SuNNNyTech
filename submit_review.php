<?php
session_start();
require_once('db_connect.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header('Location: login.php');
    exit;
}

// Process the review submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $customer_name = isset($_POST['customer_name']) ? $_POST['customer_name'] : '';
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 5;
    $review_text = isset($_POST['review_text']) ? $_POST['review_text'] : '';
    
    // Validate inputs
    if ($product_id <= 0 || empty($customer_name) || empty($review_text) || $rating < 1 || $rating > 5) {
        $_SESSION['error_message'] = 'Invalid review data. Please try again.';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
    
    // Insert review into database
    $query = "INSERT INTO reviews (product_id, customer_name, rating, review_text) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "isis", $product_id, $customer_name, $rating, $review_text);
        $success = mysqli_stmt_execute($stmt);
        
        if ($success) {
            $_SESSION['success_message'] = 'Your review has been submitted successfully!';
        } else {
            $_SESSION['error_message'] = 'Failed to submit review. Please try again.';
        }
        
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['error_message'] = 'Database error. Please try again later.';
    }
    
    // Redirect back to product page
    header('Location: src/pages/' . $product_id . '.php');
    exit;
}

// If not a POST request, redirect to home page
header('Location: index.php');
exit;
?>
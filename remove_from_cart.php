<?php
session_start();

// Check if the product ID is set
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Remove product from cart if it exists
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
}

// Redirect back to the cart page
header('Location: cart.php');
exit;
?>

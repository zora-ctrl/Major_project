<?php
session_start();

// Check if the cart exists
if (isset($_SESSION['cart']) && !empty($_SESSION['cart']) && isset($_POST['quantity'])) {
    foreach ($_POST['quantity'] as $product_id => $quantity) {
        if ($quantity <= 0) {
            unset($_SESSION['cart'][$product_id]); // Remove product if quantity is 0 or less
        } else {
            $_SESSION['cart'][$product_id]['quantity'] = $quantity; // Update quantity
        }
    }
}

// Redirect back to the cart page
header('Location: cart.php');
exit;
?>

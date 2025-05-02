<?php
session_start();
require 'db1.php'; // DB connection

if (!isset($_SESSION['cart'], $_SESSION['order_id'], $_SESSION['user_name'])) {
    echo "<div class='alert alert-danger'>Session expired or invalid access.</div>";
    exit;
}

$order_id = $_SESSION['order_id'];
$total_amount = 0;
$order_date = date('Y-m-d');

// Insert each product in the cart as a separate record or serialize
foreach ($_SESSION['cart'] as $product) {
    $name = $product['name'];
    $price = $product['price'];
    $quantity = $product['quantity'];
    $line_total = $price * $quantity;
    $total_amount += $line_total;

    try {
        $stmt = $pdo->prepare("INSERT INTO orders (order_id, product, pdprice, total_amount, order_date) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$order_id, $name . " (x$quantity)", $price, $line_total, $order_date]);
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Error inserting order: " . $e->getMessage() . "</div>";
        exit;
    }
}

// Optional: clear cart and reset session
unset($_SESSION['cart']);
unset($_SESSION['order_id']);
unset($_SESSION['payment_method']);
unset($_SESSION['payment_id']);

// Redirect to success page
header("Location: order_success.php");
exit;
?>

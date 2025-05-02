<?php
session_start();
require 'db1.php';

$status = $_GET['status'] ?? 'failed';
$order_id = $_GET['order_id'] ?? '';

if ($status !== 'success' || !$order_id || !isset($_SESSION['cart'])) {
    echo "<div class='alert alert-danger'>Payment failed or session expired.</div>";
    exit;
}

// Get user and order info
$total_amount = 0;
$products = [];

foreach ($_SESSION['cart'] as $product) {
    $total_amount += $product['price'] * $product['quantity'];
    $products[] = [
        'name' => $product['name'],
        'price' => $product['price'],
        'quantity' => $product['quantity']
    ];
}

$products_json = json_encode($products);
$order_date = date('Y-m-d H:i:s');

$name = $_SESSION['user_name'];
$email = $_SESSION['user_email'];
$phone = $_SESSION['user_phone'];
$address = $_SESSION['user_address'];

try {
    // Save order
    $stmt1 = $pdo->prepare("INSERT INTO orders (order_id, product, order_date, total_amount) VALUES (?, ?, ?, ?)");
    $stmt1->execute([$order_id, $products_json, $order_date, $total_amount]);

    // Save customer info
    $stmt2 = $pdo->prepare("INSERT INTO order_customers (order_id, name, email, phone, address) VALUES (?, ?, ?, ?, ?)");
    $stmt2->execute([$order_id, $name, $email, $phone, $address]);

    // Email confirmation
    mail($email, "Order Confirmation - Mobile Cart",
        "Hi $name,\n\nThank you for your order!\nOrder ID: $order_id\nAmount: ₹$total_amount\n\nMobile Cart Team",
        "From: no-reply@mobilecart.com"
    );

    // Clear session
    unset($_SESSION['cart']);
    unset($_SESSION['user_name'], $_SESSION['user_email'], $_SESSION['user_phone'], $_SESSION['user_address']);

    // Redirect to success page
    header("Location: order_success.php?order_id=" . urlencode($order_id));
    exit;

} catch (PDOException $e) {
    echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
}

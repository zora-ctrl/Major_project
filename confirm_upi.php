<?php
session_start();
require 'db1.php'; // Database connection

// Validate required session and POST data
if (
    !isset($_POST['payment_method']) || 
    !isset($_POST['total_price']) || 
    !isset($_SESSION['order_id']) || 
    !isset($_SESSION['cart']) || 
    !isset($_SESSION['user_name']) || 
    !isset($_SESSION['user_email']) || 
    !isset($_SESSION['user_phone']) || 
    !isset($_SESSION['user_address'])
) {
    header('Location: index.php');
    exit;
}

// Gather data
$order_id = $_SESSION['order_id'];
$total_price = $_POST['total_price'];
$order_date = date('Y-m-d H:i:s');

$name = $_SESSION['user_name'];
$email = $_SESSION['user_email'];
$phone = $_SESSION['user_phone'];
$address = $_SESSION['user_address'];

// Build product list
$products = [];
foreach ($_SESSION['cart'] as $product) {
    $products[] = [
        'name' => $product['name'],
        'price' => $product['price'],
        'quantity' => $product['quantity']
    ];
}
$products_json = json_encode($products);

try {
    // Insert into orders table
    $stmt1 = $pdo->prepare("INSERT INTO orders (order_id, product, order_date, total_amount) VALUES (?, ?, ?, ?)");
    $stmt1->execute([$order_id, $products_json, $order_date, $total_price]);

    // Insert into order_customers table
    $stmt2 = $pdo->prepare("INSERT INTO order_customers (order_id, name, email, phone, address) VALUES (?, ?, ?, ?, ?)");
    $stmt2->execute([$order_id, $name, $email, $phone, $address]);

    // Email confirmation
    $to = $email;
    $subject = "Order Confirmation - Mobile Cart";
    $message = "
Dear $name,\n\n
Thank you for your order!\n
Order ID: $order_id\n
Total Amount: ₹" . number_format($total_price, 2) . "\n\n
We’ll notify you once your order is shipped.\n\n
Regards,\nMobile Cart Team";
    $headers = "From: no-reply@mobilecart.com";

    mail($to, $subject, $message, $headers);

    // Clear cart and cleanup
    unset($_SESSION['cart']);
    unset($_SESSION['user_name'], $_SESSION['user_email'], $_SESSION['user_phone'], $_SESSION['user_address']);

    // Redirect to success page
    header("Location: order_success.php?order_id=" . urlencode($order_id));
    exit;

} catch (PDOException $e) {
    echo "<div class='alert alert-danger'>Error processing your order: " . htmlspecialchars($e->getMessage()) . "</div>";
    exit;
}
?>

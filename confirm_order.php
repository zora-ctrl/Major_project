<?php
session_start();
require 'db1.php'; // DB connection

$order_step = $_POST['step'] ?? 'details';

// Ensure cart exists
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<div class='alert alert-warning'>Cart is empty.</div>";
    exit;
}

// Calculate totals
$total_amount = 0;
foreach ($_SESSION['cart'] as $product) {
    $total_amount += $product['price'] * $product['quantity'];
}

// Generate or reuse order ID
$order_id = $_SESSION['order_id'] ?? uniqid('order_', true);
$_SESSION['order_id'] = $order_id;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Confirm Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-5">

<?php if ($order_step === 'details'): ?>
    <h2>Order Summary</h2>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Product</th><th>Price</th><th>Qty</th><th>Total</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($_SESSION['cart'] as $product): ?>
            <tr>
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td>₹<?= number_format($product['price'], 2) ?></td>
                <td><?= $product['quantity'] ?></td>
                <td>₹<?= number_format($product['price'] * $product['quantity'], 2) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <h4 class="text-end">Total: ₹<?= number_format($total_amount, 2) ?></h4>
    
    <form method="POST" class="mt-4">
        <input type="hidden" name="step" value="payment_info">
        <h4>Customer Details</h4>
        <div class="mb-3"><input name="name" class="form-control" required placeholder="Full Name"></div>
        <div class="mb-3"><input name="email" class="form-control" required type="email" placeholder="Email"></div>
        <div class="mb-3"><input name="phone" class="form-control" required placeholder="Phone"></div>
        <div class="mb-3"><textarea name="address" class="form-control" rows="3" required placeholder="Shipping Address"></textarea></div>
        <button type="submit" class="btn btn-success w-100">Proceed to Payment Info</button>
    </form>

<?php elseif ($order_step === 'payment_info'): 
// Save customer data in session
$_SESSION['user_name'] = $_POST['name'];
$_SESSION['user_email'] = $_POST['email'];
$_SESSION['user_phone'] = $_POST['phone'];
$_SESSION['user_address'] = $_POST['address'];

$order_id = $_SESSION['order_id'];
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];

// Include DB connection
require 'db1.php';

try {
    // Insert customer details into DB
    $stmt = $pdo->prepare("INSERT INTO order_customers (order_id, name, email, phone, address) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$order_id, $name, $email, $phone, $address]);
} catch (PDOException $e) {
    echo "<div class='alert alert-danger'>Failed to insert customer data: " . $e->getMessage() . "</div>";
}
?>
    <h2>Payment Details</h2>
    <form method="POST">
        <input type="hidden" name="step" value="upi">

        <div class="mb-3">
            <label>Payment Method</label>
            <select name="payment_method" class="form-control" required>
                <option value="upi">UPI</option>
                <option value="card">Credit/Debit Card</option>
                <option value="wallet">Wallet</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Payment ID (e.g., yourname@upi or Card Last 4 digits)</label>
            <input type="text" name="payment_id" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Proceed to Payment</button>
    </form>

<?php elseif ($order_step === 'upi'): 
    // Save payment info
    $_SESSION['payment_method'] = $_POST['payment_method'] ?? 'upi';
    $_SESSION['payment_id'] = $_POST['payment_id'] ?? '';
?>
    <h2>Redirecting to Payment Gateway</h2>
    <div class="alert alert-info">Please wait, you are being redirected to the dummy payment gateway...</div>

    <form id="gatewayForm" method="POST" action="dummy_gateway.php">
        <input type="hidden" name="order_id" value="<?= htmlspecialchars($order_id) ?>">
        <input type="hidden" name="amount" value="<?= htmlspecialchars($total_amount) ?>">
        <input type="hidden" name="payment_method" value="<?= htmlspecialchars($_SESSION['payment_method']) ?>">
        <input type="hidden" name="payment_id" value="<?= htmlspecialchars($_SESSION['payment_id']) ?>">
        <input type="hidden" name="customer_name" value="<?= htmlspecialchars($_SESSION['user_name']) ?>">
    </form>

    <script>
        setTimeout(() => {
            document.getElementById('gatewayForm').submit();
        }, 2000);
    </script>
<?php endif; ?>

</div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php include 'footer.php'; ?>
</body>
</html>

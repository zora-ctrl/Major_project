<?php
require 'db1.php'; // Database connection

$order = null;
$error = '';
$products = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = trim($_POST['order_id']);
    $email = trim($_POST['email']);

    // Fetch the order and customer details from the database
    $stmt = $pdo->prepare("SELECT orders.*, order_customers.name, order_customers.email, order_customers.phone, order_customers.address 
                           FROM orders 
                           JOIN order_customers ON orders.order_id = order_customers.order_id 
                           WHERE orders.order_id = ? AND order_customers.email = ?");
    $stmt->execute([$orderId, $email]);
    $order = $stmt->fetch();

    // If no order is found, set the error message
    if (!$order) {
        $error = "Order not found. Please check the Order ID and Email.";
    }
}

// Define order status steps for progress tracker
$statusSteps = ["Pending", "Confirmed", "Shipped", "Delivered"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Track Order</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .progress-tracker {
      display: flex;
      justify-content: space-between;
      margin-top: 20px;
    }
    .step {
      flex-grow: 1;
      text-align: center;
      position: relative;
    }
    .step::before {
      content: '';
      position: absolute;
      top: 12px;
      left: 0;
      right: 0;
      height: 2px;
      background: #ccc;
      z-index: 0;
    }
    .circle {
      width: 25px;
      height: 25px;
      background: #ccc;
      border-radius: 50%;
      margin: 0 auto;
      z-index: 1;
      position: relative;
    }
    .active .circle {
      background: #28a745;
    }
    .active::before {
      background: #28a745;
    }
  </style>
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container mt-5">
  <h2 class="mb-4">Track Your Order</h2>

  <form method="post" class="row g-3 mb-4">
    <div class="col-md-4">
      <input type="text" name="order_id" class="form-control" placeholder="Order ID" required>
    </div>
    <div class="col-md-4">
      <input type="email" name="email" class="form-control" placeholder="Email" required>
    </div>
    <div class="col-md-4">
      <button type="submit" class="btn btn-primary w-100">Track</button>
    </div>
  </form>

  <?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php elseif ($order): ?>
    <div class="card">
      <div class="card-header bg-info text-white">Order #<?= htmlspecialchars($order['order_id']) ?> - <?= htmlspecialchars($order['status']) ?></div>
      <div class="card-body">
        <p><strong>Name:</strong> <?= htmlspecialchars($order['name']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($order['email']) ?></p>
        <p><strong>Phone:</strong> <?= htmlspecialchars($order['phone']) ?></p>
        <p><strong>Address:</strong><br><?= nl2br(htmlspecialchars($order['address'])) ?></p>
        <p><strong>Date:</strong> <?= date("d M Y, h:i A", strtotime($order['created_at'])) ?></p>

        <!-- Progress Tracker -->
        <div class="progress-tracker">
          <?php foreach ($statusSteps as $step): ?>
            <div class="step <?= array_search($step, $statusSteps) <= array_search($order['status'], $statusSteps) ? 'active' : '' ?>">
              <div class="circle"></div>
              <div><?= $step ?></div>
            </div>
          <?php endforeach; ?>
        </div>

        <!-- Product Details (from orders table) -->
        <h5 class="mt-4">Product Details</h5>
        <table class="table">
          <thead>
            <tr>
              <th>Product Name</th>
              <th>Quantity</th>
              <th>Price (₹)</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><?= htmlspecialchars($order['product']) ?></td>
              <td><?= intval($order['quantity']) ?></td>
              <td>₹<?= number_format($order['pdprice'], 2) ?></td>
            </tr>
          </tbody>
        </table>

        <!-- Total Amount -->
        <strong>Total:</strong> ₹<?= htmlspecialchars($order['total_amount']) ?>
      </div>
    </div>
  <?php endif; ?>
</div>
<br>
<?php include 'footer.php'; ?>
</body>
</html>

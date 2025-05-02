<?php
session_start();
include 'db1.php';
$order_id = $_GET['order_id'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Success</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
  <?php include 'navbar.php'; ?>
  <div class="container text-center mt-5">
    <h1 class="text-success">🎉 Order Placed Successfully!</h1>
    <p><strong><?= htmlspecialchars($order_id) ?></strong></p>
    <a href="index.php" class="btn btn-primary mt-3">Continue Shopping</a>
  </div>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <?php include 'footer.php'; ?>
</body>
</html>

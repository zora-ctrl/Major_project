<?php
require 'db1.php';
session_start(); // Assuming an admin session exists



$orders = null;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $orderId = $_POST['order_id'];
    $newStatus = $_POST['status'];

    $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE order_id = ?");
    $stmt->execute([$newStatus, $orderId]);

    $success = "Order status updated successfully!";
}

// Fetch all orders for the admin panel
$stmt = $pdo->query("SELECT orders.*, order_customers.name, order_customers.email, order_customers.phone, order_customers.address 
                     FROM orders 
                     JOIN order_customers ON orders.order_id = order_customers.order_id");
$orders = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Panel - Manage Orders</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'navdash.php'; ?>

<div class="container mt-5">
  <h2 class="mb-4">Admin Panel - Manage Orders</h2>

  <?php if (isset($success)): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
  <?php endif; ?>

  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>Order ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($orders as $order): ?>
        <tr>
          <td><?= htmlspecialchars($order['order_id']) ?></td>
          <td><?= htmlspecialchars($order['name']) ?></td>
          <td><?= htmlspecialchars($order['email']) ?></td>
          <td><?= htmlspecialchars($order['phone']) ?></td>
          <td><?= nl2br(htmlspecialchars($order['address'])) ?></td>
          <td><?= htmlspecialchars($order['status']) ?></td>
          <td>
            <form method="post">
              <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
              <select name="status" class="form-select">
                <option value="Pending" <?= $order['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                <option value="Confirmed" <?= $order['status'] == 'Confirmed' ? 'selected' : '' ?>>Confirmed</option>
                <option value="Shipped" <?= $order['status'] == 'Shipped' ? 'selected' : '' ?>>Shipped</option>
                <option value="Delivered" <?= $order['status'] == 'Delivered' ? 'selected' : '' ?>>Delivered</option>
              </select>
              <button type="submit" name="update_status" class="btn btn-primary mt-2">Update Status</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php include 'footer.php'; ?>
</body>
</html>

<?php
require 'db1.php'; // Database connection

// Fetch all customer order details
$stmt = $pdo->query("SELECT * FROM order_customers ORDER BY created_at DESC");
$customers = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Details</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'navdash.php'; ?>

<div class="container mt-5">
  <h2 class="mb-4">Customer Order Details</h2>
  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>Order ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Ordered At</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($customers as $customer): ?>
        <tr>
          <td><?= htmlspecialchars($customer['order_id']) ?></td>
          <td><?= htmlspecialchars($customer['name']) ?></td>
          <td><?= htmlspecialchars($customer['email']) ?></td>
          <td><?= htmlspecialchars($customer['phone']) ?></td>
          <td><?= nl2br(htmlspecialchars($customer['address'])) ?></td>
          <td><?= htmlspecialchars($customer['created_at']) ?></td>
          <td>
        <a href="delete_customer.php?id=<?= $customer['order_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this customer?');">Delete</a>
      </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<br><br><br><br><br><br>
<?php include 'footer.php'; ?>
</body>
</html>

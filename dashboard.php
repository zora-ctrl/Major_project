<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include 'db1.php';

// Total Products
$totalProducts = $pdo->query("SELECT COUNT(*) FROM product")->fetchColumn();

// Total Orders
$totalOrders = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();

// Total Revenue
$totalRevenue = $pdo->query("SELECT SUM(price * quantity) AS total FROM order_items")->fetch()['total'] ?? 0;

// Recent Orders (last 5)
$recentOrders = $pdo->query("SELECT order_id, product, total_amount, created_at FROM orders ORDER BY created_at DESC LIMIT 5")->fetchAll();

// Revenue Chart (last 7 days)
$chartData = $pdo->query("
    SELECT DATE(orders.created_at) AS date, SUM(order_items.price * order_items.quantity) AS revenue
    FROM order_items
    JOIN orders ON order_items.order_id = orders.order_id
    GROUP BY DATE(orders.created_at)
    ORDER BY DATE(orders.created_at) DESC
    LIMIT 7
")->fetchAll(PDO::FETCH_ASSOC);


$chartLabels = array_reverse(array_column($chartData, 'date'));
$chartValues = array_reverse(array_map('floatval', array_column($chartData, 'revenue')));
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<?php include "./navdash.php"; ?>

<div class="container mt-4">
  <h2>Dashboard Overview</h2>

  <div class="row mb-4">
    <div class="col-md-4">
      <div class="card text-white bg-primary mb-3">
        <div class="card-header">Total Orders</div>
        <div class="card-body"><h5><?= htmlspecialchars($totalOrders) ?></h5></div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card text-white bg-success mb-3">
        <div class="card-header">Total Products</div>
        <div class="card-body"><h5><?= htmlspecialchars($totalProducts) ?></h5></div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card text-white bg-warning mb-3">
        <div class="card-header">Revenue</div>
        <div class="card-body"><h5>₹<?= number_format($totalRevenue, 2) ?></h5></div>
      </div>
    </div>
  </div>

  <h4>Revenue Over Last 7 Days</h4>
  <canvas id="salesChart" height="100"></canvas>

  <h4 class="mt-5">Recent Orders</h4>
  <table class="table table-bordered">
    <thead class="table-light">
      <tr>
        <th>Order ID</th>
        <th>Product</th>
        <th>Total Amount</th>
        <th>Created At</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($recentOrders as $order): ?>
        <tr>
          <td><?= htmlspecialchars($order['order_id']) ?></td>
          <td><?= htmlspecialchars($order['product']) ?></td>
          <td>₹<?= number_format($order['total_amount'], 2) ?></td>
          <td><?= htmlspecialchars($order['created_at']) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<script>
  const ctx = document.getElementById('salesChart').getContext('2d');
  const salesChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: <?= json_encode($chartLabels) ?>,
      datasets: [{
        label: 'Revenue (₹)',
        data: <?= json_encode($chartValues) ?>,
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderColor: 'rgb(54, 162, 235)',
        borderWidth: 2,
        tension: 0.3,
        fill: true
      }]
    },
    options: {
      scales: {
        y: { beginAtZero: true }
      }
    }
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

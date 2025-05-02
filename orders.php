<?php
session_start();
include "./navdash.php";
require 'db1.php'; // Database connection

// Fetch orders (assuming product name is directly in orders table now)
try {
    $query = "SELECT order_id, order_date, total_amount, product, quantity 
              FROM orders 
              ORDER BY order_date DESC, order_id DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<div class='alert alert-danger'>Error fetching orders: " . htmlspecialchars($e->getMessage()) . "</div>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center">Order History</h1>
    <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Products</th>
                <th>Order Date</th>
                <th>Total Amount (Rs.)</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if (!empty($orders)) {
            $current_order_id = null;
            $product_list = [];
            $order_date = '';
            $total_amount = 0;

            foreach ($orders as $order) {
                if ($current_order_id !== $order['order_id']) {
                    // Display the previous order row
                    if ($current_order_id !== null) {
                        echo "<tr><td>{$current_order_id}</td><td><ul>";
                        foreach ($product_list as $product) {
                            echo "<li>{$product['name']}</li>";
                        }
                        echo "</ul></td><td>{$order_date}</td><td>" . number_format($total_amount, 2) . "</td></tr>";
                    }
                    // Start new order
                    $current_order_id = $order['order_id'];
                    $order_date = $order['order_date'];
                    $total_amount = $order['total_amount'];
                    $product_list = [];
                }
                $product_list[] = ['name' => $order['product'], 'quantity' => $order['quantity']];
            }

            // Display the last order
            if ($current_order_id !== null) {
                echo "<tr><td>{$current_order_id}</td><td><ul>";
                foreach ($product_list as $product) {
                    echo "<li>{$product['name']}</li>";
                }
                echo "</ul></td><td>{$order_date}</td><td>" . number_format($total_amount, 2) . "</td></tr>";
            }
        } else {
            echo "<tr><td colspan='4' class='text-center'>No orders found.</td></tr>";
        }
        ?>
        </tbody>
    </table>
    <a href="dashboard.php" class="btn btn-primary">Back to Home</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<br><br>
<?php include 'footer.php'; ?>
</body>
</html>

<?php
session_start();
require 'db1.php'; // database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    try {
        // First delete from order_customers if linked (optional based on your schema)
        $stmt = $pdo->prepare("DELETE FROM order_customers WHERE order_id = ?");
        $stmt->execute([$order_id]);

        // Then delete from orders
        $stmt = $pdo->prepare("DELETE FROM orders WHERE order_id = ?");
        $stmt->execute([$order_id]);

        $_SESSION['success'] = "Order deleted successfully!";
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error deleting order: " . $e->getMessage();
    }
}

header("Location: orders.php"); // redirect back to the order list
exit;

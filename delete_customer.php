<?php
require 'db1.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Delete the customer with the given ID
    $stmt = $pdo->prepare("DELETE FROM order_customers WHERE order_id = ?");
    $stmt->execute([$id]);

    // Redirect back to the customer list
    header("Location: user_details.php"); // Update if your file name is different
    exit;
} else {
    echo "Invalid request.";
}
?>

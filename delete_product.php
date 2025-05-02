<?php
require 'db1.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die("Invalid product ID.");
}

try {
    $stmt = $pdo->prepare("DELETE FROM product WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: products.php?deleted=1");
    exit;
} catch (PDOException $e) {
    die("Error deleting product: " . $e->getMessage());
}

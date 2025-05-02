<?php
session_start();
include 'db1.php'; // Adjust the path to db1.php if needed

// Check if the product ID and quantity are set
if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];

    try {
        // Fetch product details from the database
        $stmt = $pdo->prepare("SELECT * FROM product WHERE product_id = ?");
        $stmt->execute([$product_id]);
        $product = $stmt->fetch();

        if ($product) {
            // Initialize cart session if not already set
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            // If product already exists in cart, update the quantity
            if (isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id]['quantity'] += $quantity;
            } else {
                // Add new product to the cart
                $_SESSION['cart'][$product_id] = [
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => $quantity,
                    'image_url' => $product['image'], // Assuming 'image' is the column name
                ];
            }

            // Redirect to cart page
            header('Location: cart.php');
            exit;
        } else {
            die("Product not found in database.");
        }

    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }

} else {
    die("Invalid request: Product ID or quantity missing.");
}
?>

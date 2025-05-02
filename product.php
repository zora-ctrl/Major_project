<?php
// product_details.php
include 'db1.php'; // Adjust the path if needed

// Validate product_id from URL
if (!isset($_GET['product_id']) || !is_numeric($_GET['product_id'])) {
    die("<h4 class='text-center text-danger mt-5'>Invalid product ID.</h4>");
}
$product_id = (int)$_GET['product_id'];

// Fetch product from database
try {
    $stmt = $pdo->prepare("SELECT * FROM product WHERE product_id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();

    if (!$product) {
        die("<h4 class='text-center text-danger mt-5'>Product not found.</h4>");
    }
} catch (PDOException $e) {
    die("<h4 class='text-center text-danger mt-5'>Error: " . $e->getMessage() . "</h4>");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($product['name']) ?> - Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .product-img {
            max-height: 400px;
            object-fit: cover;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <div class="row">
            <!-- Product Image -->
            <div class="col-md-6 text-center">
                <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="img-fluid product-img">
            </div>

            <!-- Product Info -->
            <div class="col-md-6">
                <h2><?= htmlspecialchars($product['name']) ?></h2>
                <p class="text-muted fs-5">₹<?= number_format($product['price'], 2) ?></p>
                <p><strong>Stock:</strong> <?= $product['stock'] > 0 ? $product['stock'] . " available" : "Out of Stock" ?></p>
                <p><strong>Category:</strong> <?= htmlspecialchars($product['category']) ?></p>
                <p class="mt-3"><?= nl2br(htmlspecialchars($product['description'])) ?></p>

                <?php if ($product['stock'] > 0): ?>
                <!-- Add to Cart Form -->
                <form action="add_to_cart.php" method="POST" class="mt-4">
                    <input type="hidden" name="product_id" value="<?= $product_id ?>">
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1" max="<?= $product['stock'] ?>" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Add to Cart</button>
                </form>
                <?php else: ?>
                    <div class="alert alert-warning mt-4">This product is currently out of stock.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <br><br><br><br><br><br>
    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

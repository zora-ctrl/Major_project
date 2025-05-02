<?php
// shop.php
include 'db.php'; // make sure this file connects to your database
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop by Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .product-card:hover {
            transform: scale(1.02);
            transition: 0.3s ease;
        }
        .product-img {
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Shop by Category</h2>

        <?php
        // Fetch unique categories
        $categoryQuery = "SELECT DISTINCT category FROM products";
        $categoryResult = mysqli_query($conn, $categoryQuery);

        while ($categoryRow = mysqli_fetch_assoc($categoryResult)) {
            $category = $categoryRow['category'];

            echo "<h4 class='mt-5 text-primary'>" . htmlspecialchars($category) . "</h4>";
            echo "<div class='row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4'>";

            // Fetch products in this category
            $productQuery = "SELECT * FROM products WHERE category = ?";
            $stmt = mysqli_prepare($conn, $productQuery);
            mysqli_stmt_bind_param($stmt, "s", $category);
            mysqli_stmt_execute($stmt);
            $productResult = mysqli_stmt_get_result($stmt);
            
            while ($product = mysqli_fetch_assoc($productResult)) {
                ?>
                <div class="col">
                    <div class="card h-100 product-card shadow-sm">
                        <img src="<?= htmlspecialchars($product['image']) ?>" class="card-img-top product-img" alt="<?= htmlspecialchars($product['name']) ?>">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                            <p class="card-text text-muted">₹<?= number_format($product['price'], 2) ?></p>
                        </div>
                    </div>
                </div>
                <?php
            }

            echo "</div>"; // Close row
        }
        ?>
    </div>

    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

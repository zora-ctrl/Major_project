<?php
include 'db1.php';
$category = "Cables";

// Fetch products
$stmt = $pdo->prepare("SELECT * FROM product WHERE category = ?");
$stmt->execute([$category]);
$products = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($category) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">  <style>
    .product-img { height: 200px; object-fit: cover; }
    .product-card:hover { transform: scale(1.02); transition: 0.3s ease; }
  </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container mt-5">
  <h2 class="text-center mb-4"><?= htmlspecialchars($category) ?></h2>

  <?php if ($products): ?>
    <div class="row row-cols-1 row-cols-md-3 g-4">
      <?php foreach ($products as $product): ?>
        <div class="col">
          <div class="card h-100 product-card shadow-sm">
            <img src="<?= htmlspecialchars($product['image_url']) ?>" class="card-img-top product-img" alt="<?= htmlspecialchars($product['name']) ?>">
            <div class="card-body text-center">
              <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
              <p class="text-muted">₹<?= number_format($product['price'], 2) ?></p>

              <!-- Add to Cart Form -->
              <form action="add_to_cart.php" method="POST" class="mt-2">
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <input type="hidden" name="quantity" value="1">
              </form>
              <a href='product.php?product_id=<?= htmlspecialchars($product["id"]) ?>' class='btn btn-primary'>Add to Cart</a>

            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <p class="text-center text-muted">No products available in this category.</p>
  <?php endif; ?>
</div>
<br><br><br><br>
<?php include 'footer.php'; ?>
</body>
</html>

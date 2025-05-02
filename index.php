<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
   <!-- Navbar -->
   <?php include 'navbar.php'; ?>
   <?php
require 'db1.php'; // Make sure this connects to your DB

// Fetch the latest products
$stmt = $pdo->query("SELECT * FROM product ORDER BY created_at DESC LIMIT 8"); // You can change the limit
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


    <!-- Carousel -->
   <div id="carouselExample" class="carousel slide custom-carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="https://plus.unsplash.com/premium_photo-1681488350342-19084ba8e224?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1yZWxhdGVkfDF8fHxlbnwwfHx8fHw%3D" width="300px" height="600px" class="d-block w-100" alt="First Slide">
    </div>
    <div class="carousel-item">
      <img src="../js/images/second.jpeg" class="d-block w-100" alt="Second Slide">
    </div>
    <div class="carousel-item">
      <img src="../js/images/third.jpeg" class="d-block w-100" alt="Third Slide">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<br><br>
    <header class="text-center py-1 bg-dark text-white">
        <h3>Products</h3>
    </header>
    <!-- Product Section -->
    <div class="container mt-5">
  <h4 class="text-center mb-4">Featured Products</h4>
  <div class="row">
    <?php if (!empty($products)): ?>
      <?php foreach ($products as $product): ?>
        <div class="col-md-3 mb-4">
          <div class="card h-100">
            <img src="<?= htmlspecialchars($product['image_url']) ?>" class="card-img-top" style="height: 250px; width: 250px object-fit: cover;" alt="<?= htmlspecialchars($product['name']) ?>">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
              <p class="card-text">Rs.<?= number_format($product['price'], 2) ?></p>
              <a href="product.php?product_id=<?= $product['product_id'] ?>" class="btn btn-primary mt-auto">Add to Cart</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-center">No products available.</p>
    <?php endif; ?>
  </div>
</div>

 <!-- Footer -->
<?php include 'footer.php'; ?>
</body>
</html>
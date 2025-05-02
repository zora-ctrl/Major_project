<?php
require 'db1.php'; // Database connection

// Fetch all products
try {
    $stmt = $pdo->query("SELECT * FROM product ORDER BY id DESC");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching products: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Products</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body>
<?php include "./navdash.php" ?>

  <div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2>Product List</h2>
      <a href="add_product.php" class="btn btn-success">+ Add Product</a>
    </div>

    <div class="table-responsive">
      <table class="table table-striped table-bordered">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price (Rs.)</th>
            <th>Stock</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
              <tr>
                <td><?= htmlspecialchars($product['id']) ?></td>
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td><?= htmlspecialchars($product['description']) ?></td>
                <td><?= number_format($product['price'], 2) ?></td>
                <td><?= htmlspecialchars($product['stock']) ?></td>
                <td>
                  <a href="edit_product.php?id=<?= $product['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                  <a href="delete_product.php?id=<?= $product['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="6" class="text-center">No products found.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
      <a href="dashboard.php" class="btn btn-primary">Back to Home</a>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <br>
  <?php include 'footer.php';?> 
</body>
</html>

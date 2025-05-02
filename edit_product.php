<?php
require 'db1.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die("Invalid product ID.");
}

$success = $error = "";

// Fetch product data
$stmt = $pdo->prepare("SELECT * FROM product WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Product not found.");
}

// Update product
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $category = $_POST['category'] ?? $product['category']; // fallback to existing
    $image_url = $product['image_url']; // fallback to existing

    if (!empty($_FILES['image']['name'])) {
        $upload_dir = "uploads/";
        $file_name = time() . "_" . basename($_FILES['image']['name']);
        $target_path = $upload_dir . $file_name;

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
            $image_url = $target_path;
        } else {
            $error = "Error uploading image.";
        }
    } elseif (!empty($_POST['image_url'])) {
        $image_url = trim($_POST['image_url']);
    }

    if ($name && $price > 0 && $stock >= 0 && !$error) {
        try {
            $update = $pdo->prepare("UPDATE product SET name=?, description=?, price=?, stock=?, image_url=?, category=? WHERE id=?");
            $update->execute([$name, $description, $price, $stock, $image_url, $category, $id]);
            $success = "Product updated successfully!";
            $stmt->execute([$id]); // Refresh product data
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $error = "Error updating product: " . $e->getMessage();
        }
    } elseif (!$error) {
        $error = "Please fill in all required fields correctly.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Edit Product</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body>
<?php include "./navdash.php" ?>

<div class="container mt-5">
  <h2>Edit Product</h2>

  <?php if ($success): ?>
    <div class="alert alert-success"><?= $success ?></div>
  <?php elseif ($error): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <form method="post" enctype="multipart/form-data" class="mt-3">
    <div class="mb-3">
      <label for="name" class="form-label">Product Name</label>
      <input type="text" class="form-control" name="name" id="name" value="<?= htmlspecialchars($product['name']) ?>" required />
    </div>
    <div class="mb-3">
      <label for="description" class="form-label">Description</label>
      <textarea class="form-control" name="description" id="description" rows="3"><?= htmlspecialchars($product['description']) ?></textarea>
    </div>
    <div class="mb-3">
      <label for="price" class="form-label">Price (Rs.)</label>
      <input type="number" class="form-control" name="price" id="price" step="0.01" value="<?= $product['price'] ?>" required />
    </div>
    <div class="mb-3">
      <label for="stock" class="form-label">Stock Quantity</label>
      <input type="number" class="form-control" name="stock" id="stock" value="<?= $product['stock'] ?>" required />
    </div>

    <!-- ✅ Category Dropdown (preserving selected value) -->
    <div class="mb-3">
      <label for="category" class="form-label">Product Category</label>
      <select class="form-select" name="category" id="category" required>
        <?php
        $categories = ['Phone Cases', 'Cables', 'Chargers', 'Audio Accessories'];
        foreach ($categories as $cat) {
            $selected = $product['category'] === $cat ? 'selected' : '';
            echo "<option value=\"$cat\" $selected>$cat</option>";
        }
        ?>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Current Image</label><br/>
      <img src="<?= htmlspecialchars($product['image_url']) ?>" class="img-thumbnail" style="max-width: 200px;" alt="Product Image">
    </div>
    <div class="mb-3">
      <label for="image" class="form-label">Upload New Image (optional)</label>
      <input type="file" class="form-control" name="image" id="image" accept="image/*" />
    </div>
    <div class="mb-3">
      <label for="image_url" class="form-label">Or Image URL</label>
      <input type="url" class="form-control" name="image_url" id="image_url" placeholder="https://example.com/image.jpg" />
    </div>
    <button type="submit" class="btn btn-primary">Update Product</button>
    <a href="products.php" class="btn btn-secondary">Back</a>
  </form>
</div>
</body>
</html>

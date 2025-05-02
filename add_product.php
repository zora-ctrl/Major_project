<?php
require 'db1.php'; // database connection

$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $category = $_POST['category'] ?? 'Phone Cases'; // Get selected category or default
    $image_url = "";

    // Handle file upload if available
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "uploads/";
        $image_name = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . time() . "_" . $image_name;

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_url = $target_file;
        } else {
            $error = "Error uploading image.";
        }
    } elseif (!empty($_POST['image_url'])) {
        // Use image URL if no file uploaded
        $image_url = trim($_POST['image_url']);
    }

    if ($name && $price > 0 && $stock >= 0 && !$error) {
        try {
            $stmt = $pdo->prepare("INSERT INTO product (name, description, price, stock, image_url, category) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $description, $price, $stock, $image_url, $category]);
            $success = "Product added successfully!";
        } catch (PDOException $e) {
            $error = "Error adding product: " . $e->getMessage();
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
  <title>Add Product</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body>
<?php include "./navdash.php" ?>

<div class="container mt-5">
    <h2>Add New Product</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" class="mt-3">
        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" class="form-control" name="name" id="name" required />
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" name="description" id="description" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price (Rs.)</label>
            <input type="number" class="form-control" name="price" id="price" step="0.01" required />
        </div>
        <div class="mb-3">
            <label for="stock" class="form-label">Stock Quantity</label>
            <input type="number" class="form-control" name="stock" id="stock" required />
        </div>

        <!-- ✅ Category dropdown -->
        <div class="mb-3">
            <label for="category" class="form-label">Product Category</label>
            <select class="form-select" name="category" id="category" required>
                <option value="Phone Cases">Phone Cases</option>
                <option value="Cables">Cables</option>
                <option value="Chargers">Chargers</option>
                <option value="Audio Accessories">Audio Accessories</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Upload Product Image</label>
            <input type="file" class="form-control" name="image" id="image" accept="image/*" />
            <small class="text-muted">Or enter an image URL below</small>
        </div>
        <div class="mb-3">
            <label for="image_url" class="form-label">Image URL</label>
            <input type="url" class="form-control" name="image_url" id="image_url" placeholder="https://example.com/image.jpg" />
        </div>
        <button type="submit" class="btn btn-success">Add Product</button>
        <a href="products.php" class="btn btn-secondary">Back</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<br>
<?php include 'footer.php';?>
</body>
</html>

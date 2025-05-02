<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($category) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h2 class="text-center"><?= htmlspecialchars($category) ?></h2>
        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4 mt-4">
            <?php foreach ($products as $product): ?>
                <div class='col'>
                    <div class='card shadow-sm h-100'>
                        <img src='<?= htmlspecialchars($product["image"]) ?>' class='card-img-top' alt='<?= htmlspecialchars($product["title"]) ?>'>
                        <div class='card-body text-center'>
                            <h5 class='card-title'><?= htmlspecialchars($product["title"]) ?></h5>
                            <p class='card-text fw-bold text-success'><?= htmlspecialchars($product["price"]) ?></p>
                            <a href='product.php?product_id=<?= htmlspecialchars($product["id"]) ?>' class='btn btn-primary'>Add to Cart</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>

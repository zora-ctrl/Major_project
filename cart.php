<?php
session_start();


// Step 1: Connect to the MySQL database
$host = "localhost";    // Change to your database host
$dbname = "av";  // Change to your database name
$username = "root";     // Change to your database username
$password = "";     // Change to your database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Step 2: Check if the cart exists or is empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Your cart is empty. Please add items to your cart.";
    exit;
}

// Step 3: Update the cart quantities if the form is submitted
if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantities'] as $product_id => $quantity) {
        if (isset($_SESSION['cart'][$product_id])) {
            // Update the quantity only if it's greater than 0
            if ($quantity > 0) {
                $_SESSION['cart'][$product_id]['quantity'] = $quantity;
            } else {
                // Remove product if the quantity is set to 0
                unset($_SESSION['cart'][$product_id]);
            }
        }
    }
    header("Location: cart.php"); // Redirect to avoid form resubmission issue
    exit;
}

// Step 4: Remove a product from the cart
if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
        header("Location: cart.php"); // Redirect to refresh the cart page
        exit;
    }
}

// Step 5: Fetch product details from the database
$product_id = array_keys($_SESSION['cart']); // Get all product IDs in the cart

if (empty($product_id)) {
    echo "Your cart is empty.";
    exit;
}

$placeholders = rtrim(str_repeat('?,', count($product_id)), ','); // Create placeholders for SQL IN clause
$sql = "SELECT product_id, name, price FROM product WHERE id IN ($placeholders)";
$stmt = $pdo->prepare($sql);
$stmt->execute($product_id);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Step 6: Recalculate total amount based on fetched product details
$total_amount = 0;
$updated_cart = [];

foreach ($products as $product) {
    $product_id = $product['product_id'];
    $quantity = $_SESSION['cart'][$product_id]['quantity'];
    $total_amount += $product['price'] * $quantity;

    // Update session cart with fresh product details
    $updated_cart[$product_id] = [
        'name' => $product['name'],
        'price' => $product['price'],
        'quantity' => $quantity
    ];
}

$_SESSION['cart'] = $updated_cart; // Refresh cart with updated details

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Your Cart</title>
</head>
<body>
<?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <h1>Your Cart</h1>

        <form action="cart.php" method="POST">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_SESSION['cart'] as $product_id => $product): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td>Rs. <?php echo number_format($product['price'], 2); ?></td>
                        <td>
                            <!-- Quantity input field to allow updates -->
                            <input type="number" name="quantities[<?php echo $product_id; ?>]"
                             value="<?php echo $product['quantity']; ?>"
                             min="1" class="form-control" style="width: 80px;">
                        </td>
                        <td>Rs. <?php echo number_format($product['price'] * $product['quantity'], 2); ?></td>
                        <td>
                            <!-- Remove product link -->
                            <a href="cart.php?action=remove&product_id=<?php echo $product_id; ?>" 
                            class="btn btn-danger btn-sm">Remove</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <h4>Total Amount: Rs. <?php echo number_format($total_amount, 2); ?></h4>

            <!-- Update Cart button -->
            <button type="submit" name="update_cart" class="btn btn-primary">Update Cart</button>

            <!-- Proceed to Confirm Order -->
            <a href="confirm_order.php" class="btn btn-success">Proceed to Checkout</a>

            <!-- Continue Shopping -->
            <a href="index.php" class="btn btn-secondary mt-3">Continue Shopping</a>
        </form>
    </div><br><br><br><br><br><br><br><br><br>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <br>
    <?php include 'footer.php'; ?>
</body>
</html>

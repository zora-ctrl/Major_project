<?php
session_start();

// Check if the total amount is set
if (!isset($_POST['total_amount'])) {
    echo "Invalid payment request.";
    exit;
}

$total_amount = $_POST['total_amount'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Payment</title>
</head>
<body>
<?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <h1>Payment Options</h1>
        <p>Total Amount: Rs. <?php echo number_format($total_amount, 2); ?></p>

        <!-- UPI Payment Option -->
        <h4>Pay via UPI</h4>
        <form action="confirm_payment.php" method="POST">
            <input type="hidden" name="total_amount" value="<?php echo $total_amount; ?>">
            <input type="hidden" name="payment_method" value="upi">
            <div class="form-group">
                <label for="upi_id">Enter your UPI ID:</label>
                <input type="text" name="upi_id" id="upi_id" class="form-control" required placeholder="e.g., yourname@upi">
            </div>

            <!-- Choose UPI payment gateway -->
            <div class="form-group">
                <label for="upi_gateway">Choose UPI Gateway:</label>
                <select name="upi_gateway" id="upi_gateway" class="form-control" required>
                    <option value="paytm">Paytm UPI</option>
                    <option value="google_pay">Google Pay</option>
                    <option value="phonepe">PhonePe</option>
                    <option value="bhim_upi">BHIM UPI</option>
                    <option value="amazon_pay">Amazon Pay UPI</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Confirm UPI Payment</button>
        </form>

        <a href="index.php" class="btn btn-secondary mt-3">Back to Shopping</a>
    </div><br><br><br><br>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <?php include 'footer.php'; ?>
</body>
</html>

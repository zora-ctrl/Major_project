<?php
session_start();
include 'navbar.php';
if (!isset($_POST['total_amount']) || !isset($_POST['upi_id']) || !isset($_POST['upi_gateway'])) {
    echo "Invalid payment request.";
    exit;
}

$total_amount = $_POST['total_amount'];
$upi_id = $_POST['upi_id'];
$upi_gateway = $_POST['upi_gateway'];

// Here, you can process the payment with the selected gateway (dummy process in this example)
$payment_status = "success"; // Assume success for now (you can integrate real payment gateways)

if ($payment_status == "success") {
    echo "Payment successful using " . htmlspecialchars($upi_gateway) . "!<br>";
    echo "UPI ID: " . htmlspecialchars($upi_id) . "<br>";
    echo "Total Amount Paid: Rs. " . number_format($total_amount, 2);

    // Clear the cart after successful payment
    unset($_SESSION['cart']);
} else {
    echo "Payment failed. Please try again.";
}
?>

<br><a href="index.php" class="btn btn-secondary mt-3">Back to Shopping</a><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<?php include 'footer.php'; ?>

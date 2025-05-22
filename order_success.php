<?php
session_start();
require 'db1.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$customer_email = $_SESSION['user_email'] ?? '';
$customer_name = $_SESSION['user_name'] ?? '';
$admin_email = 'admin@example.com'; // Change this to your admin email

// ✅ Get order_id from URL or DB
$order_id = $_GET['order_id'] ?? '';

if (empty($order_id) && !empty($customer_email)) {
    // Fetch latest order_id for this customer from DB
    $stmt = $pdo->prepare("SELECT order_id FROM order_customers WHERE email = ? ORDER BY order_id DESC LIMIT 1");
    $stmt->execute([$customer_email]);
    $order = $stmt->fetch();
    $order_id = $order['order_id'] ?? '';
}

// === Compose email content ===
$subject = "Order Confirmation - $order_id";
$body = "
<h2>Order Confirmation</h2>
<p>Thank you, <strong>$customer_name</strong>, for your order.</p>
<p><strong>Order ID:</strong> $order_id</p>
<p>We will process your order shortly.</p>
<br>
<p>Regards,<br>Mobile Cart Team</p>
";

// === Send Email Using PHPMailer ===
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;

    // ✅ Replace with your real email and app password
    $mail->Username   = 'zs693038@gmail.com';
    $mail->Password   = 'vjkv gzfd yphe rpah';

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('zs693038@gmail.com', 'Mobile Cart');
    $mail->addAddress($customer_email, $customer_name);
    $mail->addAddress($admin_email, 'Admin');

    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = $body;

    $mail->send();
    $email_status = "<div class='alert alert-success'>✅ Confirmation email sent.</div>";
} catch (Exception $e) {
    $email_status = "<div class='alert alert-danger'>❌ Email could not be sent. Mailer Error: {$mail->ErrorInfo}</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Success</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container text-center mt-5">
  <h1 class="text-success">🎉 Order Placed Successfully!</h1>
  <p><strong>Order ID: <?= htmlspecialchars($order_id) ?></strong></p>
  <?= $email_status ?>
  <a href="index.php" class="btn btn-primary mt-3">Continue Shopping</a>
</div>
<br><br><br><br><br><br><br><br><br><br>
<?php include 'footer.php'; ?>
</body>
</html>

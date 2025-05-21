<?php
// PHPMailer classes must be loaded at the top
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';

// Now you can include other PHP files
include 'navbar.php';

// Collect form data
$name = $_POST['name'];
$mail = $_POST['email'];
$sub = $_POST['subject'];
$msg = $_POST['message'];

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "av";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Insert into database
$sql = "INSERT INTO contact_us(name, mail, sub, msg) VALUES('$name', '$mail', '$sub', '$msg')";

if (mysqli_query($conn, $sql)) {
    $mailer = new PHPMailer(true);

    try {
        // SMTP Settings
        $mailer->isSMTP();
        $mailer->Host = 'smtp.gmail.com';
        $mailer->SMTPAuth = true;
        $mailer->Username = 'zs693038@gmail.com';         // Replace
        $mailer->Password = 'vjkv gzfd yphe rpah';           // Replace
        $mailer->SMTPSecure = 'tls';
        $mailer->Port = 587;

        // Email content
        $mailer->setFrom('zs693038@gmail.com', 'Mobile Cart Website');
        $mailer->addAddress('www.jorasingh217@gmail.com', 'Admin'); // Or test with your Gmail

        $mailer->isHTML(true);
        $mailer->Subject = "New Contact Form Message: $sub";
        $mailer->Body = "
            <h3>New message received from Mobile Cart:</h3>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $mail</p>
            <p><strong>Subject:</strong> $sub</p>
            <p><strong>Message:</strong><br>$msg</p>
        ";

        $mailer->send();
        echo "<script>alert('Message sent and saved successfully!'); window.location.href='contact.php';</script>";

    } catch (Exception $e) {
        echo "<script>alert('Message saved, but email failed. Mailer Error: {$mailer->ErrorInfo}'); window.location.href='contact.php';</script>";
    }

} else {
    echo "<script>alert('Error saving message.'); window.history.back();</script>";
}

mysqli_close($conn);
?>

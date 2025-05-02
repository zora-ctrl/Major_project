<?php
include 'navdash.php'; // Navbar (custom file)

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "av";

// Connect to database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch records
$sql = "SELECT * FROM contact_us";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Contact Messages</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optional: Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Contact Messages</h2>

    <?php
    if ($result->num_rows > 0) {
        echo "<div class='table-responsive'>";
        echo "<table class='table table-bordered table-striped align-middle'>";
        echo "<thead class='table-dark'>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Action</th>
                </tr>
              </thead>
              <tbody>";

        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>".htmlspecialchars($row['id'])."</td>
                    <td>".htmlspecialchars($row['name'])."</td>
                    <td>".htmlspecialchars($row['mail'])."</td>
                    <td>".htmlspecialchars($row['sub'])."</td>
                    <td>".htmlspecialchars($row['msg'])."</td>
                    <td>
                        <form method='POST' action='delete.php' onsubmit=\"return confirm('Are you sure you want to delete this message?');\">
                            <input type='hidden' name='id' value='".htmlspecialchars($row['id'])."'>
                            <button type='submit' class='btn btn-sm btn-danger'>
                                <i class='fas fa-trash-alt'></i> Delete
                            </button>
                        </form>
                    </td>
                  </tr>";
        }

        echo "</tbody></table>";
        echo "</div>";
    } else {
        echo "<div class='alert alert-info'>No messages found.</div>";
    }

    $conn->close();
    ?>
</div>



<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<br><br><br><br><br><br><br><br><br><br><br><br><br>
<!-- Footer -->
<?php include 'footer.php'; ?>
</body>
</html>

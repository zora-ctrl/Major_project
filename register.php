<?php
include 'navbar.php';
require 'db2.php';

$message = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $username = trim($_POST['new_username']);
  $password = trim($_POST['new_password']);

  if (!empty($username) && !empty($password)) {
    // Check if username already exists
    $check = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $check->execute([$username]);

    if ($check->rowCount() > 0) {
      $error = "Username already taken. Please choose another.";
    } else {
      // Hash and insert new user
      $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
      $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
      if ($stmt->execute([$username, $hashedPassword])) {
        $message = "Registration successful. You can now <a href='login.php' class='alert-link'>login</a>.";
      } else {
        $error = "Registration failed. Please try again.";
      }
    }
  } else {
    $error = "Please fill in all fields.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    body {
      background-color: #f8f9fa;
    }
    .register-card {
      max-width: 400px;
      margin: 10vh auto;
      padding: 2rem;
      border-radius: 10px;
      background-color: #ffffff;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>
<body>

<div class="container">
  <div class="register-card">
    <h3 class="text-center mb-4">Create Account</h3>

    <?php if (!empty($message)): ?>
      <div class="alert alert-success"><?= $message ?></div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" novalidate>
      <div class="mb-3">
        <label for="new_username" class="form-label">Username</label>
        <input type="text" class="form-control" id="new_username" name="new_username" required>
      </div>
      <div class="mb-3">
        <label for="new_password" class="form-label">Password</label>
        <input type="password" class="form-control" id="new_password" name="new_password" required>
      </div>
      <div class="d-grid">
        <button type="submit" class="btn btn-success">Register</button>
      </div>
    </form>

    <div class="text-center mt-3">
      <small>Already have an account? <a href="login.php">Login here</a></small>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php include 'footer.php';?>
</body>
</html>

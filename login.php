<?php
session_start();
include 'navbar.php';
include 'db2.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // Assuming passwords are hashed
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid username or password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    body {
      background-color: #f8f9fa;
    }
    .login-card {
      max-width: 400px;
      margin: auto;
      margin-top: 10vh;
      padding: 2rem;
      border-radius: 10px;
      background-color: #ffffff;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
  </style>
  <title>Document</title>
</head>
<body>
<div class="container">
  <div class="login-card">
    <h3 class="text-center mb-4">Admin Login</h3>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input 
          type="text" 
          class="form-control" 
          id="username" 
          name="username" 
          placeholder="Enter your username" 
          required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input 
          type="password" 
          class="form-control" 
          id="password" 
          name="password" 
          placeholder="Enter your password" 
          required>
      </div>
      <div class="d-grid">
        <button type="submit" class="btn btn-primary">Login</button>
      </div>
    </form>
    Don't have an account?<a href="register.php"> Register here</a>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<br><br><br>
<?php include 'footer.php'; ?>
</body>
</html>

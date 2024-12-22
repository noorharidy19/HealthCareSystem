<?php
require_once(__DIR__ . '/../controllers/UserController.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    UserController::log();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Responsive Login Form HTML CSS | CodingNepal</title>
  <link rel="stylesheet" href="../assets/css/login.css" />
  <!-- Font Awesome CDN link for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
</head>
<body>
  <div class="container">
    <!-- Left Side Login Form -->
    <div class="wrapper">
    <div class="title-container">
    <span class="title">Welcome Back</span>
    </div>

   <!-- PHP will display error message here if credentials are incorrect -->
  
    <form id="loginForm" action=""method="POST">
        <div class="row">
            <input type="text" name="loginEmailOrPhone" placeholder="Email or Phone" required>
        </div>
        <div class="row">
            <input type="password" name="loginPassword" placeholder="Password" required>
        </div>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($_SESSION['error']); ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        <div class="row button">
            <input type="submit" value="Login">
        </div>
    </form>
</div>

    <!-- Right Side Sign-Up Prompt -->
    <div class="signup-prompt">
      <h2>New Here?</h2>
      <h4>Register now and take advantage of our benifits</h4>
      <p><a href="signup.php">Sign up now</a></p>
    </div>
  </div>
  <script src="../assets/js/login.js"></script>

  



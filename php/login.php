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
   <?php
      session_start();
      if (isset($_SESSION['error'])) {
          echo "<div class='error-message'>" . htmlspecialchars($_SESSION['error']) . "</div>";
          unset($_SESSION['error']); // Clear the error after displaying it
      }
      ?>

      <form id="loginForm" action="" method="POST">
        <div class="row">
          <i class="fas fa-user"></i>
          <input type="text" id="loginEmailOrPhone" name="loginEmailOrPhone" placeholder="Email or Phone" />
        </div>
        <small class="error-message hidden" id="loginEmailOrPhoneError"></small>
        <div class="row">
          <i class="fas fa-lock"></i>
          <input type="password" id="loginPassword" name="loginPassword" placeholder="Password" />
        </div>
        <small class="error-message hidden" id="loginPasswordError"></small>
        <!-- Session error message placed directly under password field -->
    <?php if (isset($_SESSION['error'])): ?>
        <small class="error-message session-error"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></small>
    <?php endif; ?>

        
        <div class="pass"><a href="#">Forgot password?</a></div>
        <div class="row button">
          <input type="submit" value="Login" />
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


  <?php
  include 'DB.php'; // Include your database connection file

  

  // Check if form is submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Retrieve the form inputs
      $emailOrPhone = $_POST['loginEmailOrPhone'];
      $password = $_POST['loginPassword'];

      // Prepare a SQL statement to prevent SQL injection
      $stmt = $conn->prepare("SELECT * FROM users WHERE (email = ? OR phone = ?) LIMIT 1");
      $stmt->bind_param("ss", $emailOrPhone, $emailOrPhone);
      $stmt->execute();
      $result = $stmt->get_result();

      // Check if a user record was found
      if ($result->num_rows > 0) {
          $user = $result->fetch_assoc();

         // Verify the password
        if (password_verify($password, $user['Password'])) { // Assuming passwords are hashed
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['Email'] = $user['Email'];
            $_SESSION['UserType'] = $user['UserType']; // Store userType in session

            // Check userType for redirection
            if ($user['UserType'] === 'Admin') {
                header("Location: admin.php"); // Redirect to admin dashboard
            } else if ($user['UserType'] === 'Doctor') {
                header("Location: Doctor.php"); // Redirect to user dashboard
            }
            else {
                header("Location: index.php"); // Redirect to user dashboard
            }
            exit();
        } else {
            $_SESSION['error'] = "Invalid email/phone or password.";
        }
    } else {
        $_SESSION['error'] = "User not found.";
    }


      $stmt->close();
      $conn->close();
  }
  ?>


<!-- Display error message if exists -->
<?php
if (isset($_SESSION['error'])) {
    echo "<div class='error-message'>" . htmlspecialchars($_SESSION['error']) . "</div>";
    unset($_SESSION['error']);
}
?>




</body>
</html>
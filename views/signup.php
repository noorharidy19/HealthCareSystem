<?php
require_once(__DIR__ . '/../controllers/PatientController.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    PatientController::create();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Add New Patient</title>

  <link rel="stylesheet" href="../assets/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/css/theme.css">
  <link rel="stylesheet" href="../assets/css/signup.css">
</head>
<body>

<div class="container form-container">
    <h2 class="form-header">Register</h2>

     <?php
       // Display error message if it exists
       if (isset($_SESSION['error'])) {
        echo "<div class='error'>" . htmlspecialchars($_SESSION['error']) . "</div>";
        unset($_SESSION['error']); // Clear the error after displaying it
      }
    ?>

    <form id="userForm" action="" method="POST" onsubmit="return validateForm()">
      
      <!-- Patient Name -->
      <div class="form-group">
        <label for="name">
        <img src="..\assets\img\icons\person.png" alt="person Icon" style="width: 20px; vertical-align: middle; margin-right: 5px;"> 
        Name
        </label>
        <input type="text" name="name" id="name" class="form-control">
        <small class="error-message" id="nameError"></small>
      </div>

      <!-- Patient Email -->
      <div class="form-group">
        <label for="email">
        <img src="..\assets\img\icons\email.png" alt="person Icon" style="width: 20px; vertical-align: middle; margin-right: 5px;">
        Email Address</label>
        <input type="text" name="email" id="email" class="form-control" >
        <small class="error-message" id="emailError"></small>
      </div>


     <!-- Password -->
<div class="form-group">
    <label for="password">
    <img src="..\assets\img\icons\password.png" alt="person Icon" style="width: 20px; vertical-align: middle; margin-right: 5px;">
    Password</label>
    <input type="password" name="password" id="password" class="form-control">
    <small class="error-message" id="passwordError"></small>
</div>

<!-- Confirm Password -->
<div class="form-group">
    <label for="confirmPassword">
    <img src="..\assets\img\icons\password.png" alt="person Icon" style="width: 20px; vertical-align: middle; margin-right: 5px;">  
    Confirm Password</label>
    <input type="password" name="confirmPassword" id="confirmPassword" class="form-control">
    <small class="error-message" id="confirmPasswordError"></small>
</div>

      <!-- Phone Number -->
      <div class="form-group">
        <label for="phone">
        <img src="..\assets\img\icons\phone.png" alt="person Icon" style="width: 20px; vertical-align: middle; margin-right: 5px;">  
        Phone Number</label>
        <input type="tel" name="phone" id="phone" class="form-control" >
        <small class="error-message" id="phoneError"></small>
      </div>

      <!-- Gender -->
      <div class="form-group">
      <label for="gender">
      <img src="..\assets\img\icons\gender.png" alt="person Icon" style="width: 20px; vertical-align: middle; margin-right: 5px;">  
      Gender</label>
    <div>
        <input type="radio" id="male" name="gender" value="Male" style="display: inline-block; margin-right: 5px;">
        <label for="male" style="display: inline-block; margin-right: 20px;">Male</label>

        <input type="radio" id="female" name="gender" value="Female" style="display: inline-block; margin-right: 5px;">
        <label for="female" style="display: inline-block;">Female</label>
    </div>
    <small class="error-message" id="genderError"></small>
</div>

      <!-- Date of Birth -->
      <div class="form-group">
        <label for="dob">
        <img src="..\assets\img\icons\calendar.png" alt="person Icon" style="width: 20px; vertical-align: middle; margin-right: 5px;"> 
        Date of Birth</label>
        <input type="date" name="dob" id="dob" class="form-control" >
        <small class="error-message" id="dobError"></small>
      </div>

      <!-- Address -->
      <div class="form-group">
        <label for="address">
        <img src="..\assets\img\icons\address.png" alt="person Icon" style="width: 20px; vertical-align: middle; margin-right: 5px;">  
        Address</label>
        <textarea name="address" id="address" class="form-control" rows="3" ></textarea>
        <small class="error-message" id="addressError"></small>
      </div>

    

      <!-- Submit Button -->
      <div class="btn-container">
        <a href="index.php" class="btn btn-secondary btn-back">Back</a>
        <button type="submit" class="btn btn-primary" href="index.php">Sign Up</button>
      </div>
    </form>
  </div>

  <div class="already-account">
  <p>Already have an account? <a href="login.php">Log in</a></p>
</div>


  <script src="../assets/js/jquery-3.5.1.min.js"></script>
  <script src="../assets/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/signup.js"></script>


  



</body>
</html>

<?php
require_once(__DIR__ . '/../controllers/AdminController.php');

$controller = new AdminController();
$controller->add();
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
  <link rel="stylesheet" href="../assets/css/adduser.css">
</head>
<body>

<div class="container form-container">
  <br>
    <h2 class="form-header">Add User</h2>
    <form id="userForm" action="Adduser.php" method="POST" onsubmit="return validateForm()">
      <!-- User Type Selection -->
      <div class="form-group">
        <label for="userType">
          <img src="../assets/img/icons/person.png" alt="person Icon" style="width: 20px; vertical-align: middle; margin-right: 5px;">   
          |
          <img src="../assets/img/icons/doctor2.png" alt="person Icon" style="width: 20px; vertical-align: middle; margin-right: 5px;"> 
          <br>
          User Type
        </label>
        <div>
          <input type="radio" id="patient" name="userType" value="Patient" onclick="toggleDoctorField()" style="display: inline-block; margin-right: 5px;">
          <label for="patient" style="display: inline-block; margin-right: 20px;">Patient</label>
          <input type="radio" id="doctor" name="userType" value="Doctor" onclick="toggleDoctorField()" style="display: inline-block; margin-right: 5px;">
          <label for="doctor" style="display: inline-block;">Doctor</label>
        </div>
        <small class="error-message" id="userTypeError"></small>
      </div>

      <!-- Patient Name -->
      <div class="form-group">
        <label for="name">
          <img src="../assets/img/icons/person.png" alt="person Icon" style="width: 20px; vertical-align: middle; margin-right: 5px;"> 
          Name
        </label>
        <input type="text" name="name" id="name" class="form-control">
        <small class="error-message" id="nameError"></small>
      </div>

      <!-- Patient Email -->
      <div class="form-group">
        <label for="email">
          <img src="../assets/img/icons/email.png" alt="person Icon" style="width: 20px; vertical-align: middle; margin-right: 5px;">
          Email Address
        </label>
        <input type="email" name="email" id="email" class="form-control">
        <small class="error-message" id="emailError"></small>
      </div>

      <!-- Phone Number -->
      <div class="form-group">
        <label for="phone">
          <img src="../assets/img/icons/phone.png" alt="person Icon" style="width: 20px; vertical-align: middle; margin-right: 5px;">  
          Phone Number
        </label>
        <input type="tel" name="phone" id="phone" class="form-control">
        <small class="error-message" id="phoneError"></small>
      </div>

      <!-- Password -->
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="form-control">
        <small class="error-message" id="passwordError"></small>
      </div>

      <!-- Gender -->
      <div class="form-group">
        <label for="gender">
          <img src="../assets/img/icons/gender.png" alt="person Icon" style="width: 20px; vertical-align: middle; margin-right: 5px;">  
          Gender
        </label>
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
          <img src="../assets/img/icons/calendar.png" alt="person Icon" style="width: 20px; vertical-align: middle; margin-right: 5px;"> 
          Date of Birth
        </label>
        <input type="date" name="dob" id="dob" class="form-control">
        <small class="error-message" id="dobError"></small>
      </div>

      <!-- Address -->
      <div class="form-group">
        <label for="address">
          <img src="../assets/img/icons/address.png" alt="person Icon" style="width: 20px; vertical-align: middle; margin-right: 5px;">  
          Address
        </label>
        <textarea name="address" id="address" class="form-control" rows="3"></textarea>
        <small class="error-message" id="addressError"></small>
      </div>
      <!-- Submit Button -->
      <div class="btn-container">
        <a href="admin.php" class="btn btn-back">Dashboard</a>
        <button type="submit" class="btn btn-primary">Add User</button>
      </div>
    </form>
  </div>

  <script src="../assets/js/jquery-3.5.1.min.js"></script>
  <script src="../assets/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/adduser.js"></script>
</body>
</html>
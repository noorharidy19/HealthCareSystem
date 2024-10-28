<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Edit User</title>

  <link rel="stylesheet" href="../assets/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/css/theme.css">
  <link rel="stylesheet" href="../assets/css/adduser.css">
</head>
<body>

<div class="container form-container">
  <br>
    <h2 class="form-header">Edit User</h2>
    <?php
    include 'DB.php';
    include_once 'Classes.php'; 

    // Fetch user details if ID is provided
    if (isset($_GET['id'])) {
        $ID = $_GET['id'];
        $user = new User($ID);
    } else {
        echo "<p>No user ID provided.</p>";
        exit;
    }
    ?>
    <form id="userForm" action="" method="POST" onsubmit="return validateFormedit()">

      <!-- Hidden Input for User ID -->
      <input type="hidden" name="id" value="<?php echo $user->ID; ?>">

      <!-- Patient Name -->
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" class="form-control" value="<?php echo $user->name; ?>">
        <small class="error-message" id="nameError"></small>
      </div>

      <!-- Patient Email -->
      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" name="email" id="email" class="form-control" value="<?php echo $user->email; ?>">
        <small class="error-message" id="emailError"></small>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="form-control" value="<?php echo $user->password; ?>">
        <small class="error-message" id="passwordError"></small>
      </div>

      <!-- Phone Number -->
      <div class="form-group">
        <label for="phone">Phone Number</label>
        <input type="tel" name="phone" id="phone" class="form-control" value="<?php echo $user->phone; ?>">
        <small class="error-message" id="phoneError"></small>
      </div>

      <!-- Date of Birth -->
      <div class="form-group">
        <label for="dob">Date of Birth</label>
        <input type="date" name="dob" id="dob" class="form-control" value="<?php echo $user->DOb; ?>">
        <small class="error-message" id="dobError"></small>
      </div>

      <!-- Address -->
      <div class="form-group">
        <label for="address">Address</label>
        <textarea name="address" id="address" class="form-control" rows="3"><?php echo $user->address; ?></textarea>
        <small class="error-message" id="addressError"></small>
      </div>

      <!-- Gender -->
      <div class="form-group">
        <label for="gender">Gender</label>
        <select name="gender" id="gender" class="form-control">
          <option value="male" <?php echo ($user->gender == 'male') ? 'selected' : ''; ?>>Male</option>
          <option value="female" <?php echo ($user->gender == 'female') ? 'selected' : ''; ?>>Female</option>
          <option value="other" <?php echo ($user->gender == 'other') ? 'selected' : ''; ?>>Other</option>
        </select>
        <small class="error-message" id="genderError"></small>
      </div>

      <!-- Submit Button -->
      <div class="btn-container">
        <a href="admin.php" class="btn btn-back">Dashboard</a>
        <button type="submit" class="btn btn-primary">Edit User</button>
      </div>
    </form>
  </div>

  <?php

include 'DB.php';
include_once 'Classes.php'; 

  if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Check if form was submitted
    $ID = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];

    if (User::editUser($name, $email, $password, $phone, $address, $dob, $gender, $ID)) {
        header("Location: index.php");
    } else {
        echo "<p>Error updating user.</p>";
    }
  }
  ?>

  <script src="../assets/js/jquery-3.5.1.min.js"></script>
  <script src="../assets/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/adduser.js"></script>
</body>
</html>
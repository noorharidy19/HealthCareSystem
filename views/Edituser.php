<?php
require_once(__DIR__ . '/../controllers/AdminController.php');

$controller = new AdminController();
$user=$controller->edit();
?> 
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
       
        <h2 class="form-header">Edit User</h2>
        <form id="userForm" action="" method="POST" onsubmit="return validateFormedit()">

            <!-- Hidden Input for User ID -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($user->getID()); ?>">

            <!-- Patient Name -->
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="<?php echo htmlspecialchars($user->getName()); ?>">
                <small class="error-message" id="nameError"></small>
            </div>
            <div class="from-group">
          <input type="radio" id="male" name="gender" value="Male" style="display: inline-block; margin-right: 5px;">
          <label for="male" style="display: inline-block; margin-right: 20px;">Male</label>
          <input type="radio" id="female" name="gender" value="Female" style="display: inline-block; margin-right: 5px;">
          <label for="female" style="display: inline-block;">Female</label>
       
        <small class="error-message" id="genderError"></small>
      </div>


            <!-- Patient Email -->
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($user->getEmail()); ?>">
                <small class="error-message" id="emailError"></small>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" value="<?php echo htmlspecialchars($user->getPassword()); ?>">
                <small class="error-message" id="passwordError"></small>
            </div>

            <!-- Phone Number -->
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" name="phone" id="phone" class="form-control" value="<?php echo htmlspecialchars($user->getPhone()); ?>">
                <small class="error-message" id="phoneError"></small>
            </div>

            <!-- Date of Birth -->
            <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="date" name="dob" id="dob" class="form-control" value="<?php echo htmlspecialchars($user->getDOb()); ?>">
                <small class="error-message" id="dobError"></small>
            </div>

            <!-- Address -->
            <div class="form-group">
                <label for="address">Address</label>
                <textarea name="address" id="address" class="form-control" rows="3"><?php echo htmlspecialchars($user->getAddress()); ?></textarea>
                <small class="error-message" id="addressError"></small>
            </div>

            <!-- Submit Button -->
            <div class="btn-container">
                <a href="admin.php" class="btn btn-back">Dashboard</a>
                <button type="submit" class="btn btn-primary">Edit User</button>
            </div>
        </form>
    </div>


  <script src="../assets/js/jquery-3.5.1.min.js"></script>
  <script src="../assets/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/adduser.js"></script>
</body>
</html>

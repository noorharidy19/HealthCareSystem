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
    <form id="userForm" action="update-user.php" method="POST" onsubmit="return validateFormedit()">

      <!-- Patient Name -->
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" class="form-control">
        <small class="error-message" id="nameError"></small>
      </div>

      <!-- Patient Email -->
      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" name="email" id="email" class="form-control">
        <small class="error-message" id="emailError"></small>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="form-control">
        <small class="error-message" id="passwordError"></small>

      <!-- Phone Number -->
      <div class="form-group">
        <label for="phone">Phone Number</label>
        <input type="tel" name="phone" id="phone" class="form-control">
        <small class="error-message" id="phoneError"></small>
      </div>

      <!-- Date of Birth -->
      <div class="form-group">
        <label for="dob">Date of Birth</label>
        <input type="date" name="dob" id="dob" class="form-control">
        <small class="error-message" id="dobError"></small>
      </div>

      <!-- Address -->
      <div class="form-group">
        <label for="address">Address</label>
        <textarea name="address" id="address" class="form-control" rows="3"></textarea>
        <small class="error-message" id="addressError"></small>
      </div>

      <!-- Doctor Specialization (Shown only if Doctor is selected) -->

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
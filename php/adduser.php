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
    <h2 class="form-header">Add New User</h2>
    <form id="userForm" action="save-user.php" method="POST" onsubmit="return validateForm()">
      <!-- User Type Selection -->
      <div class="form-group">
        <label for="userType">User Type</label>
        <select name="userType" id="userType" class="form-control"  onchange="toggleDoctorField()">
          <option value="">Select User Type</option>
          <option value="Patient">Patient</option>
          <option value="Doctor">Doctor</option>
        </select>
        <small class="error-message" id="userTypeError"></small>
      </div>

      <!-- Patient Name -->
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" class="form-control">
        <small class="error-message" id="nameError"></small>
      </div>

      <!-- Patient Email -->
      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" name="email" id="email" class="form-control" >
        <small class="error-message" id="emailError"></small>
      </div>

      <!-- Phone Number -->
      <div class="form-group">
        <label for="phone">Phone Number</label>
        <input type="tel" name="phone" id="phone" class="form-control" >
        <small class="error-message" id="phoneError"></small>
      </div>

      <!-- Gender -->
      <div class="form-group">
        <label for="gender">Gender</label>
        <select name="gender" id="gender" class="form-control" >
          <option value="">Select Gender</option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
          <option value="Other">Other</option>
        </select>
        <small class="error-message" id="genderError"></small>
      </div>

      <!-- Date of Birth -->
      <div class="form-group">
        <label for="dob">Date of Birth</label>
        <input type="date" name="dob" id="dob" class="form-control" >
        <small class="error-message" id="dobError"></small>
      </div>

      <!-- Address -->
      <div class="form-group">
        <label for="address">Address</label>
        <textarea name="address" id="address" class="form-control" rows="3" ></textarea>
        <small class="error-message" id="addressError"></small>
      </div>

      <!-- Doctor Specialization (Shown only if Doctor is selected) -->
      <div class="form-group hidden" id="specializationField">
        <label for="specialization">Doctor Specialization</label>
        <input type="text" name="specialization" id="specialization" class="form-control">
        <small class="error-message" id="specializationError"></small>
      </div>

      <!-- Submit Button -->
      <div class="btn-container">
        <a href="admin.php" class="btn btn-secondary btn-back">Back to Dashboard</a>
        <button type="submit" class="btn btn-primary">Add User</button>
      </div>
    </form>
  </div>


  <script src="../assets/js/jquery-3.5.1.min.js"></script>
  <script src="../assets/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/js/adduser.js"></script>
</body>
</html>

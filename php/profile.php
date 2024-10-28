<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    session_start();
    require_once("Classes.php");
    require_once("saveUser.php");

    include("DB.php");
?>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Profile</title>
  <link rel="stylesheet" href="../assets/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/css/theme.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="container mt-5">
  <h1 class="text-center">Your Profile</h1>
  
  <!-- User Information Section -->
  <div id="user-info" class="mt-4">
    <h2>Personal Information</h2>
    <form id="profile-form">
      <div class="form-group">
        <label for="phone">Phone Number</label>
        <input type="text" id="phone" class="form-control" name="phone" value="<?php echo $User['phone']; ?>" readonly>
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" class="form-control" name="email" value="<?php echo $user['email']; ?>" readonly>
      </div>
      <div class="form-group">
        <label for="address">Address</label>
        <input type="text" id="address" class="form-control" name="address" value="<?php echo $user['address']; ?>" readonly>
      </div>
      <button type="button" id="edit-btn" class="btn btn-primary mt-3" onclick="enableEditing()">Edit</button>
      <button type="submit" id="save-btn" class="btn btn-success mt-3" style="display:none;">Save</button>
      <button type="button" id="cancel-btn" class="btn btn-secondary mt-3" style="display:none;" onclick="disableEditing()">Cancel</button>
    </form>
  </div>

  <!-- Appointments Section -->
  <div id="appointments" class="mt-5">
    <h2>Your Appointments</h2>
    <?php if (empty($appointments)) : ?>
      <p class="text-muted">No appointments have been made yet.</p>
    <?php else : ?>
      <ul class="list-group">
        <?php foreach ($appointments as $appointment) : ?>
          <li class="list-group-item">
            <strong>Date:</strong> <?php echo $appointment['date']; ?> <br>
            <strong>Time:</strong> <?php echo $appointment['time']; ?> <br>
            <strong>Doctor:</strong> <?php echo $appointment['doctor_name']; ?>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </div>
</div>

<script>
// Enable editing of profile fields
function enableEditing() {
  document.getElementById('phone').readOnly = false;
  document.getElementById('email').readOnly = false;
  document.getElementById('address').readOnly = false;
  document.getElementById('edit-btn').style.display = 'none';
  document.getElementById('save-btn').style.display = 'inline-block';
  document.getElementById('cancel-btn').style.display = 'inline-block';
}

// Disable editing and reset values
function disableEditing() {
  document.getElementById('phone').readOnly = true;
  document.getElementById('email').readOnly = true;
  document.getElementById('address').readOnly = true;
  document.getElementById('edit-btn').style.display = 'inline-block';
  document.getElementById('save-btn').style.display = 'none';
  document.getElementById('cancel-btn').style.display = 'none';
  location.reload(); // Reload page to reset input fields
}

// save updated info
$(document).ready(function() {
  $('#profile-form').on('submit', function(event) {
    event.preventDefault();
    
    $.ajax({
      url: 'update_profile.php', // Server script to process update
      type: 'POST',
      data: $(this).serialize(),
      success: function(response) {
        alert(response);
        disableEditing();
      },
      error: function() {
        alert("An error occurred while updating profile.");
      }
    });
  });
});
</script>

</body>
</html>

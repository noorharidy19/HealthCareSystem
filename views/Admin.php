<?php

require_once __DIR__ . '/../controllers/AdminController.php';
require_once(__DIR__ . '/../includes/auth.php');

// Check if the user is authenticated as a patient
checkAuthentication('Admin');
$controller = new AdminController();
$users = $controller->index();
if (isset($_GET['action']) && $_GET['action'] == 'Delete' && isset($_GET['ID'])) {
  $controller->delete();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="copyright" content="MACode ID, https://macodeid.com/">

  <title>Admin Dashboard</title>

  <link rel="stylesheet" href="../assets/css/maicons.css">
  <link rel="stylesheet" href="../assets/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendor/owl-carousel/css/owl.carousel.css">
  <link rel="stylesheet" href="../assets/vendor/animate/animate.css">
  <link rel="stylesheet" href="../assets/css/theme.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>
<body>

  <!-- Navbar -->
  <header>
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm">
      <div class="container">
        <a class="navbar-brand" href="#"><span class="text-primary">Admin</span>-Dashboard</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupport" aria-controls="navbarSupport" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupport">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="admin.php">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="appointments.php">Appointments</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="reports.php">Reports</a>
            </li>
          </ul>
        </div> 
      </div>
    </nav>
  </header>

  <!-- Dashboard Cards -->
  <div class="container my-5">
    <h1 class="text-center mb-4">Welcome to Admin Dashboard</h1>
    <div class="dashboard-cards">
      <div class="card text-center">
        <div class="card-body">
          <h5 class="card-title">Total Users</h5> 
          <p class="card-text"><a href="ActiveUsers.php"><i class="fas fa-users fa-3x"></i></a></p> 
        </div>
      </div>

      <div class="card text-center">
        <div class="card-body">
          <h5 class="card-title">Active Doctors</h5>
          <p class="card-text"><a href="ActiveDoctors.php"><i class="fas fa-user-md fa-3x"></a></i></p>
        </div>
      </div>

      <div class="card text-center">
        <div class="card-body">
          <h5 class="card-title">Appointments Today</h5>
          <p class="card-text"><a href="Calendar.php"><i class="fas fa-calendar-check fa-3x"></i></p>
        </div>
      </div>

      <div class="card text-center">
        <div class="card-body">
          <h5 class="card-title">Reports Generated</h5>
          <p class="card-text"><a href="reports.php"><i class="fas fa-file-alt fa-3x"></a></i></p>
        </div>
      </div>
    </div>

    <!-- Table for Users -->
    <h2 class="text-center mt-5">Admin Dashboard Overview</h2>
    <p class="text-center">Here you can manage all aspects of the system, from user accounts to appointments and reports.</p>
    <div class="add-btn">
      <a href="AddUser.php" class="btn btn-sm btn-primary">Add User</a>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Gender</th>
                <th>Address</th>
                <th>UserType</th>
                <th>DOB</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            
            // Check if data is available
            if (!empty($users)) {
                $counter = 1; // To number rows
                foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $counter++; ?></td>
                        <td><?php echo htmlspecialchars($user['Name']); ?></td>
                        <td><?php echo htmlspecialchars($user['Email']); ?></td>
                        <td><?php echo htmlspecialchars($user['phone']); ?></td>
                        <td><?php echo htmlspecialchars($user['gender']); ?></td>
                        <td><?php echo htmlspecialchars($user['Address']); ?></td>
                        <td><?php echo htmlspecialchars($user['UserType']); ?></td>
                        <td><?php echo htmlspecialchars($user['DOB']); ?></td>
                        <td>
                            <a href="Edituser.php?id=<?php echo htmlspecialchars($user['ID']); ?>" class="btn btn-sm btn-primary">Edit</a>
                            <<button action="delete" class="btn btn-sm btn-danger" onclick="confirmDelete(<?php echo htmlspecialchars($user['ID']); ?>)">Delete</button>
                        </td>
                    </tr>
            <?php 
                endforeach; 
            } else { ?>
                <tr>
                    <td colspan="9">No users found</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
  </div>
  <!-- PopUp Container -->
<!-- PopUp Container -->
<div id="confirmModal" class="modal" style="display:none;">
    <div class="modal-content">
        <p>Are you sure you want to delete?</p>
        <div class="modal-buttons">
            <button id="confirmDeleteBtn" class="btn btn2">Yes</button>
            <button id="cancelDeleteBtn" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
        </div>
    </div>
  </div>


  <!-- Footer -->
  <footer>
    <div class="container">
      <p>© 2024 Admin Dashboard. All rights reserved</p>
      <ul class="footer-menu">
        <li><a href="#">Privacy Policy</a></li>
        <li><a href="#">Terms of Service</a></li>
      </ul>
    </div>
  </footer>

  <script src="../assets/js/jquery-3.5.1.min.js"></script>
  <script src="../assets/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/owl-carousel/js/owl.carousel.min.js"></script>
  <script src="../assets/vendor/wow/wow.min.js"></script>
  <script src="../assets/js/theme.js"></script>
  <script src="../assets/js/adduser.js"></script>

</body>
</html>
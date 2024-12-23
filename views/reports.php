<?php
// Ensure that the correct model is included
require_once(__DIR__ . '/../includes/DB.php');

// Get search term from the form
$searchTerm = isset($_POST['search']) ? $_POST['search'] : '';

// SQL query to fetch patients based on the search term
$sql = "SELECT * FROM users WHERE user_type = 'Patient' AND (name LIKE '%$searchTerm%' OR user_id LIKE '%$searchTerm%')";
$result = mysqli_query($GLOBALS['conn'], $sql);

// Check for errors in the query
if (!$result) {
    die('Error: ' . mysqli_error($GLOBALS['conn']));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Patients</title>

  <link rel="stylesheet" href="../assets/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/css/theme.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <style>
    .btn-view {
      margin-right: 5px;
    }
  </style>
</head>
<body>
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
            <li class="nav-item">
              <a class="btn btn-primary ml-lg-3" href="#">Logout</a>
            </li>
          </ul>
        </div> 
      </div>
    </nav>
</header>

<div class="container">
  <h2 class="mt-4">Search Active Patients</h2>

  <!-- Search Form -->
  <form method="POST" action="">
    <div class="input-group mb-4">
      <input type="text" name="search" class="form-control" placeholder="Search by Name or ID" value="<?php echo htmlspecialchars($searchTerm); ?>">
      <div class="input-group-append">
        <button class="btn btn-primary" type="submit">Search</button>
      </div>
    </div>
  </form>

  <h2 class="mt-4">Active Patients</h2>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>Name</th>
        <th>Gender</th>
        <th>Address</th>
        <th>DOB</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Display results from the query
      if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>";
              echo "<td>" . $row['user_id'] . "</td>";  // ID
              echo "<td>" . $row['name'] . "</td>";     // Name
              echo "<td>" . $row['gender'] . "</td>";   // Gender
              echo "<td>" . $row['address'] . "</td>";  // Address
              echo "<td>" . $row['dob'] . "</td>";      // DOB
              echo "<td>";
              echo "<a href='showreports.php?id=" . $row['user_id'] . "' class='btn btn-sm btn-primary'>Show Report</a>";
              echo "</td>";
              echo "</tr>";
          }
      } else {
          echo "<tr><td colspan='6' class='text-center'>No active patients found</td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>

<script src="../assets/js/jquery-3.5.1.min.js"></script>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Doctors</title>

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
  <h2 class="mt-4">Active Doctors</h2>
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
      include 'DB.php'; // Include your database connection
      include 'Classes.php';
      $sql = "SELECT * FROM users WHERE userType = 'doctor'";
      $result = mysqli_query($GLOBALS['conn'], $sql);
      if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>";
              echo "<td>" . $row['ID'] . "</td>";
              echo "<td>" . $row['Name'] . "</td>";
              echo "<td>" . $row['gender'] . "</td>";
              echo "<td>" . $row['Address'] . "</td>";
              echo "<td>" . $row['DOB'] . "</td>";
              echo "<td>";
              echo "<a href='DocApp.php?id=" . $row['ID'] . "' class='btn btn-secondary btn-view'>View Appointments</a>";
              echo "</td>";
              echo "</tr>";
          }
      } else {
          echo "<tr><td colspan='6'>No active users found</td></tr>";
      }
      ?>
    </tbody>
  </table>
</div>

<script src="../assets/js/jquery-3.5.1.min.js"></script>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
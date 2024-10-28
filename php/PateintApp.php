

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Appointments</title>

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
  <h2 class="mt-4">Appointments</h2>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>Doctor</th>
        <th>Appointment Date</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
</div>

<script src="../assets/js/jquery-3.5.1.min.js"></script>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
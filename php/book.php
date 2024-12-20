<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="copyright" content="MACode ID, https://macodeid.com/">
  <title>One Health - Medical Center HTML5 Template</title>
  <link rel="stylesheet" href="../assets/css/maicons.css">
  <link rel="stylesheet" href="../assets/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendor/owl-carousel/css/owl.carousel.css">
  <link rel="stylesheet" href="../assets/vendor/animate/animate.css">
  <link rel="stylesheet" href="../assets/css/theme.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome CSS -->

  <?php
require_once 'DB.php'; // Include your database connection
require_once 'Classes.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $doctor_id = $_POST['doctor_id'] ?? null;
    $appointmentDate = $_POST['appointmentDate'];
    $timeSlot = $_POST['timeSlot'];
    $startTime=$_POST['start_time'];
    $endTime=$_POST['end_time'];
    $specialization = $_POST['specialization'];

    // Parse time slot into start and end times
    list($startTime, $endTime) = explode(' - ', $timeSlot);

    // Prepare SQL query to check doctor availability
    $sql = "
        SELECT 
            d.doctor_id, 
            CONCAT('Dr. ', u.Name) AS doctor_name, 
            d.start_time, 
            d.end_time 
        FROM doctor d
        JOIN users u ON d.doctor_id = u.id 
        JOIN specialization s ON d.field_id = s.ID
        LEFT JOIN appointments a 
            ON d.doctor_id = a.doctor_id 
            AND a.appointmentDate = ? 
            AND (? < a.end_time AND ? >= a.start_time)
        WHERE s.fieldName = ?
            AND d.day = ? 
            AND (? BETWEEN d.start_time AND d.end_time)
            AND a.doctor_id IS NULL
        ORDER BY d.start_time ASC;
    ";

}

  
  
?>



    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Appointment</title>

   
</head>
<body>

  <!-- Back to top button -->
  <div class="back-to-top"></div>

  <header>
    <div class="topbar">
      <div class="container">
        <div class="row">
          <div class="col-sm-8 text-sm">
            <div class="site-info">
              <a href="#"><span class="mai-call text-primary"></span> +00 123 4455 6666</a>
              <span class="divider">|</span>
              <a href="#"><span class="mai-mail text-primary"></span> mail@example.com</a>
            </div>
          </div>
          <div class="col-sm-4 text-right text-sm">
            <div class="social-mini-button">
              <a href="#"><span class="mai-logo-facebook-f"></span></a>
              <a href="#"><span class="mai-logo-twitter"></span></a>
              <a href="#"><span class="mai-logo-dribbble"></span></a>
              <a href="#"><span class="mai-logo-instagram"></span></a>
            </div>
          </div>
        </div> <!-- .row -->
      </div> <!-- .container -->
    </div> <!-- .topbar -->

    <nav class="navbar navbar-expand-lg navbar-light shadow-sm">
      <div class="container">
        <a class="navbar-brand" href="#"><span class="text-primary">One</span>-Health</a>

        <form action="#">
          <div class="input-group input-navbar">
            <div class="input-group-prepend">
              <span class="input-group-text" id="icon-addon1"><span class="mai-search"></span></span>
            </div>
            <input type="text" class="form-control" placeholder="Enter keyword.." aria-label="Username" aria-describedby="icon-addon1">
          </div>
        </form>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupport" aria-controls="navbarSupport" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupport">
          <ul class="navbar-nav ml-auto">
              <li class="nav-item active">
                  <a class="nav-link" href="index.php">Home</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="about.php">About Us</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="doctors.php">Doctors</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="blog.php">News</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="contact.php">Contact</a>
              </li>
              <li class="nav-item">
                  <a class="btn btn-primary ml-lg-3" href="signup.php">Login / Register</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="chatbot.php" id="chatbot-icon" title="chatbot">
                      <i class="fas fa-robot"></i>
                  </a>
              </li>
              <li class="nav-item">
            <a class="nav-link" href="profile.php"><i class="fas fa-user-circle"></i> Profile</a>
          </li>
          </ul>
      </div> <!-- .navbar-collapse -->
      </div> <!-- .container -->
    </nav>
  </header>
<div class="page-section">
    <div class="container">
      <h1 class="text-center wow fadeInUp">Make an Appointment</h1>

      <form class="main-form" id="appointmentForm" onsubmit="return validateForm()" method="POST" action="">
        <div class="row mt-5 ">
          <div class="col-12 col-sm-6 py-2 wow fadeInLeft">
            <input type="text" id="fullName" class="form-control" placeholder="Full name">
          </div>
          <div class="col-12 col-sm-6 py-2 wow fadeInRight">
            <input type="text" id="email" class="form-control" placeholder="Email address..">
          </div>
          <div class="col-12 col-sm-6 py-2 wow fadeInLeft" data-wow-delay="300ms">
            <input type="date" id="appointmentDate" class="form-control">
          </div>

          <!-- Department -->
          <div class="col-12 col-sm-6 py-2">
            <select name="departement" id="departement" class="custom-select" required>
              <option value="general">General Health</option>
              <option value="cardiology">Cardiology</option>
              <option value="dental">Dental</option>
              <option value="neurology">Neurology</option>
              <option value="orthopaedics">Orthopaedics</option>
            </select>
          </div>

          <!-- Phone Number -->
          <div class="col-12 py-2">
            <input type="text" id="phoneNumber" name="phoneNumber" class="form-control" placeholder="Phone Number" required>
          </div>

          <!-- Message -->
          <div class="col-12 py-2">
            <textarea name="message" id="message" class="form-control" rows="6" placeholder="Enter message..."></textarea>
          </div>

          <!-- Doctor Dropdown (Dynamically populated) -->
<div class="col-12 col-sm-6 py-2">
    <select name="doctor_id" id="doctor_id" class="custom-select" required>
        <option value="">Select a Doctor</option>
        <?php
        // Fetch doctors from the database
        $doctors = Doctor::getDoctors();
        if (!empty($doctors)) {
            foreach ($doctors as $doctor) {
                echo "<option value='{$doctor->doctor_id}'>{$doctor->doctor_name}</option>";
            }
        } else {
            echo "<option value=''>No doctors available</option>";
        }
        ?>
    </select>
</div>

<!-- Slots Dropdown (Initially empty) -->
<div class="col-12 col-sm-6 py-2">
    <select name="slot_id" id="slot_id" class="custom-select" required>
        <option value="">Select a Slot</option>
    </select>
</div>


        <button type="submit" class="btn btn-primary mt-3 wow zoomIn">Submit Request</button>
      </form>
    </div>
  </div>
  
  <script>
document.getElementById('doctor_id').addEventListener('change', function() {
    var doctorId = this.value; // Get selected doctor_id

    if (doctorId) {
        // Make AJAX request to fetch slots for the selected doctor
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'getSlots.php?doctor_id=' + doctorId, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                var slots = JSON.parse(xhr.responseText); // Parse the returned JSON
                var slotSelect = document.getElementById('slot_id');
                
                // Clear the current slots
                slotSelect.innerHTML = '<option value="">Select a Slot</option>';
                
                // Add new slots to the dropdown
                if (slots.length > 0) {
                    slots.forEach(function(slot) {
                        var option = document.createElement('option');
                        option.value = slot.slot_id;
                        option.textContent = slot.slot_time;
                        slotSelect.appendChild(option);
                    });
                } else {
                    slotSelect.innerHTML += '<option value="">No slots available</option>';
                }
            }
        };
        xhr.send();
    } else {
        // If no doctor is selected, clear the slot dropdown
        document.getElementById('slot_id').innerHTML = '<option value="">Select a Slot</option>';
    }
});
</script>

  <script src="../assets/js/book.js"></script>

  <script src="../assets/js/jquery-3.5.1.min.js"></script>
  <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html> 
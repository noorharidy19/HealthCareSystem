<?php

require_once __DIR__ . '/../models/DoctorModel.php';
require_once __DIR__ . '/../models/Appointments.php';
require_once __DIR__ . '/../includes/auth.php';
require_once(__DIR__ . '/../controllers/PatientController.php');
// Fetch patient details from session

checkAuthentication('Patient');

// Retrieve the ID of the current doctor from the session
$patientID = $_SESSION['user_id'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    PatientController::bookAppointment($patientID);
}
// Fetch doctor fields
$fields = Doctor::getDoctorFields();
?>

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
        
        

          <!-- Department -->
          <div class="col-12 col-sm-6 py-2">
                <label for="departement">Department</label>
                <select name="departement" id="departement" class="custom-select" required>
                    <option value="">Select a Department</option>
                    <?php
                    if (!empty($fields)) {
                        foreach ($fields as $field) {
                            echo "<option value='" . htmlspecialchars($field) . "'>" . htmlspecialchars($field) . "</option>";
                        }
                    } else {
                        echo "<option value=''>No departments available</option>";
                    }
                    ?>
                </select>
            </div>


          <!-- Doctor Dropdown (Dynamically populated) -->
          <div class="col-12 col-sm-6 py-2">
            <label for="doctor_id">Doctor</label>
            <select name="doctor_id" id="doctor_id" class="custom-select" required>
                <option value="">Select a Doctor</option>
            </select>
          </div>

          <!-- Slots Dropdown (Dynamically populated) -->
          <div class="col-12 col-sm-6 py-2">
            <label for="slot_id">Slot</label>
            <select name="slot_id" id="slot_id" class="custom-select" required>
                <option value="">Select a Slot</option>
            </select>
          </div>

          <button type="submit" class="btn btn-primary mt-3 wow zoomIn">Submit Request</button>
        </div>
        <input type="hidden" name="patientID" value="<?php echo htmlspecialchars($patientID); ?>">
      </form>
    </div>
  </div>
  
  <script src="../assets/js/jquery-3.5.1.min.js"></script>
  <script>
    $('#departement').on('change', function() {
        var department = $(this).val();

        if (department) {
            // Make AJAX request to fetch doctors for the selected department
            $.ajax({
                url: '../controllers/getDoctorsByDepartment.php',
                type: 'GET',
                data: { department: department },
                success: function(response) {
                    var doctors = JSON.parse(response);
                    var doctorSelect = $('#doctor_id');
                    
                    // Clear the current doctors
                    doctorSelect.empty();
                    doctorSelect.append('<option value="">Select a Doctor</option>');
                    
                    // Add new doctors to the dropdown
                    if (doctors.length > 0) {
                        $.each(doctors, function(index, doctor) {
                            doctorSelect.append('<option value="' + doctor.doctor_id + '">' + doctor.doctor_name + '</option>');
                        });
                    } else {
                        doctorSelect.append('<option value="">No doctors available</option>');
                    }
                }
            });
        } else {
            // If no department is selected, clear the doctor dropdown
            $('#doctor_id').empty();
            $('#doctor_id').append('<option value="">Select a Doctor</option>');
        }
    });

    $('#doctor_id').on('change', function() {
        var doctor_id = $(this).val();

        if (doctor_id) {
            // Make AJAX request to fetch available slots for the selected doctor
            $.ajax({
                url: '../controllers/getAvailableSlots.php',
                type: 'GET',
                data: { doctor_id: doctor_id },
                success: function(response) {
                    var slots = JSON.parse(response);
                    var slotSelect = $('#slot_id');
                    
                    // Clear the current slots
                    slotSelect.empty();
                    slotSelect.append('<option value="">Select a Slot</option>');
                    
                    // Add new slots to the dropdown
                    if (slots.length > 0) {
                        $.each(slots, function(index, slot) {
                            slotSelect.append('<option value="' + slot.slot_id + '">' + slot.start_time + ' - ' + slot.end_time + '</option>');
                        });
                    } else {
                        slotSelect.append('<option value="">No slots available</option>');
                    }
                }
            });
        } else {
            // If no doctor is selected, clear the slot dropdown
            $('#slot_id').empty();
            $('#slot_id').append('<option value="">Select a Slot</option>');
        }
    });
  </script>

  <script src="../assets/js/book.js"></script>
  <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
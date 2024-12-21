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
  session_start();
require_once 'DB.php'; // Include your database connection
require_once 'Classes.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
  $appointmentDate = $_POST['appointmentDate'];
  //$slot_id = $_POST['slot_id'];
  //$message = $_POST['message'] ?? '';
  $specialty = $_POST['departement'] ?? null;
  //$phoneNumber = $_POST['phoneNumber'];
  //$email = $_POST['email'];
  $fullName = $_POST['fullName'];
  $doctor_id = $_POST['doctor_id'];

  $patientID = $_SESSION['user_id']; // Adjust this based on your session management

  // Fetch patient name from the users table
  $fullName = getUserNameById($patientID); // Function to get the patient's name

  // Fetch doctor's name from the users table
  $doctorName = getUserNameById($doctor_id); 
      
      // Create an instance of the Appointment class
    //  $appointment = new Appointment($GLOBALS['conn'], 0); // 0 as argument as we are creating a new appointment
  
      // Call the addAppointment function
     // $result = $appointment->addAppointment($appointmentDate, $specialty, $patientID, $doctor_id, $fullName, $doctorName); 
  
    //  if ($result === true) {
          // Appointment added successfully!
      //    $_SESSION['success'] = 'Appointment booked successfully!';
        //  echo json_encode(['success' => true, 'message' => 'Appointment booked successfully!']);
      //} else {
          // Handle errors from addAppointment
        //  echo json_encode(['success' => false, 'message' => $result]); // Send the error message back to the frontend
      //}
      //exit; // Stop further execution
    //}
   // Validate form data
   if ($fullName && $appointmentDate && $specialty && $doctor_id && $doctorName) {
    // Prepare SQL query to insert appointment
   $query = "
        INSERT INTO appointments (
            patient_id, doctor_id, appointmentDate, patientName, doctorName, specialty
        ) VALUES (?, ?, ?, ?, ?, ?)
    "; 
    $stmt = $db->prepare($query);
    $result = $stmt->execute([
        $patientID,   // Patient ID
        $doctor_id,    // Doctor ID
        $appointmentDate, // Appointment Date
        $fullName, // Patient Name
        $doctorName,  // Doctor Name
        $specialty    // Specialty
    ]);

    if ($result) {
      $_SESSION['success'] = 'Appointment booked successfully!';
      echo json_encode(['success' => true, 'message' => 'Appointment booked successfully!']);
  } else {
      echo json_encode(['success' => false, 'message' => 'Failed to create appointment.']);
  }
//else {
  //echo json_encode(['success' => false, 'message' => 'Please fill in all fields.']);
//}

//

exit; // Ensure no further output is sent
}
}
function getUserNameById($userID) {
  global $db; // Use the global database connection
  $query = "SELECT Name FROM users WHERE ID = ?";
  $stmt = $db->prepare($query);
  $stmt->execute([$userID]);
  return $stmt->fetchColumn(); // Fetch the user's name
}
    // Parse time slot into start and end times
  // list($startTime, $endTime) = explode(' - ', $slot_id);
  //$slot_parts = explode(' - ', $slot_id);
  //$startTime = trim($slot_parts[0]);
  //$endTime = trim($slot_parts[1]);
  
    
    
  


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

    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    
    echo json_encode([
      'success' => true,
      'message' => 'Appointment booked successfully!',
  ]);
  


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

      <form class="main-form" id="appointmentForm" onsubmit="return validateForm()" method="POST" action="book.php">
        <div class="row mt-5 ">
          <div class="col-12 col-sm-6 py-2 wow fadeInLeft">
            <input type="text" id="fullName" name="fullName" class="form-control" placeholder="Full name">
          </div>
          <div class="col-12 col-sm-6 py-2 wow fadeInRight">
            <input type="text" id="email" name="email" class="form-control" placeholder="Email address..">
          </div>
          <div class="col-12 col-sm-6 py-2 wow fadeInLeft" data-wow-delay="300ms">
            <input type="date" id="appointmentDate" name="appointmentDate" class="form-control">
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
              echo "<option value='" . htmlspecialchars($doctor['doctor_id']) . "'>" . 
     htmlspecialchars($doctor['doctor_name']) . "</option>";
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


xhr.onload = function() {
    if (xhr.status === 200) {
        try {
            var slots = JSON.parse(xhr.responseText);
            var slotSelect = document.getElementById('slot_id');
            slotSelect.innerHTML = '<option value="">Select a Slot</option>';
            
            if (slots.length > 0) {
                slots.forEach(function(slot) {
                    var option = document.createElement('option');
                    option.value = slot.id; // Ensure `id` matches the returned JSON field
                    option.textContent = slot.time_range;
                    slotSelect.appendChild(option);
                });
            } else {
                slotSelect.innerHTML = '<option value="">No slots available</option>';
            }
        } catch (e) {
            console.error('Error parsing slots:', e);
        }
    } else {
        console.error('Error fetching slots:', xhr.statusText);
    }
};



</script>

  <script src="../assets/js/book.js"></script>

  <script src="../assets/js/jquery-3.5.1.min.js"></script>
  <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
include 'DB.php';
class User{
  protected $db;
public $name;
public $email;
public $password;
public $phone;
public $address;
public $ID;
public $userType;
public $DOb;
   function __construct($id) {
   if($id != 0){
    $sql="select * from users where 	ID=$id";
    $result = mysqli_query($GLOBALS['conn'], $sql);
    if($row = mysqli_fetch_assoc($result)){
      $this->ID = $row['ID'] ?? null; // Use null coalescing to avoid warnings
      $this->name = $row['Name'] ?? null;
      $this->email = $row['Email'] ?? null;
      $this->password = $row['Password'] ?? null;
      $this->phone = $row['phone'] ?? null;
      $this->address = $row['Address'] ?? null;
      $this->userType = $row['UserType'] ?? null;
      $this->DOb = $row['DOB'] ?? null;
      
        
    }

      }
  }

  //save data to show user info on profile
  private function loadUserData() {
    global $conn;
    $stmt = $conn->prepare("SELECT name, email, address FROM users WHERE id = ?");
    $stmt->bind_param("i", $this->id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc();
        $this->name = $userData['name'];
        $this->email = $userData['email'];
        $this->address = $userData['address'];
    }
}
public function saveUser($name, $email, $password, $phone, $dob, $userType) {
  // Hash the password
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
  
  // Prepare the SQL statement
  $stmt = $GLOBALS['conn']->prepare("INSERT INTO users (name, email, password, phone, dob, userType) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssss", $name, $email, $hashedPassword, $phone, $dob, $userType);
  
  if ($stmt->execute()) {
      return $GLOBALS['conn']->insert_id; // Return the new user ID
  } else {
      return false; // Return false on failure
  }
}

  public function createUser() {
    global $conn; // Ensure the connection is available
 // Check if email already exists
 $emailCheckQuery = "SELECT * FROM users WHERE email = ?";
 $stmt = $conn->prepare($emailCheckQuery);
 $stmt->bind_param("s", $this->email);
 $stmt->execute();
 $result = $stmt->get_result();

 if ($result->num_rows > 0) {
     // Email already exists
     $_SESSION['error'] = "Email already exists. Please use a different email.";
     return false;
 }
    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, phone, address, userType, DOb) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $this->name, $this->email, $this->password, $this->phone, $this->address, $this->userType, $this->DOb);

    // Execute the statement and return result
    if ($stmt->execute()) {
        // Optionally, fetch the last inserted ID
        $this->ID = $stmt->insert_id; // Get the ID of the newly created user
        return true; // Successfully created user
    } else {
      error_log("Database Error: " . $stmt->error); // Log to a file
      return false; // Failed to create user
    }
}
// retrieve user information
public function getUserInfo($userId) {
  $stmt = $this->db->prepare("SELECT name, email, phone, address FROM users WHERE id = ?");
  $stmt->execute([$userId]);
  return $stmt->fetch(PDO::FETCH_ASSOC);
}

// retrieve user appointments
public function getUserAppointments($userId) {
  $stmt = $this->db->prepare("SELECT * FROM appointments WHERE user_id = ?");
  $stmt->execute([$userId]);
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public static function editUser($name, $email, $password, $phone, $address, $DOB, $gender, $ID) {
  // Ensure the connection is available
  global $conn;

  // Prepare the SQL statement
  $sql = "UPDATE users SET 
              Name='$name', 
              Email='$email', 
              Password='$password', 
              phone='$phone', 
              Address='$address', 
              DOB='$DOB', 
              gender='$gender' 
          WHERE ID='$ID'";

  // Execute the query
  if (mysqli_query($GLOBALS['conn'], $sql)) {
      return true; // User updated successfully
  } else {
      // Debugging: Print error message
      error_log("Failed to execute query: " . mysqli_error($conn));
      return false; // Failed to update user
  }
}
}
Class Admin extends User{
  public function __construct($id) {
    parent::__construct($id);
  }
  public static function addUser($name, $email, $password, $phone, $address, $userType, $DOb, $gender) {
        

    // Prepare the SQL statement
    $sql = "INSERT INTO users (Name, phone, Email, Password, gender, Address, UserType, DOB) 
            VALUES ('$name', '$phone', '$email', '$password', '$gender', '$address', '$userType', '$DOb')";
  
    // Execute the query
    if (mysqli_query($GLOBALS['conn'], $sql)) {
        return true; // User added successfully
    } else {
        // Debugging: Print error message
        error_log("Failed to execute query: " . mysqli_error($GLOBALS['conn']));
        return false; // Failed to add user
    }
  }
}
  
  // public static function deleteUser($id, $conn) {
  //     // Prepare the SQL statement
  //     $stmt = $conn->prepare("DELETE FROM users WHERE ID = ?");
  //     $stmt->bind_param("i", $id);
  
  //     // Execute the query
  //     if ($stmt->execute()) {
  //         return true; // User deleted successfully
  //     } else {
  //         // Debugging: Print error message
  //         error_log("Failed to execute query: " . $stmt->error);
  //         return false; // Failed to delete user
  //     }
  // }
  


  class Doctor extends User {
      private $timeSlots = [];
  
      public function __construct($id) {
          parent::__construct($id);
      }
  
      public function addTimeSlot($startTime, $endTime, $booked=false) {
          $this->timeSlots[] = ['startTime' => $startTime, 'endTime' => $endTime,'booked'=>$booked];
      }
  
      public function getTimeSlots() {
          return $this->timeSlots;
      }
  
// Mark a slot as booked or available
public function updateBookingStatus($startTime, $endTime, $status) {
  foreach ($this->timeSlots as &$slot) {
      if ($slot['startTime'] === $startTime && $slot['endTime'] === $endTime) {
          $slot['booked'] = $status; // Set status to true (booked) or false (available)
          return true;
      }
  }
  return false;
}

      public static function addSlot($doctorId, $day, $startTime, $endTime) {
          // Ensure user is a doctor
          $stmt = $GLOBALS['conn']->prepare("SELECT UserType FROM users WHERE ID = ?");
          $stmt->bind_param("i", $doctorId);
          $stmt->execute();
          $result = $stmt->get_result();
          $user = $result->fetch_assoc();
  
          if ($user['UserType'] !== 'Doctor') {
              return false;
          }
       //   $currentDate = date("Y-m-d"); // Get today's date in YYYY-MM-DD format
       $currentDate = new DateTime();
       $dayDate = new DateTime($day);  
       
       if ($dayDate < $currentDate) {
              // Set a session error message for a past date
              $_SESSION['error'] = "You cannot add a slot for a past day. Please choose a future date.";
              return false; // Return false to indicate the error
          }
      
  
          // Prepare the SQL statement
          $sql = "INSERT INTO doctor (doctor_id, day, start_time, end_time,booked) 
                  VALUES ('$doctorId', '$day', '$startTime', '$endTime',0)";
  
          // Execute the query
          if (mysqli_query($GLOBALS['conn'], $sql)) {
              return true; // Slot added successfully
          } else {
              // Debugging: Print error message
              error_log("Failed to execute query: " . mysqli_error($GLOBALS['conn']));
              return false; // Failed to add slot
          }
      }
  
      public static function getSlots($doctor_id) {
        // Fetch the available time slots for the doctor
        $sql = "SELECT slot_id, doctor_id, day, start_time, end_time FROM doctor WHERE doctor_id = ? AND booked=0";
        $stmt = mysqli_prepare($GLOBALS['conn'], $sql);
        mysqli_stmt_bind_param($stmt, 'i', $doctor_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    
      public static function getDoctors() {
        // Query to get all doctors with their names from the users table
        $sql = "SELECT d.doctor_id, u.Name AS doctor_name FROM doctor d
                JOIN users u ON d.doctor_id = u.ID
                WHERE u.UserType = 'doctor'";  // Ensure the user is a doctor
        $result = mysqli_query($GLOBALS['conn'], $sql);
        
        if (!$result) {
            error_log("Error fetching doctors: " . mysqli_error($GLOBALS['conn']));
            return []; // Return an empty array in case of failure
        }
    
        return mysqli_fetch_all($result, MYSQLI_ASSOC); // Returns an array of doctors
    }
    
    
  }



  


  Class Patient extends User{
    public function __construct($id) {
      parent::__construct($id);
    }
  
     // Update patient profile information in the database
     public function updateProfile($name, $email, $address) {
      include("DB.php");
  
      // Validate input (simplified)
      if (empty($name) || empty($email) || empty($address)) {
          return "All fields are required.";
      }
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          return "Invalid email format.";
      }
  
      // Update profile in the database
      $query = "UPDATE users SET Name = ?, Email = ?, Address = ? WHERE id = ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("sssi", $name, $email, $address, $this->user_id);
  
      if ($stmt->execute()) {
          return "Profile updated successfully.";
      } else {
          return "Failed to update profile. Please try again.";
      }
  
      $stmt->close();
      $conn->close();
  }
  
   // Method to book an appointment
   public function bookAppointment($doctorID, $appointmentDate, $appointmentTime, $patientID, $specialty, $patientName, $doctorName) {
    $stmt = $GLOBALS['conn']->prepare("SELECT booked FROM doctor WHERE doctor_id = ? AND day = ? AND start_time = ? AND end_time = ?");
    $stmt->bind_param("isss", $doctorID, $appointmentDate, $appointmentTime, $appointmentTime);
    $stmt->execute();
    $result = $stmt->get_result();
    $slot = $result->fetch_assoc();

    if ($slot && $slot['booked'] == 1) {
        return "This slot is already booked.";
    }

    // Proceed with booking the appointment by updating the 'booked' column
    $updateStmt = $GLOBALS['conn']->prepare("UPDATE doctor SET booked = 1 WHERE doctor_id = ? AND day = ? AND start_time = ? AND end_time = ?");
    $updateStmt->bind_param("isss", $doctorID, $appointmentDate, $appointmentTime, $appointmentTime);

    if ($updateStmt->execute()) {
        // Create an Appointment object and call the addAppointment method
        $appointment = new Appointment($GLOBALS['conn'], 0); // Pass the connection and a default appointmentID of 0
        return $appointment->addAppointment($appointmentDate, $specialty, $patientID, $doctorID, $patientName, $doctorName);
    } else {
        return "Failed to book the appointment. Please try again.";
    }
}
  
  }
  
  
  
  
  class Appointment {
    private $conn;
    public $appointmentID;
    public $patient_id;
    public $doctor_id;
    public $appointmentDate;
    
    public $patientName;
    public $doctorName;
    public $specialty;
   
    

  
    public function __construct($conn,$appointmentID) {
      $this->conn = $conn;
     
      if ($appointmentID != 0) {
        $sql = "SELECT a.*, 
                       p.name AS patientName, 
                       d.name AS doctorName 
                FROM appointments a 
                JOIN users p ON a.patient_id = p.id AND p.usertype = 'patient' 
                JOIN users d ON a.doctor_id = d.id AND d.usertype = 'doctor' 
                WHERE a.appointment_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $appointmentID);
        $stmt->execute();
        $result = $stmt->get_result();
    }
    if ($row = $result->fetch_assoc()) {
      $this->appointmentID = $row['appointment_id'] ?? null;
      $this->appointmentDate = $row['appointmentDate'] ?? null;
      $this->specialty = $row['specialty'] ?? null;
      $this->patientName = $row['patientName'] ?? null;
      $this->doctorName = $row['doctorName'] ?? null;
  }
}


public function getAppointment($appointmentID) {
if ($appointmentID != 0) {
  $sql = "SELECT a.*, 
                 p.name AS patientName, 
                 d.name AS doctorName 
          FROM appointments a 
          JOIN users p ON a.patient_id = p.id AND p.usertype = 'patient' 
          JOIN users d ON a.doctor_id = d.id AND d.usertype = 'doctor' 
          WHERE a.appointment_id = ?";
  $stmt = $this->conn->prepare($sql);
  $stmt->bind_param("i", $appointmentID);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
      return $result->fetch_assoc(); // Fetch and return the appointment data
  } else {
      return "No appointment found.";
  }
} else {
  return "Invalid appointment ID.";
}
}
    

public function addAppointment($appointmentDate, $specialty, $patient_id, $doctor_id, $patientName, $doctorName) {
  if (!$this->validateAppointmentDetails($appointmentDate)) {
      return "Invalid appointment details.";
  }

  $stmt = $this->conn->prepare(
      "INSERT INTO appointments ( patient_id,doctor_id, appointmentDate, specialty, patientName, doctorName) 
       VALUES (?, ?, ?, ?, ?, ?)"
  );
  $stmt->bind_param("iissss", $doctor_id, $patient_id, $appointmentDate, $patientName, $doctorName,$specialty);

  if ($stmt->execute()) {
      return true;
  } else {
      error_log("Failed to add appointment: " . $stmt->error);
      return false;
  }
}
  
  private function validateAppointmentDetails($appointmentDate) {
      // Basic validations for IDs and dates
      return   strtotime($appointmentDate) > time() ;
  }
  
    // Retrieve all appointments for a specific patient
    public function getAppointmentsByPatient($patientID) {
        $stmt = $this->conn->prepare("SELECT * FROM appointments WHERE patient_id = ?");
        $stmt->bind_param("i", $patientID);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
  
    // Retrieve all appointments for a specific doctor
    public function getAppointmentsByDoctor($doctorID) {
        $stmt = $this->conn->prepare("SELECT * FROM appointments WHERE doctor_id = ?");
        $stmt->bind_param("i", $doctorID);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
  
    // Update appointment status
    public function updateAppointmentStatus($appointmentID, $newStatus) {
        $stmt = $GLOBALS['conn']->prepare("UPDATE appointments SET status = ? WHERE appointmentID = ?");
        $stmt->bind_param("si", $newStatus, $appointmentID);
  
        if ($stmt->execute()) {
            return true;
        } else {
            error_log("Error updating appointment: " . $stmt->error);
            return false;
        }
    }
  
    // Delete an appointment
    public function deleteAppointment($appointmentID) {
        $stmt = $GLOBALS['conn']->prepare("DELETE FROM appointments WHERE appointment_id = ?");
        $stmt->bind_param("i", $appointmentID);
  
        if ($stmt->execute()) {
            return true;
        } else {
            error_log("Error deleting appointment: " . $stmt->error);
            return false;
        }
    }
    public function getAppointmentsByUserId($userId) {
      $stmt = $this->db->prepare("SELECT * FROM appointments WHERE user_id = ?");
      $stmt->bind_param("i", $userId);
      $stmt->execute();
      $result = $stmt->get_result();

      return $result->fetch_all(MYSQLI_ASSOC); // Return all appointments as an associative array
  }

  // Retrieve all appointments (e.g., for admin purposes)
  public function getAllAppointments() {
      $stmt = $this->db->prepare("SELECT * FROM appointments");
      $stmt->execute();
      $result = $stmt->get_result();

      return $result->fetch_all(MYSQLI_ASSOC); // Return all appointments as an associative array
  }
}

  
  Class MedicalRecords{
    
  }

?>
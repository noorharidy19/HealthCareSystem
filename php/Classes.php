<?php
include 'DB.php';
class User{
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
  
      public function addTimeSlot($startTime, $endTime) {
          $this->timeSlots[] = ['startTime' => $startTime, 'endTime' => $endTime];
      }
  
      public function getTimeSlots() {
          return $this->timeSlots;
      }
  
      public static function addSlot($doctorId, $day, $startTime, $endTime) {
          // Ensure user is a doctor
          $stmt = $GLOBALS['conn']->prepare("SELECT UserType FROM users WHERE id = ?");
          $stmt->bind_param("i", $doctorId);
          $stmt->execute();
          $result = $stmt->get_result();
          $user = $result->fetch_assoc();
  
          if ($user['UserType'] !== 'doctor') {
              return false;
          }
  
          // Prepare the SQL statement
          $sql = "INSERT INTO doctor (doctor_id, day, start_time, end_time) 
                  VALUES ('$doctorId', '$day', '$startTime', '$endTime')";
  
          // Execute the query
          if (mysqli_query($GLOBALS['conn'], $sql)) {
              return true; // Slot added successfully
          } else {
              // Debugging: Print error message
              error_log("Failed to execute query: " . mysqli_error($GLOBALS['conn']));
              return false; // Failed to add slot
          }
      }
  
      public function getSlots() {
          $stmt = $this->db->prepare("SELECT * FROM doctor WHERE doctor_id = ?");
          $stmt->execute([$this->id]);
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
      }
  }



  


Class Patient extends User{
  public function __construct($id) {
    parent::__construct($id);
  }
}
Class Appointments{

}
Class MedicalRecords{
  
}

?>
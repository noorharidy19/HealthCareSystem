
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
        $this->ID = $row['ID'];
        $this->name = $row['name'];        
        $this->email = $row['email'];
        $this->password = $row['password'];
        $this->phone = $row['phone'];
        $this->address = $row['address'];
        $this->userType = $row['userType']; //admin , doctor, patient
        $this->DOb = $row['DOb'];
    }

      }
  }
  public function checkIfEmailExists($email) {
    global $conn;
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    return $stmt->num_rows > 0; // Returns true if email exists
}
  public function createUser() {
    global $conn;

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

        // Insert new user if email does not exist
        $insertQuery = "INSERT INTO users (name, email, password, phone, address, userType, DOb) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("sssssss", $this->name, $this->email, $this->password, $this->phone, $this->address, $this->userType, $this->DOb);

        if ($stmt->execute()) {
            // Get the last inserted ID
            $this->ID = $this->conn->insert_id;
            return true;
        } else {
            $_SESSION['error'] = "User registration failed.";
            return false;
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



?>
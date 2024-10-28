
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
  public function createUser() {
    global $conn; // Ensure the connection is available

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
}


?>
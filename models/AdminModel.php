
<?php 
require_once(__DIR__ . '/../models/UsersModel.php');
Class Admin extends User{
    private $db;
    
  public function __construct($id) {
    parent::__construct($id);
   
  } 
  public static function deleteUser($ID) {
    global $conn;

    // Use a prepared statement to delete the user securely
    $stmt = $conn->prepare("DELETE FROM users WHERE ID = ?");
    $stmt->bind_param("i", $ID);

    if ($stmt->execute()) {
        return true; // Successfully deleted
    } else {
        error_log("Error deleting user: " . $stmt->error); // Log the error for debugging
        return false; // Failed to delete
    }
}


 

// Check if 'id' is set in the URL // Ensure the ID is an integer

 
    
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
  public static function getUser() {
    $sql = "SELECT * FROM users";
    $result = mysqli_query($GLOBALS['conn'], $sql);

    $users = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }
    }
    return $users;
}
public static function addUser($name, $email, $password, $phone, $address, $userType, $DOb, $gender) {
        
  $sql = "INSERT INTO users (Name, phone, Email, Password, gender, Address, UserType, DOB) 
          VALUES ('$name', '$phone', '$email', '$password', '$gender', '$address', '$userType', '$DOb')";

  if (mysqli_query($GLOBALS['conn'], $sql)) {
      return true; 
  } else {
    
      error_log("Failed to execute query: " . mysqli_error($GLOBALS['conn']));
      return false;
  }
}
public static function calender(){

}
}

?>
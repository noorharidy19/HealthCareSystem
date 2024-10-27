
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
public $gender; 
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
        $this->gender=$row['gender'];
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

?>
<?php
require_once(__DIR__ . "/../models/UsersModel.php");


Class Patient extends User{

    public function __construct() {
      
    }

    public function signup() {
        global $conn; // Ensure the connection is available

        // Start session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Check if email already exists
        $emailCheckQuery = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($emailCheckQuery);
        $email= $this->getEmail();
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Email already exists
            $_SESSION['error'] = "Email already exists. Please use a different email.";
            return false;
        }

        // Hash the password
        $hashedPassword = password_hash($this->getPassword(), PASSWORD_DEFAULT);

        // Insert the user into the database
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, phone, address, userType, dob) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $name= $this->getName();
        $email= $this->getEmail();
        $phone= $this->getPhone();
        $address= $this->getAddress();
        $userType= $this->getUserType();
        $dob= $this->getDob();
        
        $stmt->bind_param("sssssss", $name, $email, $hashedPassword, $phone, $address, $userType, $dob);

        if ($stmt->execute()) {
            $_SESSION['user_id'] = $stmt->insert_id;
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['error'] = "Sign-up failed. Please try again.";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    }


}




?>




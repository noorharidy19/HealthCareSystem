<?php
require_once(__DIR__ . '/../includes/DB.php');

class User {
    private $name;
    private $email;
    private $password;
    private $phone;
    private $address;
    private $ID;
    private $userType;
    private $DOb;

    public function __construct($id) {
        if ($id != 0) {
            $sql = "SELECT * FROM users WHERE ID = $id";
            $result = mysqli_query($GLOBALS['conn'], $sql);
            if ($row = mysqli_fetch_assoc($result)) {
                $this->ID = $row['ID'] ?? null;
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

    // Getter and Setter methods
    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function getID() {
        return $this->ID;
    }

    public function setID($ID) {
        $this->ID = $ID;
    }

    public function getUserType() {
        return $this->userType;
    }

    public function setUserType($userType) {
        $this->userType = $userType;
    }

    public function getDOb() {
        return $this->DOb;
    }

    public function setDOb($DOb) {
        $this->DOb = $DOb;
    }

    // Save data to show user info on profile
    private function loadUserData() {
        global $conn;
        $stmt = $conn->prepare("SELECT name, email, address FROM users WHERE id = ?");
        $stmt->bind_param("i", $this->ID);
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
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $GLOBALS['conn']->prepare("INSERT INTO users (name, email, password, phone, dob, userType) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $email, $hashedPassword, $phone, $dob, $userType);

        if ($stmt->execute()) {
            return $GLOBALS['conn']->insert_id;
        } else {
            return false;
        }
    }

    public function createUser() {
        global $conn;
        $emailCheckQuery = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($emailCheckQuery);
        $stmt->bind_param("s", $this->email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['error'] = "Email already exists. Please use a different email.";
            return false;
        }

        $stmt = $conn->prepare("INSERT INTO users (name, email, password, phone, address, userType, DOb) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $this->name, $this->email, $this->password, $this->phone, $this->address, $this->userType, $this->DOb);

        if ($stmt->execute()) {
            $this->ID = $stmt->insert_id;
            return true;
        } else {
            error_log("Database Error: " . $stmt->error);
            return false;
        }
    }

    public function getUserInfo($userId) {
        $stmt = $GLOBALS['conn']->prepare("SELECT name, email, phone, address FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getUserAppointments($userId) {
        $stmt = $GLOBALS['conn']->prepare("SELECT * FROM appointments WHERE user_id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

  
        public static function login() {
            global $conn;
    
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Retrieve the form inputs
                $emailOrPhone = $_POST['loginEmailOrPhone'];
                $password = $_POST['loginPassword'];
    
                // Prepare a SQL statement to prevent SQL injection
                $stmt = $conn->prepare("SELECT * FROM users WHERE (Email = ? OR phone = ?) LIMIT 1");
                $stmt->bind_param("ss", $emailOrPhone, $emailOrPhone);
                $stmt->execute();
                $result = $stmt->get_result();
    
                // Check if a user record was found
                if ($result->num_rows > 0) {
                    $user = $result->fetch_assoc();
    
                    // Verify the password
                    if (password_verify($password, $user['Password'])) { // Assuming passwords are hashed
                        session_start();
                        $_SESSION['user_id'] = $user['ID'];
                        $_SESSION['Email'] = $user['Email'];
                        $_SESSION['UserType'] = $user['UserType']; // Store userType in session
    
                        // Check userType for redirection
                        if ($user['UserType'] === 'Admin') {
                            header("Location: Admin.php"); // Redirect to admin dashboard
                        } else if ($user['UserType'] === 'Doctor') {
                            header("Location: Doctor.php"); // Redirect to doctor dashboard
                        } else {
                            header("Location: Patient.php"); // Redirect to patient dashboard
                        }
                        exit();
                    } else {
                        $_SESSION['error'] = "Invalid email/phone or password.";
                        return false;
                    }
                } else {
                    $_SESSION['error'] = "User not found.";
                    return false;
                }
    
                $stmt->close();
                $conn->close();
            }
        }
        public static function logout() {
            session_start();
            session_unset();
            session_destroy();
            header("Location: index.php");
            exit();
        }
   
}
?>
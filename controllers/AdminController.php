<?php
require_once ('../models/AdminModel.php');

class AdminController {
    public function delete() {
        if (isset($_GET['ID'])) {
            $ID = intval($_GET['ID']); // Sanitize the ID
            if (Admin::deleteUser($ID)) {
                echo "User deleted successfully!";
                header("Location: Admin.php?message=UserDeleted"); // Redirect to avoid duplicate execution
                exit;
            } else {
                echo "Failed to delete user.";
            }
        } else {
            echo "No user ID provided.";
        }
    }
    
    public function edit() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Check if form was submitted
            $ID = $_POST['id'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $dob = $_POST['dob'];
            $gender = $_POST['gender'];
           
           

            if (Admin::editUser($name, $email, $password, $phone, $address, $dob, $gender, $ID)) {
                echo "<p>User updated successfully!</p>";
            } else {
                echo "<p>Error updating user.</p>";
            }
        } 
            // Display the edit user form
            if (isset($_GET['id'])) {
                $ID = $_GET['id'];
                $user = new User($ID);
                return $user;
                
            } else {
                echo "<p>No user ID provided.</p>";
                exit;
            }
           
          
           
        
    }
        public function add() {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $name = $_POST['name'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $phone = $_POST['phone'];
                $address = $_POST['address'];
                $userType = $_POST['userType'];
                $DOb = $_POST['DOB'];
                $gender = $_POST['gender'];
    
                $result = Admin::addUser($name, $email, $password, $phone, $address, $userType, $DOb, $gender);
    
                if ($result) {
                    echo "User added successfully!";
                } else {
                    echo "Failed to add user.";
                }
            } 
            // else {
            //     // Display the add user form
            //     include(__DIR__ . '/../views/adduser.php');
            // }
        }
    
    public function index() {
        $adminModel = new Admin(1);
        $users = $adminModel->getUser(); // Fetch users properly
        return $users;
        // include(__DIR__ . '/../views/Admin.php'); // Pass data to the view
    }
} 
        ?>





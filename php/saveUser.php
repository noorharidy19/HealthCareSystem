<?php
session_start();
require 'DB.php'; 
require 'Classes.php'; 
global $conn;



// Get form data
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$phone = $_POST['phone'];
$dob = $_POST['dob'];
$address = $_POST['address'];

// Hash the password for security
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Create a new User object
$newUser = new User(NULL); // No ID needed for new users
$newUser->name = $name;
$newUser->email = $email;
$newUser->password = $hashedPassword; // Store the hashed password
$newUser->phone = $phone;
$newUser->address = $address;
$newUser->userType = 'patient'; // Assign default userType or change as needed
$newUser->DOb = $dob;

if ($newUser->checkIfEmailExists($email)) {
    $_SESSION['error'] = "Email already exists. Please use a different email.";
    header("Location: signup.php");
    exit();
}

// Call the method to create the user
if ($newUser->createUser()) {
    $_SESSION['user_id'] = $newUser->ID; // Store user ID in session after successful registration
    header("Location: profile.php");
    exit();
} else {
    $_SESSION['error'] = "Sign-up failed. Please try again.";
    header("Location: signup.php");
    exit();
}


// Close the database connection
$conn->close();
?>
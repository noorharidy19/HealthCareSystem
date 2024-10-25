<?php

require 'DB.php'; 
require 'Classes.php'; 

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

// Call the method to create the user
if ($newUser->createUser()) {
    echo "User registered successfully! Your ID is: " . $newUser->ID; // Optional: show the ID
} else {
    echo "Error: User registration failed.";
}

// Close the database connection
$conn->close();
?>

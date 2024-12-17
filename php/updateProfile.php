<?php
session_start();
include("DB.php"); // Ensure this file sets up the `$conn` variable for the database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You are not logged in.";
    exit();
}

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the posted data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    // Validate input (e.g., prevent empty fields or invalid email)
    if (empty($name) || empty($email) || empty($address)) {
        echo "All fields are required.";
        exit();
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit();
    }

    // Update the user's information in the database
    $query = "UPDATE users SET Name = ?, Email = ?, Address = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $name, $email, $address, $user_id);

    if ($stmt->execute()) {
        echo "Profile updated successfully.";
    } else {
        echo "Failed to update profile. Please try again.";
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}

$conn->close();
?>
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
} // Start the session

function checkAuthentication($requiredUserType) {
    // Check if the user is logged in and has the required user type
    if (!isset($_SESSION['user_id']) || $_SESSION['UserType'] !== $requiredUserType) {
        // If not authenticated, redirect to the 404 page
        header("Location: 404.php");
        exit();
    }
}
?>
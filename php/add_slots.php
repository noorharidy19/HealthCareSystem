<?php
session_start(); // Start the session

// Include database connection and Doctor class
include 'DB.php';
include 'Classes.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $day = $_POST['day'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];

    // Get the doctor ID from the session
    if (isset($_SESSION['user_id']) && $_SESSION['UserType'] === 'Doctor') {
        $doctorId = $_SESSION['user_id'];

        // Add the slot
        if (Doctor::addSlot($doctorId, $day, $startTime, $endTime)) {
            echo "Slot added successfully.";
        } else {
            // Check if there was an error message in the session
            if (isset($_SESSION['error'])) {
                echo "<div class='error-message'>" . htmlspecialchars($_SESSION['error']) . "</div>";
                unset($_SESSION['error']); // Clear the error after displaying it
            } else {
                echo "<div class='error-message'>An error occurred while adding the slot. Please try again.</div>";
            }
        }
    } else {
        echo "<div class='error-message'>Error: Unauthorized access. Only doctors can add slots.</div>";
    }
}
?>
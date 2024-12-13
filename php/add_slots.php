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
            echo "Error adding slot.";
        }
    } else {
        echo "Error: Unauthorized access.";
    }
}
?>
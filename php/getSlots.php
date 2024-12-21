<?php
include('DB.php');
require_once 'Classes.php'; // Include your Doctor class (adjust path if necessary)

// Set response header for JSON
header('Content-Type: application/json');

if (isset($_GET['doctor_id'])) {
    $doctor_id = $_GET['doctor_id'];
    
    // Fetch the slots for the selected doctor using the doctor_id
    $slots = Doctor::getSlots($doctor_id);
    
    // Return the slots as a JSON response
    echo json_encode($slots);
} else {
    echo json_encode([]);
}

?>

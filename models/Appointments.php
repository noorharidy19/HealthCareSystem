<?php
class Appointments {
    private $AppointmentID;
    private $patientID;
    private $doctorID;
    private $time;
    private $status;
   

    public static function addAppointment($patientID, $doctorID, $time, $status) {
        global $conn; // Ensure the connection is available
    
        // Correct SQL query
        $sql = "INSERT INTO appointments (patientID, doctorID, time, status) VALUES (?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiss", $patientID, $doctorID, $time, $status); // Bind the 4 values
    
        // Execute the query
        if ($stmt->execute()) {
            return true; // Appointment added successfully
        } else {
            // Log error for debugging
            error_log("Failed to execute query: " . $stmt->error);
            return false; // Failed to add appointment
        }
    }
    
}
?>
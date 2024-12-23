<?php
require_once(__DIR__ . '/../models/DoctorModel.php');


if (isset($_GET['department'])) {
    $department = $_GET['department'];
    $doctors = Doctor::getDoctorsByDepartment($department);
    echo json_encode($doctors);
}


class DoctorController {
    

    public function addSlotAction(int $doctorId): void { // declare void explicitly here
        // Check if the user is logged in and is a doctor
        // if (isset($_SESSION['doctorId'])) {
        //     $doctorId = $_SESSION['doctorId']; // Get the logged-in doctor's ID
        // } else {
        //     // Redirect or show error if the user is not a doctor
        //     $_SESSION['error'] = "You must be logged in as a doctor to add a slot.";
        //     header("Location: /Doctor.php");
        //     exit();
        // }

        // Collect form data
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $day = $_POST['day']; // e.g. '2024-12-25'
            $startTime = $_POST['startTime']; // e.g. '09:00:00'
            $endTime = $_POST['endTime']; // e.g. '17:00:00'
            $filed = $_POST['field']; // e.g. 'dentist'

            // Call the addSlot method from Doctor model
            $result = Doctor::addSlot($doctorId, $day, $startTime, $endTime,$filed);
             
            if ($result) {
                $_SESSION['success'] = "Slot added successfully!";
                header("Location: Doctor.php");
            } else {
                $_SESSION['error'] = "Failed to add slot. Please check your input.";
                header("Location: Doctor.php");
            }
        }
    }
    public function getAppointmentsView(int $doctorId): array {
       

        // Fetch appointments from the model
        $appointments = Doctor::getAppointments($doctorId);

        // Return the appointments for the view
        return $appointments;
    }
    public function getAppointmentsAction(): void {
        if (isset($_SESSION['user_id'])) {
            $doctorId = $_SESSION['user_id'];
            $appointments = Doctor::getAppointments($doctorId);

            header('Content-Type: application/json');
            echo json_encode($appointments);
        } else {
            http_response_code(403); // Forbidden
            echo json_encode(["error" => "Unauthorized access."]);
        }
    }

}
?>

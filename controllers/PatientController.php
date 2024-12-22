<?php
require_once(__DIR__ . '/../models/PatientModel.php');
require_once( __DIR__ . '/../models/Appointments.php');
class PatientController {
    public static function create() {

         $patient = new Patient(); 

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ID = 0;
            $patient->setName($_POST['name'] ?? '');
            $patient->setEmail($_POST['email'] ?? '');
            $patient->setPassword($_POST['password'] ?? '');
            $patient->setPhone($_POST['phone'] ?? '');
            $patient->setAddress($_POST['address'] ?? '');
            $patient->setUserType('Patient'); // Hardcoded 'Patient'
            $patient->setDob($_POST['dob'] ?? '');

            // Call the signup method
            if ($patient->signup()) {
                echo "Signup successful!";
                // Redirect to login page or patient dashboard
                header("Location: login.php");
                exit();
            } else {
                echo "Signup failed!";
            }
        }
    }
 



// Check if the user is authenticated as a patient

    public static function bookAppointment($patientID) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Capture the form data
             // Assume this is set during login
            $doctorName = $_POST['doctor_id'];
            $slot = $_POST['slot_id'];
            $status = 'booked'; // Default status for a new appointment

            // Retrieve the doctor ID using the doctor name
            // $doctorID = Doctor::getDoctorIdByName($doctorName);
            $time=Doctor::getSlotDetails($slot);

           

            // Add the appointment
            if (Appointments::addAppointment($patientID, $doctorName, $time ,$status)) {
                // Success: Redirect or display a success message
                header('Location: Patient.php?success=1');
                exit();
            } else {
                // Failure: Redirect or display an error message
                header('Location: booking.php?error=1');
                exit();
            }
        }
    }
}

?>
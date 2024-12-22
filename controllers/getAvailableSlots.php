<?php
require_once __DIR__ . '/../models/DoctorModel.php';

if (isset($_GET['doctor_id'])) {
    $doctor_id = $_GET['doctor_id'];
    $slots = Doctor::getSlots($doctor_id);
    echo json_encode($slots);
}
?>
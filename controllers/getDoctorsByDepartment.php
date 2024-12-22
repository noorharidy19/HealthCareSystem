<?php
require_once __DIR__ . '/../models/DoctorModel.php';

if (isset($_GET['department'])) {
    $department = $_GET['department'];
    $doctors = Doctor::getDoctorsByDepartment($department);
    echo json_encode($doctors);
}
?>
<?php
require_once(__DIR__ . '/../includes/auth.php');
require_once(__DIR__ . '/../controllers/DoctorController.php');
require_once __DIR__ . '/../models/Appointments.php';
// Check if the user is authenticated as a doctor
checkAuthentication('Doctor');

// Retrieve the ID of the current doctor from the session
$doctorId = $_SESSION['user_id'];

$controller = new DoctorController();
$appointments = $controller->getAppointmentsView($doctorId); // Fetch appointments
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Patients</title>
    <link rel="stylesheet" href="../assets/css/theme.css"> 
    <link rel="stylesheet" href="../assets/css/viewPatients.css"> 
    
</head>
<body>
    <div class="container">
        <h1>View Patients</h1>

        <?php if (!empty($appointments)): ?>
            <table  cellspacing="0" cellpadding="10">
                <thead>
                    <tr>
                        <th>Patient Name</th>
                        <th>Appointment Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appointments as $appointment): ?>
                        <tr>
                            <td><?= htmlspecialchars($appointment['patient_name']) ?></td>
                            <td><?= ($appointment['appointment_time']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No appointments available.</p>
        <?php endif; ?>

        <a href="Doctor.php" class="btn">Back to Dashboard</a>
    </div>
</body>
</html>

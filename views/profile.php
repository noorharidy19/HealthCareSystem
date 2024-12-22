<!DOCTYPE html>
<head>
    <?php
    
    require_once __DIR__ . '/../models/Appointments.php';
require_once __DIR__ . '/../includes/auth.php';
require_once(__DIR__ . '/../controllers/PatientController.php');

    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    // Get the user ID from the session
    $id = $_SESSION['user_id'];

    // Prepare SQL statement to retrieve user info
    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id); // Bind user ID to the statement
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch user data
    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc(); // Fetch user data as an associative array
    } else {
        echo "No user found.";
        exit(); // Exit if no user is found
    }

    $appointmentQuery = "
    SELECT 
        a.time AS appointment_time, 
        a.status AS status,
        d.field AS specialty, 
        u.Name AS doctor_name 
    FROM 
        appointments AS a
    INNER JOIN 
        doctor AS d ON a.doctorID = d.doctor_id
    INNER JOIN 
        users AS u ON d.doctor_id = u.ID
    WHERE 
        a.patientID = ?
    ORDER BY 
        a.time ASC";
$appointmentStmt = $conn->prepare($appointmentQuery);
$appointmentStmt->bind_param("i", $id);
$appointmentStmt->execute();
$appointmentResult = $appointmentStmt->get_result();

    ?>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/theme.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center">Your Profile</h1>
    
    <!-- User Information Section -->
    <div id="user-info" class="mt-4">
        <h2>Personal Information</h2>
        <form id="profile-form">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" class="form-control" name="name" value="<?php echo htmlspecialchars($userData['Name']); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" class="form-control" name="email" value="<?php echo htmlspecialchars($userData['Email']); ?>" readonly>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" class="form-control" name="address" value="<?php echo htmlspecialchars($userData['Address']); ?>" readonly>
            </div>
            <button type="button" id="edit-btn" class="btn btn-primary mt-3" onclick="enableEditing()">Edit</button>
            <button type="button" id="edit-btn" class="btn btn-primary mt-3" onclick="window.location.href='Patient.php'">Home</button>
            <button type="submit" id="save-btn" class="btn btn-success mt-3" style="display:none;">Save</button>
            <button type="button" id="cancel-btn" class="btn btn-secondary mt-3" style="display:none;" onclick="disableEditing()">Cancel</button>
        </form>
    </div>
         <!-- Scheduled Appointments Section -->
    <div id="appointments-section" class="mt-5">
        <h2>Scheduled Appointments</h2>
        <?php if ($appointmentResult->num_rows > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Specialty</th>
                        <th>Doctor</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($appointment = $appointmentResult->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($appointment['appointment_time']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['specialty']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['doctor_name']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['status']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No appointments scheduled.</p>
        <?php endif; ?>
    </div>
</div>

<script>
// Enable editing of profile fields
function enableEditing() {
    document.getElementById('name').readOnly = false;
    document.getElementById('email').readOnly = false;
    document.getElementById('address').readOnly = false;
    document.getElementById('edit-btn').style.display = 'none';
    document.getElementById('save-btn').style.display = 'inline-block';
    document.getElementById('cancel-btn').style.display = 'inline-block';
}

// Disable editing and reset values
function disableEditing() {
    document.getElementById('name').readOnly = true;
    document.getElementById('email').readOnly = true;
    document.getElementById('address').readOnly = true;
    document.getElementById('edit-btn').style.display = 'inline-block';
    document.getElementById('save-btn').style.display = 'none';
    document.getElementById('cancel-btn').style.display = 'none';
    location.reload(); // Reload page to reset input fields
}

// Save updated info
$(document).ready(function() {
    $('#profile-form').on('submit', function(event) {
        event.preventDefault();
        
        $.ajax({
            url: 'updateProfile.php', // Server script to process update
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
    if (response.includes("successfully")) {
        alert(response); // Notify the user
        disableEditing(); // Switch back to read-only mode
    } else {
        alert(response); // Show the error message from PHP
    }
},
            error: function() {
                alert("An error occurred while updating profile.");
            }
        });
    });
});
</script>

</body>
</html>
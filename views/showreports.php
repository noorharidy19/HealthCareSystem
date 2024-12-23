<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once(__DIR__ . '/../includes/DB.php');
require_once(__DIR__ . '/../models/ReportModel.php');

// Get patient ID from the URL
$patientId = isset($_GET['id']) ? $_GET['id'] : 0;

// Fetch patient basic information from 'users' table
$patientQuery = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($patientQuery);
$stmt->bind_param("i", $patientId);
$stmt->execute();
$patientResult = $stmt->get_result();
$patient = $patientResult->fetch_assoc();
$stmt->close();

// Check if patient is found
if (!$patient) {
    echo "Patient not found.";
    exit();
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Debug: Show POST data received
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    // Handle medical history form submission
    if (isset($_POST['visit_date'])) {
        $visit_date = $_POST['visit_date'];
        $diagnosis = $_POST['diagnosis'];
        $medicines = $_POST['medicines'];
        $procedure = $_POST['procedure'];
        $recorded_by = $_POST['recorded_by'];
        $user_id = $_GET['id'];

        // Debugging the query before execution
        $query = "INSERT INTO medical_history (user_id, visit_date, diagnosis, medicines, procedure, recorded_by) VALUES (?, ?, ?, ?, ?, ?)";
        echo "Query: " . $query . "<br>"; // Output query
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            die('Prepare failed: ' . $conn->error);  // Debugging the prepare failure
        }

        $stmt->bind_param("isssss", $user_id, $visit_date, $diagnosis, $medicines, $procedure, $recorded_by);
        $execute = $stmt->execute();
        if (!$execute) {
            die('Execute failed: ' . $stmt->error);  // Debugging execute failure
        } else {
            $history_id = $stmt->insert_id; // Get the inserted history_id
            echo "Insert successful, history_id: " . $history_id . "<br>";  // Debugging insert success
        }
        $stmt->close();
    }

    // Handle scan form submission
    if (isset($_POST['scan_type']) && isset($history_id)) {
        $scan_type = $_POST['scan_type'];
        $file_path = $_POST['file_path'];
        $description = $_POST['description'];

        // Debugging the query before execution
        $query = "INSERT INTO scans (history_id, scan_type, file_path, description) VALUES (?, ?, ?, ?)";
        echo "Query: " . $query . "<br>"; // Output query
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            die('Prepare failed: ' . $conn->error);
        }
        $stmt->bind_param("isss", $history_id, $scan_type, $file_path, $description);
        if (!$stmt->execute()) {
            die('Execute failed: ' . $stmt->error);
        }
        echo "Scan added successfully!<br>";  // Debugging insert success
        $stmt->close();
    }

    // Handle attribute form submission
    if (isset($_POST['attribute_name']) && isset($history_id)) {
        $attribute_name = $_POST['attribute_name'];
        $unit = $_POST['unit'];
        $value = $_POST['value'];

        // Debugging the query before execution
        $query = "INSERT INTO dynamic_medical_attributes (history_id, attribute_name, unit, value) VALUES (?, ?, ?, ?)";
        echo "Query: " . $query . "<br>"; // Output query
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            die('Prepare failed: ' . $conn->error);
        }
        $stmt->bind_param("isss", $history_id, $attribute_name, $unit, $value);
        if (!$stmt->execute()) {
            die('Execute failed: ' . $stmt->error);
        }
        echo "Attribute added successfully!<br>";  // Debugging insert success
        $stmt->close();
    }

    // After data submission, we reload the data to reflect the new entries
    header("Location: " . $_SERVER['REQUEST_URI']); // Reload the page to show the new data
    exit();
}

// Fetch data for medical history, scans, and dynamic medical attributes
function fetchData($conn, $query, $param) {
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $param);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $data;
}

$medicalHistories = fetchData($conn, "SELECT * FROM medical_history WHERE user_id = ?", $patientId);
$scans = fetchData($conn, "SELECT * FROM scans WHERE history_id IN (SELECT history_id FROM medical_history WHERE user_id = ?)", $patientId);
$attributes = fetchData($conn, "SELECT * FROM dynamic_medical_attributes WHERE history_id IN (SELECT history_id FROM medical_history WHERE user_id = ?)", $patientId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Report</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <script src="../assets/js/jquery-3.5.1.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container">
    <h2 class="mt-4">Patient Summary</h2>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($patient['name']); ?></p>
    <p><strong>Gender:</strong> <?php echo htmlspecialchars($patient['gender']); ?></p>
    <p><strong>DOB:</strong> <?php echo htmlspecialchars($patient['dob']); ?></p>
    <p><strong>Address:</strong> <?php echo htmlspecialchars($patient['address']); ?></p>

    <!-- Display Medical History -->
    <h3>Medical History</h3>
    <button class="btn btn-primary" data-toggle="modal" data-target="#addHistoryModal">Add Medical History</button>
    <table class="table">
        <thead>
            <tr>
                <th>Visit Date</th>
                <th>Diagnosis</th>
                <th>Medicines</th>
                <th>Procedure</th>
                <th>Recorded By</th>
            </tr>
        </thead>
        <tbody id="medicalHistoryTable">
            <?php foreach ($medicalHistories as $history): ?>
                <tr>
                    <td><?php echo htmlspecialchars($history['visit_date']); ?></td>
                    <td><?php echo htmlspecialchars($history['diagnosis']); ?></td>
                    <td><?php echo htmlspecialchars($history['medicines']); ?></td>
                    <td><?php echo htmlspecialchars($history['procedure']); ?></td>
                    <td><?php echo htmlspecialchars($history['recorded_by']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Display Scans -->
    <h3>Scans</h3>
    <button class="btn btn-primary" data-toggle="modal" data-target="#addScanModal">Add Scan</button>
    <table class="table">
        <thead>
            <tr>
                <th>Scan Type</th>
                <th>File Path</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody id="scansTable">
            <?php foreach ($scans as $scan): ?>
                <tr>
                    <td><?php echo htmlspecialchars($scan['scan_type']); ?></td>
                    <td><?php echo htmlspecialchars($scan['file_path']); ?></td>
                    <td><?php echo htmlspecialchars($scan['description']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Display Dynamic Medical Attributes -->
    <h3>Dynamic Medical Attributes</h3>
    <button class="btn btn-primary" data-toggle="modal" data-target="#addAttributeModal">Add Attribute</button>
    <table class="table">
        <thead>
            <tr>
                <th>Attribute Name</th>
                <th>Unit</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody id="attributesTable">
            <?php foreach ($attributes as $attribute): ?>
                <tr>
                    <td><?php echo htmlspecialchars($attribute['attribute_name']); ?></td>
                    <td><?php echo htmlspecialchars($attribute['unit']); ?></td>
                    <td><?php echo htmlspecialchars($attribute['value']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modals -->
<!-- Add Medical History Modal -->
<div class="modal fade" id="addHistoryModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Medical History</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="addMedicalHistoryForm" method="POST">
                    <div class="form-group">
                        <label for="visit_date">Visit Date</label>
                        <input type="date" class="form-control" id="visit_date" name="visit_date" required>
                    </div>
                    <div class="form-group">
                        <label for="diagnosis">Diagnosis</label>
                        <input type="text" class="form-control" id="diagnosis" name="diagnosis" required>
                    </div>
                    <div class="form-group">
                        <label for="medicines">Medicines</label>
                        <input type="text" class="form-control" id="medicines" name="medicines" required>
                    </div>
                    <div class="form-group">
                        <label for="procedure">Procedure</label>
                        <input type="text" class="form-control" id="procedure" name="procedure" required>
                    </div>
                    <div class="form-group">
                        <label for="recorded_by">Recorded By</label>
                        <input type="text" class="form-control" id="recorded_by" name="recorded_by" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Scan Modal -->
<div class="modal fade" id="addScanModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Scan</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="addScanForm" method="POST">
                    <div class="form-group">
                        <label for="scan_type">Scan Type</label>
                        <input type="text" class="form-control" id="scan_type" name="scan_type" required>
                    </div>
                    <div class="form-group">
                        <label for="file_path">File Path</label>
                        <input type="text" class="form-control" id="file_path" name="file_path" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" class="form-control" id="description" name="description" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Attribute Modal -->
<div class="modal fade" id="addAttributeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Dynamic Medical Attribute</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="addAttributeForm" method="POST">
                    <div class="form-group">
                        <label for="attribute_name">Attribute Name</label>
                        <input type="text" class="form-control" id="attribute_name" name="attribute_name" required>
                    </div>
                    <div class="form-group">
                        <label for="unit">Unit</label>
                        <input type="text" class="form-control" id="unit" name="unit" required>
                    </div>
                    <div class="form-group">
                        <label for="value">Value</label>
                        <input type="text" class="form-control" id="value" name="value" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- jQuery and AJAX script -->
<script>
$(document).ready(function() {
    // AJAX submit for add medical history form
    $("#addMedicalHistoryForm").submit(function(e) {
        e.preventDefault(); // Prevent default form submission
        console.log("Medical history form submitted"); // Debugging line

        var form = $(this);
        $.ajax({
            type: "POST",
            url: window.location.href, // Send to the same page
            data: form.serialize(), // Serialize form data
            success: function(response) {
                console.log("Response received: ", response); // Debugging line
                alert("Medical History added successfully!");
                location.reload(); // Reload page to show updated data
            },
            error: function(xhr, status, error) {
                console.log("AJAX Error: ", status, error); // Debugging line
                alert("Error submitting the form.");
            }
        });
    });

    // AJAX submit for add scan form
    $("#addScanForm").submit(function(e) {
        e.preventDefault(); // Prevent default form submission
        console.log("Scan form submitted"); // Debugging line

        var form = $(this);
        $.ajax({
            type: "POST",
            url: window.location.href, // Send to the same page
            data: form.serialize(), // Serialize form data
            success: function(response) {
                console.log("Response received: ", response); // Debugging line
                alert("Scan added successfully!");
                location.reload(); // Reload page to show updated data
            },
            error: function(xhr, status, error) {
                console.log("AJAX Error: ", status, error); // Debugging line
                alert("Error submitting the form.");
            }
        });
    });

    // AJAX submit for add attribute form
    $("#addAttributeForm").submit(function(e) {
        e.preventDefault(); // Prevent default form submission
        console.log("Attribute form submitted"); // Debugging line

        var form = $(this);
        $.ajax({
            type: "POST",
            url: window.location.href, // Send to the same page
            data: form.serialize(), // Serialize form data
            success: function(response) {
                console.log("Response received: ", response); // Debugging line
                alert("Attribute added successfully!");
                location.reload(); // Reload page to show updated data
            },
            error: function(xhr, status, error) {
                console.log("AJAX Error: ", status, error); // Debugging line
                alert("Error submitting the form.");
            }
        });
    });
});
</script>
</body>
</html>

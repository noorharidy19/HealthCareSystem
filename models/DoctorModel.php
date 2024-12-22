<?php
require_once(__DIR__ . '/../models/UsersModel.php');
?>
<?php
class Doctor extends User {
    private $timeSlots = [];

    public function __construct($id) {
        parent::__construct($id);
    }

    public function addTimeSlot($startTime, $endTime) {
        $this->timeSlots[] = ['startTime' => $startTime, 'endTime' => $endTime];
    }

    public function getTimeSlots() {
        return $this->timeSlots;
    }

    public static function getDoctorById($doctorID) {
        global $conn; // Ensure the connection is available

        // Prepare the SQL statement
        $sql = "SELECT doctor_id, day, start_time, end_time, field FROM doctor WHERE doctor_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $doctorID);

        // Execute the query
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc(); // Return doctor information
        } else {
            return null; // No doctor found
        }
    }

    public static function addSlot($doctorId, $day, $startTime, $endTime,$filed) {
        // Ensure user is a doctor
        $stmt = $GLOBALS['conn']->prepare("SELECT UserType FROM users WHERE ID = ?");
        $stmt->bind_param("i", $doctorId);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user['UserType'] !== 'Doctor') {
            return false;
        }
        $currentDate = date("Y-m-d"); // Get today's date in YYYY-MM-DD format
        if ($day < $currentDate) {
            // Set a session error message for a past date
            $_SESSION['error'] = "You cannot add a slot for a past day. Please choose a future date.";
            return false; // Return false to indicate the error
        }
    

        // Prepare the SQL statement
        $sql = "INSERT INTO doctor (doctor_id, day, start_time, end_time,field) 
                VALUES ('$doctorId', '$day', '$startTime', '$endTime','$filed')";

        // Execute the query
        if (mysqli_query($GLOBALS['conn'], $sql)) {
            return true; // Slot added successfully
        } else {
            // Debugging: Print error message
            error_log("Failed to execute query: " . mysqli_error($GLOBALS['conn']));
            return false; // Failed to add slot
        }
    }

    
        public static function getDoctorFields() {
            global $conn; // Ensure the connection is available
    
            // Prepare the SQL statement to fetch distinct fields
            $sql = "SELECT DISTINCT field FROM doctor";
            $result = $conn->query($sql);
    
            $fields = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $fields[] = $row['field'];
                }
            }
            return $fields;
        }
    
        public static function getDoctorsByDepartment($department) {
            global $conn; // Ensure the connection is available
        
            // Prepare the SQL statement with an inner join and DISTINCT
            $sql = "SELECT DISTINCT d.doctor_id, u.name AS doctor_name 
                    FROM doctor d 
                    INNER JOIN users u ON d.doctor_id = u.id 
                    WHERE d.field = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $department);
            $stmt->execute();
            $result = $stmt->get_result();
        
            $doctors = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $doctors[] = $row;
                }
            }
            return $doctors;
        }
   
        public static function getSlotDetails($slot_id) {
            global $conn; // Ensure the connection is available
    
            // Prepare the SQL statement
            $sql = "SELECT day, start_time, end_time FROM doctor WHERE slot_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $slot_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $slotDetails = $result->fetch_assoc();
    
            // Concatenate the values into a single string with spacing
            if ($slotDetails) {
                return $slotDetails['day'] . ' ' . $slotDetails['start_time'] . ' ' . $slotDetails['end_time'];
            } else {
                return null;
            }
        }
    

        public static function getSlots($doctor_id) {
            // Fetch the available time slots for the doctor
            $sql = "SELECT slot_id, doctor_id, day, start_time, end_time FROM doctor WHERE doctor_id = ? ";
            $stmt = mysqli_prepare($GLOBALS['conn'], $sql);
            mysqli_stmt_bind_param($stmt, 'i', $doctor_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
    public static function getDoctors() {
        // Query to get all doctors with their names from the users table
        $sql = "SELECT d.doctor_id, u.Name AS doctor_name FROM doctor d
                JOIN users u ON d.doctor_id = u.ID
                WHERE u.UserType = 'doctor'";  // Ensure the user is a doctor
        $result = mysqli_query($GLOBALS['conn'], $sql);
        
        if (!$result) {
            error_log("Error fetching doctors: " . mysqli_error($GLOBALS['conn']));
            return []; // Return an empty array in case of failure
        }
    
        return mysqli_fetch_all($result, MYSQLI_ASSOC); // Returns an array of doctors
    }
    
    
    public static function getDoctorIdByName($doctorName) {
        global $conn; // Ensure the connection is available

        // Prepare the SQL statement
        $sql = "SELECT id FROM users WHERE name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $doctorName);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row ;
    }
}


?>
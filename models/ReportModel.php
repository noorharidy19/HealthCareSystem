<?php
require_once(__DIR__ . '/../includes/DB.php');

class DynamicMedicalAttributes
{
    private $conn;

    public function __construct()
    {
        global $conn;
        if (!$conn) {
            throw new Exception("Database connection not found. Check your DB.php configuration.");
        }
        $this->conn = $conn;
    }

    public function fetch($conditions = [])
    {
        $query = "SELECT * FROM dynamic_medical_attributes";
        if (!empty($conditions)) {
            $query .= " WHERE " . implode(' AND ', array_map(function ($key) {
                return "$key = '" . $key . "'";  // Ensure correct query syntax
            }, array_keys($conditions)));
        }

        $result = $this->conn->query($query);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function add($data)
    {
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_map(function ($key) {
            return "'" . $key . "'"; // Ensure correct query syntax
        }, array_keys($data)));

        $query = "INSERT INTO dynamic_medical_attributes ($columns) VALUES ($placeholders)";
        return $this->conn->query($query);
    }

    public function delete($conditions)
    {
        if (empty($conditions)) {
            throw new InvalidArgumentException("Conditions cannot be empty for delete operation.");
        }

        $query = "DELETE FROM dynamic_medical_attributes WHERE " . implode(' AND ', array_map(function ($key) {
            return "$key = '" . $key . "'";  // Ensure correct query syntax
        }, array_keys($conditions)));

        return $this->conn->query($query);
    }
}

class MedicalHistory
{
    private $conn;

    public function __construct()
    {
        global $conn;
        if (!$conn) {
            throw new Exception("Database connection not found. Check your DB.php configuration.");
        }
        $this->conn = $conn;
    }

    public function fetch($conditions = [])
    {
        $query = "SELECT * FROM medical_history";
        if (!empty($conditions)) {
            $query .= " WHERE " . implode(' AND ', array_map(function ($key) {
                return "$key = '" . $key . "'";  // Ensure correct query syntax
            }, array_keys($conditions)));
        }

        $result = $this->conn->query($query);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function add($data)
    {
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_map(function ($key) {
            return "'" . $key . "'"; // Ensure correct query syntax
        }, array_keys($data)));

        $query = "INSERT INTO medical_history ($columns) VALUES ($placeholders)";
        return $this->conn->query($query);
    }

    public function delete($conditions)
    {
        if (empty($conditions)) {
            throw new InvalidArgumentException("Conditions cannot be empty for delete operation.");
        }

        $query = "DELETE FROM medical_history WHERE " . implode(' AND ', array_map(function ($key) {
            return "$key = '" . $key . "'";  // Ensure correct query syntax
        }, array_keys($conditions)));

        return $this->conn->query($query);
    }
}

class Scans
{
    private $conn;

    public function __construct()
    {
        global $conn;
        if (!$conn) {
            throw new Exception("Database connection not found. Check your DB.php configuration.");
        }
        $this->conn = $conn;
    }

    public function fetch($conditions = [])
    {
        $query = "SELECT * FROM scans";
        if (!empty($conditions)) {
            $query .= " WHERE " . implode(' AND ', array_map(function ($key) {
                return "$key = '" . $key . "'";  // Ensure correct query syntax
            }, array_keys($conditions)));
        }

        $result = $this->conn->query($query);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function add($data)
    {
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_map(function ($key) {
            return "'" . $key . "'"; // Ensure correct query syntax
        }, array_keys($data)));

        $query = "INSERT INTO scans ($columns) VALUES ($placeholders)";
        return $this->conn->query($query);
    }

    public function delete($conditions)
    {
        if (empty($conditions)) {
            throw new InvalidArgumentException("Conditions cannot be empty for delete operation.");
        }

        $query = "DELETE FROM scans WHERE " . implode(' AND ', array_map(function ($key) {
            return "$key = '" . $key . "'";  // Ensure correct query syntax
        }, array_keys($conditions)));

        return $this->conn->query($query);
    }
}
?>

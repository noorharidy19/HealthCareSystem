<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Start the session if it is not already started
}

// Your database connection code here

$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "healthsystem"; // Replace with your database name

// Create connection
$GLOBALS['conn'] = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($GLOBALS['conn']->connect_error) {
    die("Connection failed: " . $GLOBALS['conn']->connect_error);
}
?>


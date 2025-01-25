<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "voter_registration";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Select database
$conn->select_db($database);
?>

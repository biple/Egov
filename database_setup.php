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

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS $database";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

// Select database
$conn->select_db($database);

// SQL to create table
$sql = "CREATE TABLE IF NOT EXISTS voter_details (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(30) NOT NULL,
    middle_name VARCHAR(30),
    last_name VARCHAR(30) NOT NULL,
    dob_gregorian DATE,
    dob_nepali VARCHAR(20),
    gender ENUM('male', 'female', 'other') NOT NULL,
    id_number VARCHAR(20) NOT NULL,
    parent_first_name VARCHAR(30) NOT NULL,
    parent_middle_name VARCHAR(30),
    parent_last_name VARCHAR(30) NOT NULL,
    has_spouse ENUM('yes', 'no') NOT NULL,
    spouse_first_name VARCHAR(30),
    spouse_middle_name VARCHAR(30),
    spouse_last_name VARCHAR(30),
    permanent_address VARCHAR(255) NOT NULL,
    permanent_city VARCHAR(50) NOT NULL,
    permanent_state VARCHAR(50) NOT NULL,
    temporary_address VARCHAR(255) NOT NULL,
    temporary_city VARCHAR(50) NOT NULL,
    temporary_state VARCHAR(50) NOT NULL
)";

// Execute SQL query
if ($conn->query($sql) === TRUE) {
    echo "Table voter_details created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

// Close connection
$conn->close();
?>

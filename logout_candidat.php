<?php
// Start or resume a session
session_start();

// Database connection variables
$servername = "localhost";
$username = "root"; // Your DB username
$password = ""; // Your DB password
$dbname = "RECRUTEMENT"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL to truncate table
$sql = "TRUNCATE TABLE temporary_candidats";

if ($conn->query($sql) === TRUE) {
    echo "Table temporary_candidats truncated successfully";
} else {
    echo "Error truncating table: " . $conn->error;
}

// Close the connection
$conn->close();

// Optionally, clear the session
session_unset(); // remove all session variables
session_destroy(); // destroy the session

// Redirect to a specified page after the operation
header('Location: login.html'); // Adjust the location to your login page or wherever you wish to redirect
exit();
?>

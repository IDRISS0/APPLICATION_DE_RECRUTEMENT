<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "recrutement";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// SQL to truncate table
$sql = "TRUNCATE TABLE temporary_recruters";

if ($conn->query($sql) === TRUE) {
  echo "Table temporary_recruters truncated successfully";
} else {
  echo "Error truncating table: " . $conn->error;
}

$conn->close();

// Redirect to a specific page after truncating the table
header('Location: login.html'); // Adjust the location as needed
exit();
?>

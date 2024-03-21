<?php
// Database connection parameters
$servername = "localhost";
$username = "root"; // Update with your MySQL username
$password = ""; // Update with your MySQL password
$dbname = "RECRUTEMENT";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$domain = isset($_POST['domaine']) ? $_POST['domaine'] : '';
$city = isset($_POST['ville']) ? $_POST['ville'] : '';
$level = isset($_POST['niveau_etude']) ? $_POST['niveau_etude'] : '';

// Prepare the SQL query based on filters, if any
$query = "SELECT * FROM emplois WHERE ('' = ? OR domain = ?) AND ('' = ? OR city = ?) AND ('' = ? OR level = ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssss", $domain, $domain, $city, $city, $level, $level);
$stmt->execute();
$result = $stmt->get_result();

$emplois = [];

while($row = $result->fetch_assoc()) {
    $emplois[] = $row;
}

$stmt->close();
$conn->close();
?>

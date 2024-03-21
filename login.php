<?php
session_start();
$conn = new mysqli("localhost", "root", "", "RECRUTEMENT");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $conn->real_escape_string($_POST['email']);
$password = $conn->real_escape_string($_POST['password']); // Assuming 'mdp' is the password field
$role = $_POST['role'];

if ($role == 'candidat') {
    $query = $conn->prepare("SELECT * FROM candidates WHERE email = ? AND mdp = ?");
    $redirectPage = 'MENU_CANDIDAT.html';
    // Corrected the table name from 'candidat_temporaire' to 'temporary_candidats'
    $tempTableQuery = "INSERT INTO temporary_candidats (first_name, last_name, phone, email, country, city, mdp) 
                       SELECT first_name, last_name, phone, email, country, city, mdp 
                       FROM candidates WHERE email = ?";
} else { // For recruteur
    $query = $conn->prepare("SELECT * FROM recruteurs WHERE email = ? AND mdp = ?");
    $redirectPage = 'MENU_RECRUTEUR.html';
    // This query is correct; assumes 'temporary_recruters' exists
    $tempTableQuery = "INSERT INTO temporary_recruters (first_name, last_name, phone, email, country, city, mdp) 
                       SELECT first_name, last_name, phone, email, country, city, mdp 
                       FROM recruteurs WHERE email = ?";
}

$query->bind_param("ss", $email, $password);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $_SESSION['user'] = $user; // Storing user data in session
    
    // Prepare the temporary table insert query based on the role
    $tempQuery = $conn->prepare($tempTableQuery);
    $tempQuery->bind_param("s", $email);
    $tempQuery->execute();

    header("Location: $redirectPage");
} else {
    header('Location: erreur_login.html');
}

$conn->close();
?>

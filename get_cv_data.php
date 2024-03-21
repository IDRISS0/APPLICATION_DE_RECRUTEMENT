<?php
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "cv_database";

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Récupération des données des CVs
$sql = "SELECT * FROM cv ORDER BY score ASC";
$result = $conn->query($sql);

// Fermer la connexion à la base de données
$conn->close();

// Stocker les données dans un tableau
$cv_data = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $cv_data[] = $row;
    }
}

// Envoyer les données au fichier HTML
echo json_encode($cv_data);
?>
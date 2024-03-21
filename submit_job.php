<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "RECRUTEMENT";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assume form fields are properly set
$titre = $conn->real_escape_string($_POST['titre']);
$description = $conn->real_escape_string($_POST['description']);
$city = $conn->real_escape_string($_POST['city']);
$domain = $conn->real_escape_string($_POST['domain']);
$level = $conn->real_escape_string($_POST['level']);
$email_recruteur = $conn->real_escape_string($_POST['email']);

// Handle file upload
$target_dir = "uploads/";
$pic = $target_dir . basename($_FILES["pic"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($pic, PATHINFO_EXTENSION));

// Attempt to upload file
if (move_uploaded_file($_FILES["pic"]["tmp_name"], $pic)) {
    // File upload success, proceed to insert job into the database
    $stmt = $conn->prepare("INSERT INTO emplois (titre, description, city, domain, level, email_recruteur, pic) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $titre, $description, $city, $domain, $level, $email_recruteur, $pic);

    if ($stmt->execute()) {
        $message = "L'emploi a été posté avec succès";
    } else {
        $message = "Erreur lors de la publication de l'emploi";
    }
    $stmt->close();
} else {
    $message = "Erreur lors de l'upload de l'image";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .message-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .btn {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="message-container">
        <p><?= $message; ?></p>
        <a href="post_job.html" class="btn">Précédent</a>
    </div>
</body>
</html>

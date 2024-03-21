<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "RECRUTEMENT");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the first candidate's email from temporary_candidats table as an example
$sql = "SELECT email FROM temporary_candidats LIMIT 1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $candidateEmail = $row['email'];
} else {
    die("No candidate found in temporary_candidats.");
}

$jobId = $_GET['job_id'] ?? null;
$recruteurEmail = $_GET['recruteur_email'] ?? null;

$message = "";

// Check if we have all necessary information
if ($jobId && $recruteurEmail) {
    try {
        // Insert into candidatures table
        $stmt = $conn->prepare("INSERT INTO candidatures (candidat, recruteur) VALUES (?, ?)");
        $stmt->bind_param("ss", $candidateEmail, $recruteurEmail);
        $stmt->execute();

        $message = "Candidature réussie.";
    } catch (mysqli_sql_exception $e) {
        // Check for duplicate entry error code
        if ($e->getCode() === 1062) {
            $message = "Vous avez déjà postulé à cette offre.";
        } else {
            $message = "Erreur lors de la candidature: " . $e->getMessage();
        }
    }
} else {
    $message = "Informations manquantes pour la candidature.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Status de la Candidature</title>
    <style>
        /* Style definitions as provided in the previous response */
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
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .message {
            font-size: 20px;
            margin-bottom: 20px;
        }
        .btn {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="message-container">
        <p class="message"><?= htmlspecialchars($message) ?></p>
        <button class="btn" onclick="window.history.back();">Précédent</button>
    </div>
</body>
</html>

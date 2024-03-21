<?php
session_start();

$pdo = new PDO('mysql:host=localhost;dbname=RECRUTEMENT', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Fetch the candidate's email from 'temporary_candidats'
$stmt = $pdo->query("SELECT email FROM temporary_candidats LIMIT 1");
$candidateEmail = $stmt->fetchColumn();

if (empty($candidateEmail)) {
    echo "Candidate email not found.";
    exit;
}

$jobId = $_POST['job_id'] ?? null;
if (!$jobId) {
    echo "Job ID not specified.";
    exit;
}

$stmt = $pdo->prepare("SELECT email_recruteur FROM emplois WHERE id = ?");
$stmt->execute([$jobId]);
$recruteurEmail = $stmt->fetchColumn();

if (!$recruteurEmail) {
    echo "Recruiter email not found for the specified job.";
    exit;
}

$insertStmt = $pdo->prepare("INSERT INTO candidatures (candidat, recruteur) VALUES (?, ?)");

try {
    $insertStmt->execute([$candidateEmail, $recruteurEmail]);
    $message = "Candidature ajoutée avec succès.";
} catch (PDOException $e) {
    if ($e->getCode() == 23000) {
        $message = "Vous avez déjà envoyé cette candidature à ce recruteur.";
    } else {
        $message = "Une erreur s'est produite.";
    }
}

echo "<!DOCTYPE html>
<html lang='fr'>
<head>
    <meta charset='UTF-8'>
    <title>Statut de la candidature</title>
    <style>
        body { font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .message-box { text-align: center; }
        .message { font-size: 20px; margin-bottom: 20px; }
        .button { background-color: #4CAF50; color: white; padding: 10px 20px; text-align: center; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; text-decoration: none; }
    </style>
</head>
<body>
    <div class='message-box'>
        <p class='message'>$message</p>
        <a href='view_jobs.php' class='button'>Retour</a>
    </div>
</body>
</html>";
?>

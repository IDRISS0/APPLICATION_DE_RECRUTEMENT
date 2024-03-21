<?php
include 'db.php'; // Include your database connection

// Fetch the most recent candidate's email from temporary_candidates table
$emailQuery = "SELECT email FROM temporary_candidats ORDER BY id DESC LIMIT 1";
$emailResult = $conn->query($emailQuery);

if ($emailResult->num_rows > 0) {
    $row = $emailResult->fetch_assoc();
    $candidateEmail = $row['email']; // Use this email as the sender's email
} else {
    showMessage("ERREUR", false);
    exit;
}

// Retrieve the recruiter's email and the message from the form submission
$recruiterEmail = $_POST['recruiter_email'] ?? '';
$message = $_POST['message'] ?? '';

// Prepare and execute the insert operation for the message
$stmt = $conn->prepare("INSERT INTO messages (sender_mail, receiver_email, message, timestamp) VALUES (?, ?, ?, NOW())");
$stmt->bind_param("sss", $candidateEmail, $recruiterEmail, $message);

if ($stmt->execute()) {
    showMessage("Votre message a été envoyé avec succès", true);
} else {
    showMessage("Error: " . $stmt->error, false);
}

$stmt->close();
$conn->close();

function showMessage($message, $isSuccess) {
    $color = $isSuccess ? "#4CAF50" : "#f44336"; // Green for success, red for error
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Message Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
        }
        .message-box {
            text-align: center;
            padding: 20px;
            border-radius: 5px;
            background-color: $color;
            color: white;
            width: 90%;
            max-width: 400px;
        }
        .btn-retour {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #008CBA;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
    </head>
    <body>
        <div class='message-box'>
            <p>$message</p>
            <a href='javascript:history.back()' class='btn-retour'>Retour</a>
        </div>
    </body>
    </html>";
}
?>

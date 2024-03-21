<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "RECRUTEMENT");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the most recent recruiter's email from the temporary_recruteurs table
$recruiterQuery = "SELECT email FROM temporary_recruters ORDER BY id DESC LIMIT 1";
$recruiterResult = $conn->query($recruiterQuery);

if ($recruiterResult->num_rows > 0) {
    $recruiterRow = $recruiterResult->fetch_assoc();
    $recruiterEmail = $recruiterRow['email'];
} else {
    die("Recruiter email not found.");
}

// Assume the candidate's email is passed as a query parameter
$candidateEmail = isset($_GET['candidate_email']) ? $_GET['candidate_email'] : '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($candidateEmail) && !empty($recruiterEmail)) {
    // Retrieve the message from the form submission
    $message = $conn->real_escape_string($_POST['message']);

    // Insert the message into the messages table
    $insertMessageQuery = "INSERT INTO messages (sender_mail, receiver_email, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insertMessageQuery);
    $stmt->bind_param("sss", $recruiterEmail, $candidateEmail, $message);
    
    if ($stmt->execute()) {
        // Message sent successfully, show styled message
        echo '<!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>Message Envoyé</title>
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
                .message-box {
                    background: #fff;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 2px 4px rgba(0,0,0,.2);
                    text-align: center;
                }
                .btn-retour {
                    display: inline-block;
                    margin-top: 20px;
                    padding: 10px 20px;
                    background-color: #007bff;
                    color: white;
                    text-decoration: none;
                    border-radius: 4px;
                    cursor: pointer;
                }
                .btn-retour:hover {
                    background-color: #0056b3;
                }
            </style>
        </head>
        <body>
            <div class="message-box">
                <p>Message envoyé avec succès!</p>
                <a href="javascript:history.back()" class="btn-retour">Retour</a>
            </div>
        </body>
        </html>';
    } else {
        echo "Error sending message: " . $conn->error;
    }
    $stmt->close();
} else {
    // Form for sending a message
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Envoyer Message</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                padding: 20px;
                display: flex;
                justify-content: center;
            }
            form {
                width: 100%;
                max-width: 500px;
            }
            textarea {
                width: 100%;
                height: 100px;
                margin-bottom: 10px;
            }
            input[type="submit"] {
                padding: 10px 20px;
                background-color: #007bff;
                color: white;
                border: none;
                cursor: pointer;
            }
        </style>
    </head>
    <body>
        <form method="POST">
            <textarea name="message" placeholder="Tapez votre message ici"></textarea><br>
            <input type="submit" value="Envoyer le message">
        </form>
    </body>
    </html>
    <?php
}
$conn->close();
?>

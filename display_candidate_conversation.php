<?php
// Connection to the database
$conn = new mysqli("localhost", "root", "", "RECRUTEMENT");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get recruiter and candidate email from the URL parameter
$recruiterEmail = $_GET['recruiter_email'] ?? '';
$candidateEmail = $_GET['candidate_email'] ?? '';

// Fetch messages
$query = "SELECT * FROM messages WHERE 
          (sender_mail = ? AND receiver_email = ?) OR 
          (sender_mail = ? AND receiver_email = ?) 
          ORDER BY timestamp ASC";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssss", $recruiterEmail, $candidateEmail, $candidateEmail, $recruiterEmail);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Conversation</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .message {
        background-color: #e7e7e7;
        margin: 5px 0;
        padding: 10px 15px;
        border-radius: 20px;
        width: fit-content;
        max-width: 80%;
        border: none;
        box-shadow: 0 1px 1px rgba(0,0,0,0.1);
    }
    .sender {
        font-weight: bold;
    }
    .content {
        margin-top: 5px;
    }
    .message.candidate {
        background-color: #007bff;
        color: white;
        align-self: flex-end;
    }
</style>
</head>
<body>

<h2>Conversation with <?= htmlspecialchars($recruiterEmail); ?></h2>
<div class="messages-container">
    <?php
    while ($row = $result->fetch_assoc()) {
        $class = $row['sender_mail'] === $candidateEmail ? 'candidate' : '';
        echo "<div class='message $class'><span class='sender'>" . htmlspecialchars($row['sender_mail']) . ":</span><div class='content'>" . htmlspecialchars($row['message']) . "</div></div>";
    }
    ?>
</div>

</body>
</html>

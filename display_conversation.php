<?php
if (!isset($_GET['recruiter_email']) || !isset($_GET['candidate_email'])) {
    echo "Required parameters not provided.";
    exit;
}

$recruiterEmail = $_GET['recruiter_email'];
$candidateEmail = $_GET['candidate_email'];

// Database connection
$conn = new mysqli("localhost", "root", "", "RECRUTEMENT");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT * FROM messages WHERE (sender_mail = ? AND receiver_email = ?) OR (sender_mail = ? AND receiver_email = ?) ORDER BY timestamp ASC";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssss", $candidateEmail, $recruiterEmail, $recruiterEmail, $candidateEmail);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Conversation</title>
    <style>
        /* Add a border to the entire page */
body {
    border: 4px solid #007bff; /* Adjust the color as needed */
    margin: 8px; /* Adjust based on your preference and to ensure the border is visible */
    font-family: Arial, sans-serif; /* Specify the font family */
}

/* Increase the font size for all text elements */
html {
    font-size: 18px; /* This increases the base font size; adjust as needed */
}

h1, h2, h3, h4, h5, h6, p, li, a {
    font-size: 3em; /* This sets the font size relative to the base font size defined on the html element */
color:gray;

}

/* Optionally, adjust the font size for specific elements further, if needed */
h1 {
    font-size: 2em; /* Makes <h1> text twice as large as the base size */
}

p {
    font-size: 1.2em; /* Makes paragraph text slightly larger than the base size */
}

a {
    font-size: 1em; /* Adjust the font size for links as needed */
    text-decoration: none; /* Optional: removes underline from links */
}

/* Ensure the anchor tags (links) are clearly visible */
a:hover {
    text-decoration: underline; /* Re-add underline on hover for better visibility */
    color: #0056b3; /* Change link color on hover */
}

    </style>
</head>
<body>

<h2>Conversation</h2>
<div class="messages-container">
    <?php while ($message = $result->fetch_assoc()): ?>
        <div>
            <strong><?= htmlspecialchars($message['sender_mail']) ?>:</strong>
            <?= htmlspecialchars($message['message']) ?><br>
            <em><?= $message['timestamp'] ?></em>
        </div>
    <?php endwhile; ?>
</div>

</body>
</html>
<?php $conn->close(); ?>

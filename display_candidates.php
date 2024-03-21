<?php
// Connection to the database
$conn = new mysqli("localhost", "root", "", "RECRUTEMENT");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the recruiter's email from temporary_recruters
$emailQuery = "SELECT email FROM temporary_recruters ORDER BY id DESC LIMIT 1";
$emailResult = $conn->query($emailQuery);
$recruiterEmail = $emailResult->fetch_assoc()['email'];

// Fetch candidates
$query = "SELECT DISTINCT CASE WHEN sender_mail = ? THEN receiver_email ELSE sender_mail END AS candidate_email 
          FROM messages 
          WHERE sender_mail = ? OR receiver_email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("sss", $recruiterEmail, $recruiterEmail, $recruiterEmail);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>LISTE DE CANDIDATS</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .candidate-item {
        background-color: #007bff;
        color: white;
        margin: 5px 0;
        padding: 10px 15px;
        border-radius: 5px;
        text-align: center;
        cursor: pointer;
        border: none;
        transition: background-color 0.3s;
        width: 100%;
        max-width: 300px;
    }
    .candidate-item:hover {
        background-color: #0056b3;
    }
    a {
        text-decoration: none;
    }

    body, html {
    height: 100%;
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #f0f6fc; /* Light background color */
}

body {
    width: 100vw;
    height: 100vh;
    border: 10px solid #007bff; /* A beautiful blue border */
    box-sizing: border-box; /* Ensures the border width doesn't add to the total width/height */
    padding: 20px; /* Spacing between the content and the border */
    background-color: #ffffff; /* White background for the content area */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Soft shadow for a subtle 3D effect */
}

.container {
    text-align: center; /* Center aligns the text within the container */
    max-width: 80%; /* Limits the maximum width of the container */
}

/* Optional: Style for heading and paragraph for demonstration */
h1, p {
    color: #333; /* Dark text color for contrast */
    margin: 10px 0; /* Vertical spacing between elements */
}

/* Optional: Style for links/buttons to match the page's aesthetic */


</style>
</head>
<body>


<div class="candidates-container">
    <?php
    while ($row = $result->fetch_assoc()) {
        $candidateEmail = htmlspecialchars($row['candidate_email']);
        echo "<a href='display_conversation.php?candidate_email={$candidateEmail}&recruiter_email={$recruiterEmail}' style='text-decoration:none;'>";
        echo "<div class='candidate-item'>" . $candidateEmail . "</div>";
        echo "</a>";
    }
    ?>
</div>

</body>
</html>

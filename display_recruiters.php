<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "RECRUTEMENT");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetching the candidate's email from temporary_candidats
$emailRecruiter="";
$emailQuery = "SELECT email FROM temporary_candidats ORDER BY id DESC LIMIT 1";
$emailResult = $conn->query($emailQuery);
if ($emailResult->num_rows > 0) {
    $emailRow = $emailResult->fetch_assoc();
    $candidateEmail = $emailRow['email'];
} else {
    echo "Candidate email not found.";
    exit;
}

// Now, use $candidateEmail to fetch the list of recruiters
$query = "SELECT DISTINCT receiver_email FROM messages WHERE sender_mail = ? UNION DISTINCT SELECT sender_mail FROM messages WHERE receiver_email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $candidateEmail, $candidateEmail);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des recruteurs</title>
    <style>
        /* Style for link buttons */
a {
    display: inline-block; /* Allows setting padding and other box model properties */
    padding: 10px 20px; /* Adjust the padding to control the button size */
    background-color: #007bff; /* Blue background color for the button */
    color: white; /* Text color */
    text-decoration: none; /* Removes the underline from links */
    border-radius: 5px; /* Adds rounded corners to the buttons */
    font-weight: bold; /* Makes the text bold */
    text-align: center; /* Ensures text is centered within the button */
    transition: background-color 0.3s, transform 0.2s; /* Smooth transition for hover effects */
}

/* Hover effect for buttons */
a:hover {
    background-color: #0056b3; /* Darker blue on hover */
    transform: scale(1.05); /* Slightly enlarges the button on hover */
    color: #ffffff; /* Keeps text color white on hover */
}

/* Optional: Focus style for accessibility */
a:focus {
    outline: 2px solid #0056b3; /* Adds an outline to improve accessibility */
    outline-offset: 2px; /* Distance between outline and element */
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
a {
    background-color: #007bff; /* Matching the border color */
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 5px;
    display: inline-block; /* Allows padding and margins on anchor elements */
    margin-top: 20px; /* Spacing above the first link/button */
}

    </style>
</head>
<body>


<div class="recruiters-container">
    <?php while ($row = $result->fetch_assoc()): ?>
        <?php $recruiterEmail = $row['receiver_email']; // Or sender_mail based on your logic ?>
        <a href="display_conversation.php?recruiter_email=<?= urlencode($recruiterEmail) ?>&candidate_email=<?= urlencode($candidateEmail) ?>">
            <?= htmlspecialchars($recruiterEmail) ?>
        </a><br>
    <?php endwhile; ?>
</div>

</body>
</html>
<?php $conn->close(); ?>

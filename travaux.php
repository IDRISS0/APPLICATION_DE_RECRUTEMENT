<?php
session_start(); // Start a new session or resume the current session

// Connection to the database
$conn = new mysqli("localhost", "root", "", "RECRUTEMENT");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



$userEmail = $_SESSION['user_email'];

// Handle job application submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['emploiId'])) {
    $emploiId = $_POST['emploiId'];
    // Check if the application already exists
    $checkApplication = $conn->prepare("SELECT * FROM candidatures WHERE emploiId = ? AND candidat = ?");
    $checkApplication->bind_param("is", $emploiId, $userEmail);
    $checkApplication->execute();
    $applicationResult = $checkApplication->get_result();
    if ($applicationResult->num_rows == 0) {
        // Insert new application
        $insertApplication = $conn->prepare("INSERT INTO candidatures (emploiId, candidat) VALUES (?, ?)");
        $insertApplication->bind_param("is", $emploiId, $userEmail);
        if (!$insertApplication->execute()) {
            echo "Error applying for job: " . $conn->error;
        }
    }
    // Redirect back to travaux.php to avoid form re-submission issues
    header("Location: travaux.php");
    exit();
}

// Fetching job posts from the database
$sql = "SELECT * FROM emplois";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page</title>
    <!-- Include your CSS here -->
</head>
<body>
    <h1>Liste des offres d'emploi</h1>
    <div class="container">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                // Re-check if the candidate has already applied for this job (needed after potential POST request)
                $checkApplication->execute();
                $applicationResult = $checkApplication->get_result();
                $hasApplied = $applicationResult->num_rows > 0;
                
                echo "<div class='offre'>";
                echo "<img src='" . $row["pic"] . "' alt='Image'>";
                echo "<h2>" . $row["titre"] . "</h2>";
                echo "<p>" . $row["description"] . "</p>";
                if (!$hasApplied) {
                    echo "<form method='post'>";
                    echo "<input type='hidden' name='emploiId' value='" . $row["id"] . "'>";
                    echo "<button type='submit'>Postuler</button>";
                    echo "</form>";
                } else {
                    echo "<button disabled>Already Applied</button>";
                }
                echo "<button onclick=\"window.location.href='chat.html'\">Chatter</button>";
                echo "</div>";
            }
        } else {
            echo "No job posts found.";
        }
        $conn->close();
        ?>
    </div>
</body>
</html>

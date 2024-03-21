<?php
// Connect to MySQL
$conn = new mysqli("localhost", "root", "", "RECRUTEMENT");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect and sanitize email
$email = $conn->real_escape_string($_POST['email']);

// Check if the email already exists
$emailCheckQuery = "SELECT email FROM recruteurs WHERE email = ?";
$stmt = $conn->prepare($emailCheckQuery);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows > 0) {
    // Email already exists, redirect to error page
    header('Location: erreur_sign_up.html');
    exit();
}

// Assume the email is not found, continue with the insertion
$first_name = $conn->real_escape_string($_POST['first_name']);
$last_name = $conn->real_escape_string($_POST['last_name']);
$phone = $conn->real_escape_string($_POST['phone']);
$country = $conn->real_escape_string($_POST['country']);
$city = $conn->real_escape_string($_POST['city']);
$diploma = $conn->real_escape_string($_POST['diploma']);ring($_POST['mdp']);


// Prepare an insert statement
$sql = $conn->prepare("INSERT INTO candidates (first_name, last_name, phone, email, country,  mdp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

// Bind variables to the prepared statement as parameters
$sql->bind_param("sssssssissss", $first_name, $last_name, $phone, $email, $country, $city,  $mdp);

// Attempt to execute the prepared statement
if($sql->execute()) {
    // Upload image
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // Redirect to success page after successful record creation and file upload
        header('Location: succes_sign_up.html');
    } else {
        // File upload failed but record was created, handle accordingly
        header('Location: erreur_sign_up.html');
    }
} else {
    // Redirect to error page if record creation failed
    header('Location: erreur_sign_up.html');
}

// Close statement and connection
$stmt->close();
$sql->close();
$conn->close();
exit();
?>

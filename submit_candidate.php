<?php
$conn = new mysqli("localhost", "root", "", "RECRUTEMENT");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$email = $conn->real_escape_string($_POST['email']);
$emailCheckQuery = "SELECT email FROM candidates WHERE email = ?";
$stmt = $conn->prepare($emailCheckQuery);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows > 0) {
    header('Location: erreur_sign_up.html');
    exit();
}
$first_name = $conn->real_escape_string($_POST['first_name']);
$last_name = $conn->real_escape_string($_POST['last_name']);
$phone = $conn->real_escape_string($_POST['phone']);
$country = $conn->real_escape_string($_POST['country']);
$city = $conn->real_escape_string($_POST['city']);
$diploma = $conn->real_escape_string($_POST['diploma']);
$institution = $conn->real_escape_string($_POST['institution']);
$experience = is_numeric($_POST['experience']) ? $_POST['experience'] : 0;
$last_job = $conn->real_escape_string($_POST['last_job']);
$mdp = $conn->real_escape_string($_POST['mdp']);
$description = $conn->real_escape_string($_POST['description']);
$image_path = "uploads/" . basename($_FILES["image"]["name"]);
$sql = $conn->prepare("INSERT INTO candidates (first_name, last_name, phone, email, country, city, diploma, institution, experience, domaine, image_path, description, mdp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$sql->bind_param("sssssssisssss", $first_name, $last_name, $phone, $email, $country, $city, $diploma, $institution, $experience, $last_job, $image_path, $description, $mdp);
if($sql->execute()) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        header('Location: succes_sign_up.html');
    } else {
        header('Location: erreur_sign_up.html');
    }
} else {
    header('Location: erreur_sign_up.html');
}
$stmt->close();
$sql->close();
$conn->close();
exit();
?>

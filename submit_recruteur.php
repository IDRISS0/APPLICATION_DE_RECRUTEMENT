<?php
$conn = new mysqli("localhost", "root", "", "RECRUTEMENT");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$email = $conn->real_escape_string($_POST['email']);
$emailCheckQuery = "SELECT email FROM recruteurs WHERE email = ?";
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
$mdp = $conn->real_escape_string($_POST['mdp']);
$sql = $conn->prepare("INSERT INTO recruteurs (first_name, last_name, phone, email, country, city, mdp) VALUES (?, ?, ?, ?, ?, ?, ?)");
$sql->bind_param("sssssss", $first_name, $last_name, $phone, $email, $country, $city, $mdp);
if($sql->execute()) {
    header('Location: succes_sign_up.html');
} else {
    header('Location: erreur_sign_up.html');
}
$stmt->close();
$sql->close();
$conn->close();
exit();
?>

<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "RECRUTEMENT");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$country = isset($_POST['country']) ? $conn->real_escape_string($_POST['country']) : '';
$city = isset($_POST['city']) ? $conn->real_escape_string($_POST['city']) : '';
$level = isset($_POST['level']) ? $conn->real_escape_string($_POST['level']) : '';
$domain = isset($_POST['domain']) ? $conn->real_escape_string($_POST['domain']) : '';

$query = "SELECT * FROM candidates WHERE (country LIKE '%$country%' OR ? = '') AND (city LIKE '%$city%' OR ? = '') AND (diploma LIKE '%$level%' OR ? = '') AND (domaine LIKE '%$domain%' OR ? = '')";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssss", $country, $city, $level, $domain);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>CHERCHER CANDIDATS</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
            margin: 20px auto;
            border: 2px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            max-width: 800px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .filter-form {
            display: flex;
            justify-content: space-between;
            padding: 15px;
            background: #e9ecef;
            border-radius: 5px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .filter-form > * {
            margin: 5px;
            flex-grow: 1;
            min-width: 120px;
        }
        input[type="text"], input[type="submit"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
        }
        input[type="submit"] {
            cursor: pointer;
            background-color: #28a745;
            color: white;
            border: none;
            width: auto;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .candidate {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
        }
        .candidate img {
            margin-right: 20px;
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }
        .candidate-details {
            flex-grow: 1;
        }
        .btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h2>CHERCHER CANDIDATS</h2>
    <form class="filter-form" action="explore_candidates.php" method="post">
        <input type="text" id="country" name="country" placeholder="Pays" value="<?= htmlspecialchars($country) ?>">
        <input type="text" id="city" name="city" placeholder="Ville" value="<?= htmlspecialchars($city) ?>">
        <input type="text" id="level" name="level" placeholder="Niveau d'étude" value="<?= htmlspecialchars($level) ?>">
        <input type="text" id="domain" name="domain" placeholder="Domaine" value="<?= htmlspecialchars($domain) ?>">
        <input type="submit" value="Filtrer">
    </form>

    <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="candidate">
                <img src="<?= htmlspecialchars($row["image_path"]) ?>" alt="Image du Candidat">
                <div class="candidate-details">
                    <strong>Nom:</strong> <?= htmlspecialchars($row["first_name"]) . ' ' . htmlspecialchars($row["last_name"]) ?><br>
                    <strong>Email:</strong> <?= htmlspecialchars($row["email"]) ?><br>
                    <strong>Téléphone:</strong> <?= htmlspecialchars($row["phone"]) ?><br>
                    <strong>Pays:</strong> <?= htmlspecialchars($row["country"]) ?><br>
                    <strong>Ville:</strong> <?= htmlspecialchars($row["city"]) ?><br>
                    <strong>Niveau d'étude:</strong> <?= htmlspecialchars($row["diploma"]) ?><br>
                    <strong>Domaine:</strong> <?= htmlspecialchars($row["domaine"]) ?><br>
                </div>
                <a href="send_message_by_recruiter.php?candidate_email=<?= urlencode($row["email"]) ?>" class="btn">Chatter</a>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Aucun candidat correspondant trouvé.</p>
    <?php endif; ?>
    <?php $conn->close(); ?>
</body>
</html>

<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "RECRUTEMENT");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$domaine = isset($_POST['domaine']) ? $conn->real_escape_string($_POST['domaine']) : '';
$niveau = isset($_POST['niveau']) ? $conn->real_escape_string($_POST['niveau']) : '';
$ville = isset($_POST['ville']) ? $conn->real_escape_string($_POST['ville']) : '';

$query = "SELECT * FROM emplois WHERE (domain LIKE '%$domaine%' OR ? = '') AND (level LIKE '%$niveau%' OR ? = '') AND (city LIKE '%$ville%' OR ? = '')";
$stmt = $conn->prepare($query);
$stmt->bind_param("sss", $domaine, $niveau, $ville);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Voir les emplois</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .job {
            background-color: #fff;
            border: 1px solid #ddd;
            margin-bottom: 20px;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: auto;
        }
        .job-image img {
            width: 150px;
            height: 150px;
            float: left;
            margin-right: 10px;
        }
        .job-details {
            float: left;
        }
        .btn {
            padding: 5px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 5px;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        input[type="text"], select, input[type="submit"] {
            padding: 5px;
            margin-right: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            cursor: pointer;
            background-color: #007bff;
            color: white;
            border: none;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        fieldset {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 20px;
        }
        legend {
            padding: 0 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <form class="filter-form" action="view_jobs.php" method="post">
        <fieldset>
            <legend>Filtrer les emplois</legend>
            <label for="domaine">Domaine:</label>
            <input type="text" id="domaine" name="domaine" value="<?= htmlspecialchars($domaine) ?>">
            
            <label for="niveau">Niveau:</label>
            <input type="text" id="niveau" name="niveau" value="<?= htmlspecialchars($niveau) ?>">

            <label for="ville">Ville:</label>
            <input type="text" id="ville" name="ville" value="<?= htmlspecialchars($ville) ?>">

            <input type="submit" value="Rechercher">
        </fieldset>
    </form>

    <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="job">
                <div class="job-image">
                    <img src="<?= htmlspecialchars($row["pic"]) ?>" alt="Job Image">
                </div>
                <div class="job-details">
                    <h3><?= htmlspecialchars($row["titre"]) ?></h3>
                    <p><?= nl2br(htmlspecialchars($row["description"])) ?></p>
                    <p>Niveau d'étude requis: <?= htmlspecialchars($row["level"]) ?></p>
                    <p>Domaine: <?= htmlspecialchars($row["domain"]) ?></p>
                    <p>Ville: <?= htmlspecialchars($row["city"]) ?></p>
                    <p>Email du recruteur: <?= htmlspecialchars($row["email_recruteur"]) ?></p>
                    <a href="initiate_chat.php?recruiter_email=<?= urlencode($row['email_recruteur']) ?>" class="btn">Chatter</a>
                    <a href="postuler.php?job_id=<?= $row['id'] ?>&recruteur_email=<?= $row['email_recruteur'] ?>" class="btn">Postuler</a>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Aucune offre d'emploi correspondante trouvée.</p>
    <?php endif; ?>
    <?php $conn->close(); ?>
</body>
</html>

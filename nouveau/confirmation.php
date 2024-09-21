<?php
require_once 'db_connection.php'; // Assurez-vous que ce fichier est dans le même répertoire

$code = $_GET['code'] ?? '';

if (empty($code)) {
    echo "Code de réservation manquant.";
    exit;
}

try {
    // Récupérez les détails de la réservation en utilisant le code
    $stmt = $conn->prepare('SELECT * FROM voyageurs WHERE code = :code');
    $stmt->execute(['code' => $code]);
    $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$reservation) {
        echo "Aucune réservation trouvée pour ce code.";
        exit;
    }
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de Réservation</title>
    <link rel="stylesheet" href="stylee.css"> <!-- Lien vers votre fichier CSS -->
</head>
<body>
    <div class="container">
        <h1>Confirmation de Réservation</h1>
        <p>Merci<strong> <?php echo htmlspecialchars($reservation['nom']);  ?> </strong>pour votre réservation ! Voici les détails de votre réservation veuiller gardé jalousement votre code de réservation :</p>
        <ul>
            <li><strong>Nom :</strong> <?php echo htmlspecialchars($reservation['nom']); ?></li>
            <li><strong>Post-nom :</strong> <?php echo htmlspecialchars($reservation['postnom']); ?></li>
            <li><strong>Prénom :</strong> <?php echo htmlspecialchars($reservation['prenom']); ?></li>
            <li><strong>Sexe :</strong> <?php echo htmlspecialchars($reservation['sexe']); ?></li>
            <li><strong>Date de naissance :</strong> <?php echo htmlspecialchars($reservation['date_naissance']); ?></li>
            <li><strong>Date de réservation :</strong> <?php echo htmlspecialchars($reservation['date_reservation']); ?></li>
            <li><strong>Lieux de voyage :</strong> <?php echo htmlspecialchars($reservation['lieux_voyage']); ?></li>
            <li><strong>Code de réservation :</strong> <?php echo htmlspecialchars($reservation['code']); ?></li>
            <li><strong>Photo :</strong><br />
                <img src="<?php echo htmlspecialchars($reservation['photo']); ?>" alt="Photo du voyageur" style="max-width: 300px; max-height: 300px;">
            </li>
            <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page avec Bouton</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .button-container {
            text-align: center;
        }

        .styled-button {
            display: inline-block;
            padding: 15px 30px;
            font-size: 1.2em;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s, transform 0.3s;
        }

        .styled-button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="button-container">
        <a href="list_reservations.php" class="styled-button">voir la liste de réservation</a>
        </ul>
    </div>
</body>
</html>

<?php
require_once 'db_connection.php'; // Assurez-vous que ce fichier est dans le même répertoire

// Initialiser les variables
$search = '';
$reservations = [];

// Vérifier si une recherche a été soumise
if (isset($_GET['search'])) {
    $search = htmlspecialchars($_GET['search']);
}

// Préparer la requête SQL avec filtre de recherche
$sql = "SELECT * FROM voyageurs WHERE nom LIKE :search OR postnom LIKE :search OR prenom LIKE :search OR code LIKE :search ORDER BY date_reservation DESC";
$stmt = $conn->prepare($sql);
$stmt->execute(['search' => "%$search%"]);
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Réservations</title>
    <link rel="stylesheet" href="style.css"> <!-- Lien vers votre fichier CSS -->
    <style>
        .search-container {
            margin-bottom: 20px;
            text-align: center;
        }
        .search-container input[type="text"] {
            width: 80%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .search-container button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            margin-left: -5px;
        }
        .search-container button:hover {
            background-color: #0056b3;
        }
        .reservations-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .reservations-table th, .reservations-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .reservations-table th {
            background-color: #f4f4f4;
        }
        .reservations-table img {
            max-width: 100px;
            height: auto;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Liste des Réservations</h1>
        
        <!-- Formulaire de recherche -->
        <div class="search-container">
            <form method="GET" action="list_reservations.php">
                <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Rechercher par nom, post-nom, prénom ou code">
                <button type="submit">Rechercher</button>
            </form>
        </div>

        <!-- Tableau des réservations -->
        <table class="reservations-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Post-nom</th>
                    <th>Prénom</th>
                    <th>Sexe</th>
                    <th>Code</th>
                    <th>Date de Naissance</th>
                    <th>Date de Réservation</th>
                    <th>Lieux de Voyage</th>
                    <th>Photo</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($reservations) > 0): ?>
                    <?php foreach ($reservations as $reservation): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($reservation['nom']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['postnom']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['prenom']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['sexe']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['code']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['date_naissance']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['date_reservation']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['lieux_voyage']); ?></td>
                            <td>
                                <?php if (!empty($reservation['photo'])): ?>
                                    <img src="<?php echo htmlspecialchars($reservation['photo']); ?>" alt="Photo de <?php echo htmlspecialchars($reservation['prenom']); ?>">
                                <?php else: ?>
                                    Aucune photo
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9">Aucune réservation trouvée.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

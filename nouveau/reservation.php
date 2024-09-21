<?php
require_once 'db_connection.php'; // Assurez-vous que ce fichier est dans le même répertoire

$message = '';

// Chemin vers le répertoire de téléchargement
$uploadFileDir = './uploads/';

// Vérifiez si le répertoire existe, sinon créez-le
if (!is_dir($uploadFileDir)) {
    if (!mkdir($uploadFileDir, 0755, true)) {
        die('Échec de la création du répertoire de téléchargement.');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $postnom = $_POST['postnom'];
    $prenom = $_POST['prenom'];
    $sexe = $_POST['sexe'];
    $date_naissance = $_POST['date_naissance'];
    $date_reservation = $_POST['date_reservation'];
    $lieux_voyage = $_POST['lieux_voyage'];
    $photo = '';

    // Gestion du téléchargement de photo
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['photo']['tmp_name'];
        $fileName = $_FILES['photo']['name'];
        $fileSize = $_FILES['photo']['size'];
        $fileType = $_FILES['photo']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (in_array($fileExtension, $allowedExtensions)) {
            $dest_path = $uploadFileDir . uniqid() . '.' . $fileExtension;
            
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $photo = $dest_path;
            } else {
                $message = "Erreur lors du déplacement de la photo.";
            }
        } else {
            $message = "Type de fichier non autorisé pour la photo.";
        }
    }

    if (empty($message)) {
        try {
            // Générer un code de réservation aléatoire
            $code = strtoupper(bin2hex(random_bytes(4))); // Code de réservation de 8 caractères
            
            // Insérez la réservation dans la base de données
            $stmt = $conn->prepare('INSERT INTO voyageurs (nom, postnom, prenom, sexe, code, date_naissance, date_reservation, lieux_voyage, photo) VALUES (:nom, :postnom, :prenom, :sexe, :code, :date_naissance, :date_reservation, :lieux_voyage, :photo)');
            $stmt->execute([
                'nom' => $nom,
                'postnom' => $postnom,
                'prenom' => $prenom,
                'sexe' => $sexe,
                'code' => $code,
                'date_naissance' => $date_naissance,
                'date_reservation' => $date_reservation,
                'lieux_voyage' => $lieux_voyage,
                'photo' => $photo
            ]);

            // Rediriger vers la page de confirmation avec le code de réservation
            header("Location: confirmation.php?code=$code");
            exit;
        } catch (PDOException $e) {
            $message = "Erreur de connexion à la base de données: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation</title>
    <link rel="stylesheet" href="style.css"> <!-- Lien vers votre fichier CSS -->
</head>
<body>
    <div class="container">
        <h1>Réservation</h1>
        <?php if ($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nom">Nom :</label>
                <input type="text" id="nom" name="nom" required>
            </div>
            <div class="form-group">
                <label for="postnom">Post-nom :</label>
                <input type="text" id="postnom" name="postnom" required>
            </div>
            <div class="form-group">
                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" required>
            </div>
            <div class="form-group">
                <label for="sexe">Sexe :</label>
                <select id="sexe" name="sexe" required>
                    <option value="Homme">Homme</option>
                    <option value="Femme">Femme</option>
                </select>
            </div>
            <div class="form-group">
                <label for="date_naissance">Date de naissance :</label>
                <input type="date" id="date_naissance" name="date_naissance" required>
            </div>
            <div class="form-group">
                <label for="date_reservation">Date de réservation :</label>
                <input type="date" id="date_reservation" name="date_reservation" required>
            </div>
            <div class="form-group">
                <label for="lieux_voyage">Lieux de voyage :</label>
                <input type="text" id="lieux_voyage" name="lieux_voyage" required>
            </div>
            <div class="form-group">
                <label for="photo">Photo :</label>
                <input type="file" id="photo" name="photo" accept="image/*" required>
            </div>
            <button type="submit">Réserver</button>
        </form>
    </div>
</body>
</html>

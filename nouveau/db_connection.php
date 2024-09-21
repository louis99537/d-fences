<?php
$servername = "localhost";
$username = "root"; // Changez ce nom d'utilisateur si vous utilisez un autre
$password = ""; // Changez ce mot de passe si vous en avez un
$dbname = "CAA";

// Créez la connexion
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Définir le mode d'erreur de PDO sur Exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données: " . $e->getMessage();
    exit;
}
?>

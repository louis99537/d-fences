<?php
// signup.php
require_once 'db_connection.php'; // Assurez-vous que ce fichier est dans le même répertoire

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    try {
        // Vérifiez si l'utilisateur existe déjà
        $stmt = $conn->prepare('SELECT * FROM users WHERE username = :username OR email = :email');
        $stmt->execute(['username' => $username, 'email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            $message = "Un utilisateur avec ce nom d'utilisateur ou cet email existe déjà.";
        } else {
            // Hachez le mot de passe
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            
            // Insérez le nouvel utilisateur dans la base de données
            $stmt = $conn->prepare('INSERT INTO users (username, email, password) VALUES (:username, :email, :password)');
            $stmt->execute([
                'username' => $username,
                'email' => $email,
                'password' => $hashed_password
            ]);
            
            $message = "Compte créé avec succès ! Vous pouvez maintenant vous <a href='login.php'>connecter</a>.";
        }
    } catch (PDOException $e) {
        $message = "Erreur de connexion à la base de données: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Compte</title>
    <link rel="stylesheet" href="style.css"> <!-- Lien vers votre fichier CSS -->
</head>
<body>
    <div class="container">
        <h1>Créer un Compte</h1>
     
        <?php if ($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="username">Nom d'utilisateur :</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Créer un Compte</button>



<a>
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
        <a href="login.php" class="styled-button">se connecter</a>
    </div>
</body>
</html>







    </a>
        </form>
    </div>
</body>
</html>

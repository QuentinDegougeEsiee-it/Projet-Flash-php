<?php
require_once './database.php';
$pdo = connectToDBandGetPDOdb();

$message = "";
$messageType = "error"; // Pour gérer la couleur (error = rouge, success = vert)

// Initialisation des variables pour garder les valeurs dans le formulaire en cas d'erreur
$user_value = "";
$email_value = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Nettoyage
    $user = trim($_POST['username']);
    $email = trim($_POST['email']);
    $pass = $_POST['password'];
    $confirm_pass = $_POST['confirm_password'];

    // On garde les valeurs pour les réafficher dans le formulaire (UX)
    $user_value = $user;
    $email_value = $email;

    if (empty($user) || empty($email) || empty($pass)) {
        $message = "Tous les champs sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Format d'email invalide.";
    } elseif ($pass !== $confirm_pass) {
        $message = "Les mots de passe ne correspondent pas.";
    } else {
        // 1. Vérifier si l'email existe déjà
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() > 0) {
            $message = "Cet email est déjà utilisé.";
        } else {
            // 2. Hachage
            $hash = password_hash($pass, PASSWORD_DEFAULT);

            // 3. Insertion
            $sql = "INSERT INTO users (pseudo, email, password) VALUES (:username, :email, :password)";
            $stmt = $pdo->prepare($sql);

            try {
                $stmt->execute([
                    ':username' => $user,
                    ':email' => $email,
                    ':password' => $hash
                ]);
                
                $messageType = "success";
                $message = "Succès ! Vous êtes inscrit. <a href='login.php'>Connectez-vous ici</a>";
                
                // On vide les champs si l'inscription est réussie
                $user_value = "";
                $email_value = "";

            } catch (PDOException $e) {
                // LOGGUER L'ERREUR DANS UN FICHIER (côté serveur), ne pas l'afficher à l'utilisateur
                error_log("Erreur inscription : " . $e->getMessage()); 
                $message = "Une erreur technique est survenue. Veuillez réessayer plus tard.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; padding-top: 50px; background-color: #f4f4f4; }
        form { background: white; border: 1px solid #ccc; padding: 20px; border-radius: 5px; width: 300px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        div { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; font-size: 0.9em; }
        input { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ddd; border-radius: 4px; }
        button { width: 100%; padding: 10px; background-color: #28a745; color: white; border: none; cursor: pointer; border-radius: 4px; font-size: 1em; }
        button:hover { background-color: #218838; }
        
        /* Classes dynamiques pour les messages */
        .message { padding: 10px; margin-bottom: 15px; border-radius: 4px; font-size: 0.9em; }
        .error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .success a { color: #155724; font-weight: bold; }
    </style>
</head>
<body>

    <form action="" method="POST">
        <h2 style="text-align:center;">Créer un compte</h2>
        
        <?php if(!empty($message)): ?>
            <div class="message <?php echo $messageType; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div>
            <label for="username">Nom d'utilisateur :</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($user_value); ?>" required>
        </div>

        <div>
            <label for="email">Email :</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($email_value); ?>" required>
        </div>

        <div>
            <label for="password">Mot de passe :</label>
            <input type="password" name="password" required>
        </div>

        <div>
            <label for="confirm_password">Confirmer le mot de passe :</label>
            <input type="password" name="confirm_password" required>
        </div>

        <button type="submit">S'inscrire</button>
    </form>

</body>
</html>
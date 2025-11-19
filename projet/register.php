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
    <link rel="stylesheet" href="/asset/css/styles-login.css">
    <link rel="shortcut icon" href="/asset/images/favicon.png" type="image/x-icon">
</head>
<body>
    <div class="container">
        <div class="left-container">
            <div class="text-container">
                <h1>Bienvenu chez nous !  👋</h1>
                <p>Rejoignez-nous dès aujourd’hui pour accéder à toutes les fonctionnalités.  
                C'est rapide et gratuit !</p>
            </div>

            <form class="form-container" action="" method="POST">
                        <?php if(!empty($message)): ?>
            <div class="message <?php echo $messageType; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
                <label for="username">Pseudo</label>
                <input 
                    type="name" 
                    name="username"
                    id="username" 
                    placeholder="Votre pseudo ..." 
                    minlength="4"
                    required
                >

                <label for="email">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    placeholder="exemple@email.com" 
                    required
                >

                <label for="password">Mot de passe</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    placeholder="8 caractères minimum" 
                    required
                    maxlength="8"
                >

                <label for="confirm_password">Confirmer le mot de passe</label>
                <input 
                    type="password" 
                    name="confirm_password" 
                    id="confirm-_assword" 
                    placeholder="8 caractères minimum" 
                    required
                    maxlength="8"
                >

                <button class="connexion-btn" type="submit">S'inscrire</button>
            </form>

            <div class="other-options">
                <div class="divider">
                    <span>Ou</span>
                </div>

                <a class="connect-google" href="index.html">
                    <img class="img-google" src="/asset/images/Google.svg" alt="Logo Google">
                    <span class="text google">‎ S'inscrire avec Google</span>
                </a>

                <p class="signup-link">
                    Déjà un compte ? <a href="login.php">Je me connecte</a>
                </p>
            </div>
        </div>

        <div class="right-container">
            <img class="image-login" src="/asset/images/Login-img.jpg" alt="Illustration inscription">
        </div>
    </div>
</body>
</html>

<?php
require_once './database.php';
// Démarrage de session si on veut connecter l'utilisateur directement après (optionnel)
session_start(); 

$pdo = connectToDBandGetPDOdb();

$message = "";
$messageType = "error"; 

// Variables pour réafficher le formulaire
$user_value = "";
$email_value = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Récupération et nettoyage
    $user = trim($_POST['username']);
    $email = trim($_POST['email']);
    $pass = $_POST['password'];
    $confirm_pass = $_POST['confirm_password'];

    $user_value = $user;
    $email_value = $email;

    // 2. Validations de base
    if (empty($user) || empty($email) || empty($pass)) {
        $message = "Tous les champs sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Format d'email invalide.";
    } elseif ($pass !== $confirm_pass) {
        $message = "Les mots de passe ne correspondent pas.";
    } else {
        // 3. Vérifier si l'email existe
        $stmt = $pdo->prepare("SELECT id_user FROM users WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() > 0) {
            $message = "Cet email est déjà utilisé.";
        } else {
            // 4. Hachage et Insertion
            $hash = password_hash($pass, PASSWORD_DEFAULT);

            try {
                // On commence par insérer l'utilisateur SANS photo
                $sql = "INSERT INTO users (pseudo, email, password) VALUES (:username, :email, :password)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':username' => $user,
                    ':email' => $email,
                    ':password' => $hash
                ]);

                // *** RECUPERATION DE L'ID DU NOUVEL UTILISATEUR ***
                $new_user_id = $pdo->lastInsertId();

                // 5. Traitement de l'image (seulement si inscription réussie et image présente)
                if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                    
                    $dossier = "photo de profil/";
                    if (!is_dir($dossier)) {
                        mkdir($dossier, 0755, true); // 0755 est plus sûr que 0777
                    }

                    $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                    $allowed = ['jpg', 'jpeg', 'png', 'gif'];

                    // Vérification de l'extension
                    if (in_array($extension, $allowed)) {
                        // Nommage sécurisé : ID_unique.ext (évite les conflits et caractères spéciaux)
                        $nomFichier = 'user_' . $new_user_id . '.' . $extension;
                        $destination = $dossier . $nomFichier;

                        if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                            // Mise à jour de la BDD avec le chemin de l'image
                            $sqlUpdate = "UPDATE users SET photo_profil = ? WHERE id_user = ?";
                            $stmtUpdate = $pdo->prepare($sqlUpdate);
                            $stmtUpdate->execute([$destination, $new_user_id]);
                        } else {
                            // Warning non bloquant
                            $message .= " (Erreur lors de l'enregistrement de l'image).";
                        }
                    } else {
                        $message .= " (Format d'image non supporté, inscription réussie sans image).";
                    }
                }

                $messageType = "success";
                $message = "Inscription réussie ! <a href='login.php'>Connectez-vous ici</a>";
                
                // Reset des valeurs
                $user_value = "";
                $email_value = "";

            } catch (PDOException $e) {
                echo"Erreur inscription : " . $e->getMessage(); 
                $message = "Une erreur technique est survenue.";
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

            <form class="form-container" action="" enctype="multipart/form-data"  method="POST">
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
                    minlength="8"
                    maxlength="100"

                >

                <label for="confirm_password">Confirmer le mot de passe</label>
                <input 
                    type="password" 
                    name="confirm_password" 
                    id="confirm-_assword" 
                    placeholder="8 caractères minimum" 
                    required
                    minlength="8"
                    maxlength="100"
                >
                <label for="image">Ajouter votre photo de profil</label>
    <input   type="file" name="image" accept=".jpg, .jpeg, .png, .svg, image/jpeg, image/png, image/svg+xml">

                <button class="connexion-btn" type="submit">S'inscrire</button>
            </form>

            <div class="other-options">
                <div class="divider">
                    <span>et</span>
                </div>


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

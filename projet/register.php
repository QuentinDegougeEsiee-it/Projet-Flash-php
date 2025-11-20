<?php
require_once './database.php';
session_start(); 

$pdo = connectToDBandGetPDOdb();

$message = "";
$messageType = "error"; 

// Variables pour réafficher le formulaire (Sticky form)
$user_value = "";
$email_value = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Récupération et nettoyage
    $user = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pass = $_POST['password'] ?? '';
    $confirm_pass = $_POST['confirm_password'] ?? '';

    $user_value = htmlspecialchars($user); // Sécurité XSS pour le réaffichage
    $email_value = htmlspecialchars($email);

    // 2. Validations de base
    if (empty($user) || empty($email) || empty($pass)) {
        $message = "Tous les champs sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Format d'email invalide.";
    } elseif ($pass !== $confirm_pass) {
        $message = "Les mots de passe ne correspondent pas.";
    } else {
        try {
            // 3. Vérifier si l'email existe
            $stmt = $pdo->prepare("SELECT id_user FROM users WHERE email = ?");
            $stmt->execute([$email]);
            
            if ($stmt->rowCount() > 0) {
                $message = "Cet email est déjà utilisé.";
            } else {
                // 4. Hachage et Insertion
                $hash = password_hash($pass, PASSWORD_DEFAULT);

                // On insère l'utilisateur
                $sql = "INSERT INTO users (pseudo, email, password) VALUES (:username, :email, :password)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':username' => $user,
                    ':email' => $email,
                    ':password' => $hash
                ]);

                $new_user_id = $pdo->lastInsertId();

                // 5. Traitement de l'image
                if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                    
                    // A. Validation du type MIME (Plus sûr que l'extension seule)
                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                    $mimeType = $finfo->file($_FILES['image']['tmp_name']);
                    $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];

                    // B. Validation de l'extension
                    $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                    $allowedExt = ['jpg', 'jpeg', 'png', 'gif'];

                    if (in_array($mimeType, $allowedMimeTypes) && in_array($extension, $allowedExt)) {
                        
                        // Création du dossier userFile/ID/
                        $targetDir = "userFile/" . $new_user_id . "/";
                        if (!is_dir($targetDir)) {
                            mkdir($targetDir, 0755, true);
                        }

                        // Nommage du fichier
                        $nomFichier = 'user_' . $new_user_id . '.' . $extension;
                        $destination = $targetDir . $nomFichier;

                        // C. Limite de taille (ex: 5MB) - Optionnel mais recommandé
                        if ($_FILES['image']['size'] <= 5000000) {
                             if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                                // Mise à jour BDD
                                $sqlUpdate = "UPDATE users SET photo_profil = ? WHERE id_user = ?";
                                $stmtUpdate = $pdo->prepare($sqlUpdate);
                                $stmtUpdate->execute([$destination, $new_user_id]);
                            } else {
                                $message .= " (Erreur : Impossible de déplacer l'image).";
                            }
                        } else {
                            $message .= " (Image trop lourde. Max 5Mo).";
                        }
                       
                    } else {
                        $message .= " (Format d'image invalide, inscription réussie sans image).";
                    }
                }

                $messageType = "success";
                $message = "Inscription réussie ! <a href='login.php'>Connectez-vous ici</a>";
                
                // Reset des valeurs en cas de succès
                $user_value = "";
                $email_value = "";
            }
        } catch (PDOException $e) {
            // NE JAMAIS afficher $e->getMessage() en production aux utilisateurs
            // Cela peut révéler des infos sur votre BDD aux hackers.
            error_log("Erreur Inscription : " . $e->getMessage()); // Enregistre dans les logs serveur
            $message = "Une erreur technique est survenue. Veuillez réessayer plus tard.";
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

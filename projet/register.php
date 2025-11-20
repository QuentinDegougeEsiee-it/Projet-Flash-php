<?php
require_once './database.php';
require './partials/notification.php'; // Composant Notif
session_start(); 

$pdo = connectToDBandGetPDOdb();

// Init variables & Sticky form
$message = "";
$messageType = "error";
$user_value = "";
$email_value = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // --- 1. Récupération & Nettoyage ---
    $user = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pass = $_POST['password'] ?? '';
    $confirm_pass = $_POST['confirm_password'] ?? '';

    $user_value = htmlspecialchars($user);
    $email_value = htmlspecialchars($email);

    // --- 2. Validations basiques ---
    if (empty($user) || empty($email) || empty($pass)) {
        $message = "Tous les champs sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Format d'email invalide.";
    } elseif ($pass !== $confirm_pass) {
        $message = "Les mots de passe ne correspondent pas.";
    } else {
        try {
            // --- 3. Vérification doublons (Pseudo/Email) ---
            $stmtPseudo = $pdo->prepare("SELECT id_user FROM users WHERE pseudo = ?");
            $stmtPseudo->execute([$user]);

            $stmtEmail = $pdo->prepare("SELECT id_user FROM users WHERE email = ?");
            $stmtEmail->execute([$email]);

            if ($stmtPseudo->rowCount() > 0) {
                $message = "Ce pseudo est déjà utilisé.";
            } elseif ($stmtEmail->rowCount() > 0) {
                $message = "Cet email est déjà utilisé.";
            } else {
                
                // --- 4. Création du compte ---
                $hash = password_hash($pass, PASSWORD_DEFAULT);
                
                $stmt = $pdo->prepare("INSERT INTO users (pseudo, email, password) VALUES (:username, :email, :password)");
                $stmt->execute([
                    ':username' => $user,
                    ':email'    => $email,
                    ':password' => $hash
                ]);

                $new_user_id = $pdo->lastInsertId();

                // --- 5. Gestion de l'Avatar (Upload) ---
                if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                    
                    // Vérif MIME & Extension
                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                    $mimeType = $finfo->file($_FILES['image']['tmp_name']);
                    $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

                    $allowedMime = ['image/jpeg', 'image/png', 'image/gif', 'image/svg+xml'];
                    $allowedExt  = ['jpg', 'jpeg', 'png', 'gif', 'svg'];

                    if (in_array($mimeType, $allowedMime) && in_array($extension, $allowedExt)) {
                        
                        // Création dossier & Déplacement
                        $targetDir = "userFile/" . $new_user_id . "/";
                        if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);

                        $destination = $targetDir . 'user_' . $new_user_id . '.' . $extension;

                        if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                            // Update BDD avec chemin image
                            $pdo->prepare("UPDATE users SET photo_profil = ? WHERE id_user = ?")
                                ->execute([$destination, $new_user_id]);
                        }
                    }
                }

                // --- 6. Succès & Redirection ---
                $messageType = "success";
                $message = "Inscription réussie ! Redirection...";

                $user_value = ""; // Reset form
                $email_value = "";
                
                sleep(2); // Pause pour l'UX
                header("Location: login.php");
                exit;
            }
        } catch (PDOException $e) {
            error_log("Erreur Inscription : " . $e->getMessage());
            $message = "Une erreur technique est survenue.";
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

    <style>
    .notification {
        position: fixed; bottom: 30px; left: 50%; transform: translateX(-50%) scale(0.8);
        background: white; padding: 20px 30px; border-radius: 16px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        display: flex; align-items: center; gap: 15px; min-width: 300px; z-index: 9999;
        opacity: 0; visibility: hidden; transition: all 0.3s ease;
    }
    .notification.active {
        opacity: 1; visibility: visible;
        animation: appearBounce 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
    }
    /* Couleurs */
    .notification.success .icon-circle { background-color: #dcfce7; }
    .notification.success .icon-check { border-color: #22c55e; }
    .notification.error .icon-circle { background-color: #fee2e2; }
    .notification.error .icon-cross::before,
    .notification.error .icon-cross::after { background-color: #ef4444; }

    /* Icones */
    .icon-circle { width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .icon-check { width: 20px; height: 10px; border-left: 3px solid; border-bottom: 3px solid; transform: rotate(-45deg) translate(2px, -2px); }
    .icon-cross { width: 20px; height: 20px; position: relative; }
    .icon-cross::before, .icon-cross::after { content: ''; position: absolute; width: 100%; height: 3px; background-color: currentColor; border-radius: 2px; top: 50%; left: 0; }
    .icon-cross::before { transform: translateY(-50%) rotate(45deg); }
    .icon-cross::after { transform: translateY(-50%) rotate(-45deg); }

    /* Texte & Anim */
    .notif-content h3 { margin: 0; font-size: 16px; color: #1e293b; font-family: sans-serif;}
    .notif-content p { margin: 4px 0 0 0; font-size: 14px; color: #64748b; font-family: sans-serif;}
    @keyframes appearBounce {
        0% { opacity: 0; transform: translate(-50%, 50px) scale(0.9); }
        100% { opacity: 1; transform: translate(-50%, 0) scale(1); }
    }
    </style>
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
                
                <label for="username">Pseudo</label>
                <input 
                    type="text" name="username" id="username" 
                    placeholder="Votre pseudo ..." minlength="4" required
                    value="<?php echo $user_value; ?>"
                >

                <label for="email">Email</label>
                <input 
                    type="email" name="email" id="email" 
                    placeholder="exemple@email.com" required
                    value="<?php echo $email_value; ?>"
                >

                <label for="password">Mot de passe</label>
                <input 
                    type="password" name="password" id="password" 
                    placeholder="8 caractères minimum" required
                    minlength="8" maxlength="100"
                >

                <label for="confirm_password">Confirmer le mot de passe</label>
                <input 
                    type="password" name="confirm_password" id="confirm_password" 
                    placeholder="8 caractères minimum" required
                    minlength="8" maxlength="100"
                >
                
                <label for="image">Ajouter votre photo de profil</label>
                <input  type="file" name="image" accept=".jpg, .jpeg, .png, .svg, image/jpeg, image/png, image/svg+xml">

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

    <?php 
        if(!empty($message)) {
            displayNotification($message, $messageType);
        }
    ?>

</body>
</html>
<?php 
session_start();

// 1. SECURITÉ : Vérifier si connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit; 
}

$user_id = $_SESSION['user_id'];

// 2. Connexion BDD
require 'database.php';
$pdo = connectToDBandGetPDOdb();

// 3. Variables d'initialisation
$message = null;
$message_type = ""; // "error" ou "success"

// 4. Récupérer les infos fraiches de l'utilisateur
$stmt = $pdo->prepare("SELECT * FROM users WHERE id_user = ?");
$stmt->execute([$user_id]);
$currentUser = $stmt->fetch(PDO::FETCH_ASSOC);

// Si l'utilisateur n'existe pas (cas rare)
if (!$currentUser) {
    session_destroy();
    header('Location: login.php');
    exit;
}

// --- TRAITEMENT DES FORMULAIRES ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // === A. TRAITEMENT PHOTO DE PROFIL ===
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $dossier = "userFile/" . $user_id ."/";
        
        if (!is_dir($dossier)) {
            mkdir($dossier, 0755, true);
        }

        $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp'];

        if(in_array($extension, $allowed_extensions)) {
            // Nom unique pour éviter le cache navigateur : user_ID_TIMESTAMP.ext
            $nomFichier = "user_" . $user_id . "_" . time() . '.' . $extension;
            $destination = $dossier . $nomFichier;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                // Suppression de l'ancienne image si elle existe (optionnel, à décommenter si besoin)
                // if (!empty($currentUser['photo_profil']) && file_exists($currentUser['photo_profil'])) { unlink($currentUser['photo_profil']); }

                $update = $pdo->prepare("UPDATE users SET photo_profil = ? WHERE id_user = ?");
                if ($update->execute([$destination, $user_id])) {
                    $message = "Photo de profil mise à jour !";
                    $message_type = "success";
                    
                    // Mise à jour immédiate des variables pour l'affichage
                    $currentUser['photo_profil'] = $destination;
                    $_SESSION['user_picture'] = $destination;
                } else {
                    $message = "Erreur BDD lors de la mise à jour.";
                    $message_type = "error";
                }
            } else {
                $message = "Erreur lors du déplacement du fichier.";
                $message_type = "error";
            }
        } else {
            $message = "Format invalide. (JPG, PNG, WEBP uniquement)";
            $message_type = "error";
        }
    }

    // === B. TRAITEMENT EMAIL ===
    if (isset($_POST['action']) && $_POST['action'] === 'update_email') {
        $new_email = trim($_POST['email']);

        if (empty($new_email) || !filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
            $message = "Email invalide.";
            $message_type = "error";
        }
        elseif ($new_email == $currentUser['email']) {
            $message = "Vous n'avez pas changé votre email.";
            $message_type = "error"; // Ou warning
        } 
        else {
            // Vérifier doublon
            $check = $pdo->prepare("SELECT id_user FROM users WHERE email = ? AND id_user != ?");
            $check->execute([$new_email, $user_id]);
            
            if ($check->rowCount() > 0) {
                $message = "Cet email est déjà utilisé.";
                $message_type = "error";
            } else {
                $update = $pdo->prepare("UPDATE users SET email = ? WHERE id_user = ?");
                if($update->execute([$new_email, $user_id])) {
                    $message = "Email mis à jour avec succès.";
                    $message_type = "success";
                    $currentUser['email'] = $new_email; 
                } else {
                    $message = "Erreur lors de la mise à jour.";
                    $message_type = "error";
                }
            }
        }
    }

    // === C. TRAITEMENT MOT DE PASSE ===
    if (isset($_POST['action']) && $_POST['action'] === 'update_password') {
        $new_password = $_POST['password'];
        
        if (empty($new_password) || strlen($new_password) < 8) {
            $message = "Mot de passe trop court (8 car. min).";
            $message_type = "error";
        }
        elseif (password_verify($new_password, $currentUser['password'])) {
            $message = "Vous avez saisi le même mot de passe.";
            $message_type = "error";
        } 
        else {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update = $pdo->prepare("UPDATE users SET password = ? WHERE id_user = ?");
            if($update->execute([$hashed_password, $user_id])) {
                $message = "Mot de passe mis à jour avec succès.";
                $message_type = "success";
                $currentUser['password'] = $hashed_password;
            } else {
                $message = "Erreur lors de la mise à jour.";
                $message_type = "error";
            }
        }
    }
}

// Image de repli si vide
$currentImage = !empty($currentUser['photo_profil']) ? $currentUser['photo_profil'] : '/asset/images/default-avatar.png';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Compte</title>
    <script src="https://kit.fontawesome.com/5bdcf86e83.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/asset/css/Account.css">
    <link rel="stylesheet" href="/asset/css/navbar.css">
    <link rel="shortcut icon" href="/asset/images/favicon.png" type="image/x-icon">
    
    <style>
    .notification {
        position: fixed; bottom: 30px; left: 50%; transform: translateX(-50%) scale(0.8);
        background: white; padding: 15px 25px; border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        display: flex; align-items: center; gap: 15px; min-width: 300px; z-index: 9999;
        opacity: 0; visibility: hidden; transition: all 0.3s ease;
    }
    .notification.active {
        opacity: 1; visibility: visible;
        animation: appearBounce 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
    }
    .notification.success { border-left: 5px solid #22c55e; }
    .notification.error { border-left: 5px solid #ef4444; }
    
    .notif-content h3 { margin: 0; font-size: 16px; color: #1e293b; font-family: sans-serif; font-weight: bold;}
    .notif-content p { margin: 4px 0 0 0; font-size: 14px; color: #64748b; font-family: sans-serif;}
    
    @keyframes appearBounce {
        0% { opacity: 0; transform: translate(-50%, 50px) scale(0.9); }
        100% { opacity: 1; transform: translate(-50%, 0) scale(1); }
    }
    </style>
</head>
<body>

    <header class="header-account">
        <div class="back">
            <a onclick="/" href="/projet/">
                <img width="30" src="/asset/images/arrow-left-wide-line.svg" alt="">
                <span class="back-text">Retour</span>
            </a>
        </div>
    </header>

    <section class="header-container-image-account">
        <div class="image-account-banner">
            <figure><img class="image-account" src="/asset/images/Banner-account.jpg" draggable="false" alt=""></figure>
        </div>
    </section>

    <h1 class="title">Vos informations</h1>

    <section class="profile-section-wrapper">
        <form method="POST" enctype="multipart/form-data">
            <div class="profile-upload-container" style="text-align:center; margin-bottom: 20px;">
                <div style="position: relative; display: inline-block;">
                    <img id="profileImagePreview" src="<?= htmlspecialchars($currentImage); ?>" alt="Avatar" 
                         style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%; border: 3px solid #fff; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    
                    <label for="fileUpload" class="camera-btn" style="position: absolute; bottom: 0; right: 0; background: #fff; padding: 8px; border-radius: 50%; cursor: pointer; box-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                        <i class="fa-solid fa-camera" style="color: #333;"></i>
                        <input type="file" id="fileUpload" hidden name="image" accept="image/png, image/jpeg, image/jpg, image/webp">
                    </label>
                </div>

                <div class="profile-actions" id="profileActions" style="display: none; margin-top: 15px;">
                    <button type="button" class="btn-action btn-cancel" onclick="resetPreview()" style="padding: 5px 10px; cursor:pointer;">Annuler</button>
                    <button type="submit" class="btn-action btn-save" style="padding: 5px 10px; cursor:pointer; background-color: #4CAF50; color: white; border: none;">Enregistrer</button>
                </div>
            </div>
        </form>
    </section>

    <section class="container-modif-global">
        <div class="container-modif">
            
            <div class="left-container-email">
                <h1 class="txt-modif">Modifier votre email :</h1>
                <form action="" method="POST" class="form-account">
                    <input type="hidden" name="action" value="update_email">
                    <div class="input-and-btn">
                        <input type="email" name="email" id="email" value="<?= htmlspecialchars($currentUser['email']) ?>" placeholder="Votre.email@gmail.com" required>
                        <button class="btn-modif" type="submit">
                            <figure><img class="btn-modif" src="/asset/images/pencil-fill.svg" alt="Modifier" width="20" height="20"></figure>
                        </button>
                    </div>
                </form>
            </div>

            <div class="divider"></div>

            <div class="right-container-password">
                <h1 class="txt-modif">Modifier votre mot de passe :</h1>
                <form action="" method="POST" class="form-account">
                    <input type="hidden" name="action" value="update_password">
                    <div class="input-and-btn">
                        <input type="password" name="password" minlength="8" id="password" placeholder="Nouveau mot de passe">
                        <button class="btn-modif" type="submit">
                            <figure><img class="btn-modif" src="/asset/images/pencil-fill.svg" alt="Modifier" width="20" height="20"></figure>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </section>

    <?php if ($message): ?>
        <div id="notification-toast" class="notification <?= $message_type; ?> active">
            <div class="icon-circle">
                <?php if($message_type == 'success'): ?>
                    <i class="fa-solid fa-check" style="color: #22c55e;"></i>
                <?php else: ?>
                    <i class="fa-solid fa-xmark" style="color: #ef4444;"></i>
                <?php endif; ?>
            </div>
            <div class="notif-content">
                <h3><?= $message_type == 'success' ? 'Succès' : 'Erreur'; ?></h3>
                <p><?= htmlspecialchars($message); ?></p>
            </div>
        </div>
        <script>
            // Masquer automatiquement après 4 secondes
            setTimeout(function() {
                document.getElementById('notification-toast').classList.remove('active');
            }, 4000);
        </script>
    <?php endif; ?>

    <footer class="footer-container">
        <div class="footer">
            <div class="one">
                <figure><img src="/asset/images/logo.webp" alt=""></figure>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse scelerisque in tortor vitae sollicitudin. </p>
            </div>
            <div class="two"><span>Menu</span>
                <a href="">Accueil</a>
                <a href="">Scores</a>
                <a href="">Contact</a>
            </div>
            <div class="three"><span>Contact-nous</span>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                <a href="mailto:contact@web.com">contact@web.com</a>
            </div>
            <div class="four">
                <div class="social-row">
                    <a href=""><img src="/asset/images/facebook-circle-fill.svg" alt=""></a>
                    <a href=""><img src="/asset/images/instagram-fill.svg" alt=""></a>
                    <a href=""><img src="/asset/images/linkedin-fill.svg" alt=""></a>
                    <a href=""><img src="/asset/images/twitter-fill.svg" alt=""></a>
                </div>
            </div>
        </div>
    </footer>
    <hr>
    <div class="mention">
        <p>Copyright © 2025 <img src="/asset/images/logo.webp" width="30" alt="Logo"> - All rights reserved</p>
    </div>

    <script>
        const fileInput = document.getElementById('fileUpload');
        const imgPreview = document.getElementById('profileImagePreview');
        const actionsDiv = document.getElementById('profileActions');
        const originalSrc = imgPreview.src;

        // Quand l'utilisateur sélectionne un fichier
        fileInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imgPreview.src = e.target.result; // Mise à jour visuelle
                    actionsDiv.style.display = 'block'; // Afficher boutons
                }
                reader.readAsDataURL(file);
            }
        });

        // Bouton Annuler
        function resetPreview() {
            fileInput.value = ""; // Vider l'input
            imgPreview.src = originalSrc; // Remettre l'ancienne image
            actionsDiv.style.display = 'none'; // Cacher boutons
        }
    </script>

</body>
</html>
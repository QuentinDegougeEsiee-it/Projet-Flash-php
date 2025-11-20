

<?php 
session_start();

// 1. SECURITY: Check login FIRST before doing anything else
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit; 
}

$user_id = $_SESSION['user_id'];

// 2. Include DB
require 'database.php';
$pdo = connectToDBandGetPDOdb();

// 3. Initialize variables to avoid warnings
$message = null;
$message_type = ""; // "error" or "success"

// 4. Fetch current user info (Execute the query!)
$stmt = $pdo->prepare("SELECT * FROM users WHERE id_user = ?");
$stmt->execute([$user_id]);
$currentUser = $stmt->fetch(PDO::FETCH_ASSOC);

// If user not found in DB (rare edge case), force logout
if (!$currentUser) {
    session_destroy();
    header('Location: login.php');
    exit;
}

// --- PROCESS FORMS ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // --- ACTION: UPDATE EMAIL ---
    if (isset($_POST['action']) && $_POST['action'] === 'update_email') {
        $new_email = trim($_POST['email']);

        if (empty($new_email) || !filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
            $message = "Email invalide.";
            $message_type = "error";
        }
        elseif ($new_email == $currentUser['email']) {
            $message = "Vous n'avez pas changé votre email.";
            $message_type = "error";
        } 
        else {
            // Check if email exists (excluding current user)
            $check = $pdo->prepare("SELECT id_user FROM users WHERE email = ? AND id_user != ?");
            $check->execute([$new_email, $user_id]);
            
            if ($check->rowCount() > 0) {
                $message = "Cet email est déjà utilisé.";
                $message_type = "error";
            } else {
                // DO THE UPDATE
                $update = $pdo->prepare("UPDATE users SET email = ? WHERE id_user = ?");
                if($update->execute([$new_email, $user_id])) {
                    $message = "Email mis à jour avec succès.";
                    $message_type = "success";
                    // Update the variable for display immediately
                    $currentUser['email'] = $new_email; 
                } else {
                    $message = "Erreur lors de la mise à jour.";
                    $message_type = "error";
                }
            }
        }
    }

    // --- ACTION: UPDATE PASSWORD ---
    if (isset($_POST['action']) && $_POST['action'] === 'update_password') {
        $new_password = $_POST['password'];
        
        if (empty($new_password)) {
            $message = "mot de passe invalide.";
            $message_type = "error";
        }
        elseif (password_verify($new_password, $currentUser['password'])) {
            $message = "Vous n'avez pas changé votre mot de passe.";
            $message_type = "error";
        } 
        else {
                // DO THE UPDATE
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update = $pdo->prepare("UPDATE users SET password = ? WHERE id_user = ?");
                if($update->execute([$hashed_password, $user_id])) {
                    $message = "mot de passe mis à jour avec succès.";
                    $message_type = "success";
                    // Update the variable for display immediately
                    $currentUser['password'] = $hashed_password;
                    } 
                else {
                    $message = "Erreur lors de la mise à jour.";
                    $message_type = "error";
                }
        }
    }
}
?>
<?php




if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit; // Always exit after a header redirect
}


if (isset($_SESSION['user_name']) && $_SESSION['user_name'] == "root") {
    echo '<pre style="color:white;">';
    echo "User ID: " . $_SESSION['user_id'] . "<br>";
    print_r($_SESSION); 
    echo '</pre>';
}

// 4. The rest of your page content goes here...
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <link rel="stylesheet" href="/asset/css/Account.css">
    <link rel="stylesheet" href="/asset/css/navbar.css">
    <link rel="shortcut icon" href="/asset/images/favicon.png" type="image/x-icon">
</head>
<body>
    <header class="header-account">
        <div class="back"><a onclick="history.back()" href="#"><img width="30" src="/asset/images/arrow-left-wide-line.svg" alt=""><span class="back-text">Retour</span></a></div>
    </header>
    <section class="header-container-image-account">
        <div class="image-account-banner">
            <figure><img class="image-account" src="/asset/images/Banner-account.jpg" draggable="false" alt=""></figure>
            
        </div>
    </section>
    <h1 class="title">Vos informations</h1>
<?php if ($message): ?>
        <div style="text-align:center; padding: 10px; color: <?= $message_type == 'error' ? 'red' : 'green'; ?>; font-weight:bold;">
            <?= htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>
    <section class="container-modif-global">
        <div class="container-modif">
        <div class="left-container-email">
        <h1 class="txt-modif">Modifier votre email :</h1>
        <form action="" method="POST" class="form-account">
                    <input type="hidden" name="action" value="update_email">
                    
                    <label for="email"></label>
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

            <label for="password"></label>
            <div class="input-and-btn">
                <input type="password" name="password" minlength="8" id="password" placeholder="Nouveau mot de passe"  >
                <button class="btn-modif" type="submit" value="submit">
                    <figure><img class="btn-modif" src="/asset/images/pencil-fill.svg" alt="Modifier" width="20" height="20"></figure>
                </button>
            </div>
            </div>
        </form>
        </div>
    </section>
    <footer class="footer-container">
    <div class="footer">
<div class="one" ><figure><img src="/asset/images/logo.webp" alt=""></figure>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse scelerisque in tortor vitae sollicitudin. </p>
</div>
<div class="two"><span>Menu</span>
<a href="">Accueil</a>
<a href="">Scores</a>
<a href="">Contact</a></div>
<div class="three"><span>Contact-nous</span>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
<a href="mailto:contact@web.com">contact@web.com</a></div>
<div class="four">
    <div class="social-row">
        <a href=""><img src="/asset/images/facebook-circle-fill.svg" alt=""></a>
        <a href=""><img src="/asset/images/instagram-fill.svg" alt=""></a>
        <a href=""><img src="/asset/images/linkedin-fill.svg" alt=""></a>
        <a href=""><img src="/asset/images/twitter-fill.svg" alt=""></a>
    </div>
</div>


</footer>
<hr>
<div class="mention">
    <p>Copyright © 2025 <img src="/asset/images/logo.webp" width="30" alt="Logo"> - All rights reserved</p>
</div>
</body>
</html>

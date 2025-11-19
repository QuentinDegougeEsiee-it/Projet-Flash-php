
<?php
session_start();

require_once 'vendor/autoload.php';
require 'database.php';

$pdo = connectToDBandGetPDOdb();

// --- CONFIGURATION ---
// REMINDER: Store these in a separate file or environment variables!
$clientID = '1017172755379-mn9kv7sa20tb42nng8sti6p6c1c0j9t6.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost/projet/login.php';

$client = new Google\Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

// --- LOGIQUE DE CONNEXION ---

if (isset($_GET['code'])) {
    // CAS 2 : Google a redirigé l'utilisateur avec un code
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    // FIX 1: Removed the empty "if()" syntax error
    if (!isset($token['error'])) {
        $client->setAccessToken($token['access_token']);

        // On récupère les infos du profil Google
        $oauth2 = new Google\Service\Oauth2($client);
        $googleUser = $oauth2->userinfo->get();
        
        // FIX 2: execute() expects an array for parameters
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$googleUser->email]); 
        $user = $stmt->fetch();

        if ($user) {
            // L'utilisateur existe
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_picture'] = $googleUser->picture;

            // Redirection vers l'accueil
            header('Location: /projet/');
            exit; // FIX 3: Always exit after a header redirect
        } else {
            // L'utilisateur n'est pas inscrit
            // FIX 4: Handle the error properly so it doesn't redirect anyway
            echo "Erreur : Cet adresse email n'est pas inscrite dans notre base de données.";
            // Optional: Link to registration page?
            header('Location: /projet/register.php');
            exit; 
        }

    } else {
        echo "Erreur lors de la connexion avec Google (Token Error).";
    }
} else {
    // CAS 1 : Génération de l'URL de connexion
    $loginUrl = $client->createAuthUrl();
    // You typically want to display a link here:
    // echo "<a href='$loginUrl'>Se connecter avec Google</a>";
}
?>

 
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="/asset/css/styles-login.css">
    <link rel="shortcut icon" href="/asset/images/favicon.png" type="image/x-icon">
</head>
<body>
    <div class="container">
        <div class="left-container">
            <div class="text-container">
                <h1>Heureux de vous revoir 👋</h1>
                <p>Vos quêtes et vos amis vous attendent ! Entrez vos identifiants pour replonger instantanément dans l'action et continuer votre aventure.</p>
            </div>

            <!-- Zone d'affichage des erreurs -->
            <?php if (isset($_SESSION['login_error'])): ?>
                <p style="color:red; font-weight:bold;">
                    <?= $_SESSION['login_error']; ?>
                </p>
                <?php unset($_SESSION['login_error']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <p style="color:green; font-weight:bold;">
                    <?= $_SESSION['success']; ?>
                </p>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <!-- Formulaire correctement relié à auth.php -->
            <form class="form-container" action="./utils/userConnexion.php" method="POST">
                <label for="email">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    placeholder="Exemple@email.com" 
                    required
                    value="<?= isset($_SESSION['old_input_email']) ? htmlspecialchars($_SESSION['old_input_email']) : '' ?>"
                >

                <label for="password">Mot de passe</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    placeholder="8 caractères minimum" 
                    required
                >

                <a class="a-mdp-oublie" href="/">Mot de passe oublié ?</a>

                <button class="connexion-btn" type="submit">Connexion</button>
            </form>

            <div class="other-options">
                <div class="divider">
                    <span>Ou</span>
                </div>
<?php if (!isset($_SESSION['user_email'])): ?>
                <a class="connect-google" href="<?php echo $loginUrl; ?>">
                    <img class="img-google" src="/asset/images/Google.svg" alt="Logo Google">
                    <span class="text google">‎ Se connecter avec Google</span>
                </a>
                
        
    <?php else: ?>
        <p>Bonjour, <?php echo $_SESSION['user_name']; ?> !</p>
        <img src="<?php echo $_SESSION['user_picture']; ?>" alt="Avatar" width="50">
    <?php endif; ?>

                <p class="signup-link">
                    Pas de compte ? <a href="register.php">Je m'inscris</a>
                </p>
            </div>
        </div>

        <div class="right-container">
            <img class="image-login" src="/asset/images/Login-img.jpg" alt="Illustration connexion">
        </div>
    </div>
</body>
</html>
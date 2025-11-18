<?php
session_start();
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

                <a class="connect-google" href="#">
                    <img class="img-google" src="/asset/images/Google.svg" alt="Logo Google">
                    <span class="text google">‎ Se connecter avec Google</span>
                </a>

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
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

            <form class="form-container" action="/register" method="POST">
                

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

                <label for="confirm-password">Confirmer le mot de passe</label>
                <input 
                    type="password" 
                    name="confirm-password" 
                    id="confirm-password" 
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

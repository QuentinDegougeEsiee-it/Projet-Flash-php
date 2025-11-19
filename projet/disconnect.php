<?php
// 1. On démarre la session (obligatoire pour pouvoir y toucher)
session_start();

// 2. On détruit toutes les variables de session (vidage du tableau)
$_SESSION = array();

// 3. On efface le cookie de session côté utilisateur
// C'est une étape de sécurité importante pour invalider complètement l'ID de session
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 4. On détruit la session sur le serveur
session_destroy();

// 5. On redirige l'utilisateur vers la page de connexion (ou l'accueil)
header("Location: login.php");
exit; // Toujours mettre exit après une redirection
?>
<?php
// utils/userConnexion.php

// 1. On inclut common.php pour avoir accès à la DB et session_start()
// On utilise __DIR__ pour s'assurer que le chemin est correct peu importe où on est
require_once __DIR__ . '/common.php'; 

// ============================================================
// PARTIE 1 : LES FONCTIONS (Logique métier)
// ============================================================

/**
 * Tente de connecter un utilisateur
 * Retourne true si succès, false sinon
 */
function loginUser($email, $password) {
    $pdo = connectToDBandGetPDOdb();
    
    // Requête préparée pour la sécurité
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Vérification : l'utilisateur existe ET le mot de passe correspond
    if ($user && password_verify($password, $user['password'])) {
        // Sécurité : on régénère l'ID de session pour éviter le "Session Fixation"
        session_regenerate_id(true);
        
        // On stocke les infos utiles en session (mais JAMAIS le mot de passe)
        $_SESSION['user_id'] = $user['id_user'];
        $_SESSION['user_name'] = $user['pseudo']; // ou 'pseudo' selon ta base
        $_SESSION['user_role'] = $user['role'] ?? 'user'; 

        return true;
    }

    return false;
}

/**
 * Déconnecte l'utilisateur
 */
function logoutUser() {
    $_SESSION = []; // Vide le tableau de session
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy(); // Détruit la session sur le serveur
}


// ============================================================
// PARTIE 2 : TRAITEMENT DU FORMULAIRE (Logique de contrôle)
// ============================================================

// On vérifie si la page est appelée via la méthode POST (soumission du formulaire)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Récupération et nettoyage des données
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';

    // 2. Validation basique
    $errors = [];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'adresse email n'est pas valide.";
    }

    if (empty($password)) {
        $errors[] = "Le mot de passe est requis.";
    }

    // 3. Tentative de connexion s'il n'y a pas d'erreurs de format
    if (empty($errors)) {
        if (loginUser($email, $password)) {
            // SUCCÈS : On redirige vers la page d'accueil ou dashboard
            $_SESSION['success'] = "Ravi de vous revoir, " . e($_SESSION['user_name']) . " !";
            header('Location: ../index.php'); // Adapte le chemin si nécessaire
            exit;
        } else {
            // ÉCHEC : Mauvais identifiants
            $errors[] = "Email ou mot de passe incorrect.";
        }
    }

    // 4. Gestion des erreurs (Si on arrive ici, c'est que ça a raté)
    if (!empty($errors)) {
        $_SESSION['login_error'] = implode('<br>', $errors);
        // On renvoie l'email pour éviter à l'utilisateur de le retaper (optionnel)
        $_SESSION['old_input_email'] = $email; 
        
        // Redirection vers la page de login
        header('Location: ../login.php'); // Adapte le chemin vers ton fichier HTML
        exit;
    }
}
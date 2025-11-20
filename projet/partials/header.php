<?php 
session_start(); 

// --- Sécurité : Redirection si non connecté ---
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit; 
}

// --- Récupération de l'avatar user ---
$pdo = connectToDBandGetPDOdb();
$stmt = $pdo->prepare("SELECT photo_profil FROM users WHERE id_user = ?");
$stmt->execute([$_SESSION['user_id']]); 
$resultat = $stmt->fetch(PDO::FETCH_ASSOC);

// --- Définition de l'image (BDD ou Défaut) ---
if ($resultat && !empty($resultat['photo_profil'])){
    $_SESSION['user_picture'] = "http://localhost/projet/". $resultat['photo_profil'];
} else {
    $nomUser = $_SESSION['user_name'] ?? 'User';
    $_SESSION['user_picture'] = 'https://ui-avatars.com/api/?name=' . urlencode($nomUser) . '&background=random';
}

// --- Gestion de la page active (Navigation) ---
$page_demandee_clean = strtok($_SERVER['REQUEST_URI'], '?');

$uri_accueil = '/projet/';
$uri_scores  = '/projet/games/memory/scores.php';
$uri_contact = '/projet/contact.php';

function est_active(string $uri_lien, string $uri_actuelle_clean): string {
    return (strcasecmp($uri_lien, $uri_actuelle_clean) === 0) ? ' active-page' : '';
}

// --- Debug (Admin/Root seulement) ---
if (isset($_SESSION['user_name']) && $_SESSION['user_name'] == "root") {
    echo '<details style="text-align:center;">
  <summary>Admin</summary>
';
    echo '<pre>User ID: ' . $_SESSION['user_id'] . '<br>';
    print_r($_SESSION); 
    echo '</pre> </details>';
}
?>

<head>
    <link rel="stylesheet" href="/asset/css/navbar.css">
</head>

<div style="background-color:#070320;">
<header class="header">
    <nav class="navbar">
        <img class="logo" src="/asset/images/logo.webp" alt="Logo" />

        <ol class="Ol-flex">
            <li class="list-nav">
                <a href="<?php echo $uri_accueil; ?>" class="nav-link <?php echo est_active($uri_accueil, $page_demandee_clean); ?>">
                    Accueil
                </a>
            </li>
            
            <li class="list-nav">
                <a href="<?php echo $uri_scores; ?>" class="nav-link <?php echo est_active($uri_scores, $page_demandee_clean); ?>">
                    Scores
                </a>
            </li>
            
            <li class="list-nav">
                <a href="<?php echo $uri_contact; ?>" class="colored-btn-nav nav-link <?php echo est_active($uri_contact, $page_demandee_clean); ?>">
                    Nous contacter
                </a>
            </li>
        
            <li class="list-nav">
                <div class="dropdown">
                    <a href="#" style="display: flex; align-items: center;">
                        <img class="avatar" 
                             src="<?php echo $_SESSION['user_picture']; ?>" 
                             alt="Profil">
                    </a>
                    
                    <div class="dropdown-content">
                        <a href="/projet/Account.php">Mon Profil</a>
                        <a href="/projet/disconnect.php">Déconnexion</a>
                    </div>
                </div>
            </li>
        </ol>
    </nav>
</header>
</div>
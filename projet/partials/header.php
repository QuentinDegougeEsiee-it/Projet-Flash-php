<?php 

session_start(); 

// 1. VÉRIFICATION DE SÉCURITÉ (En premier)
// Si l'utilisateur n'est pas connecté, on redirige tout de suite.
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Assure-toi que le chemin est correct
    exit; 
}

// 2. RÉCUPÉRATION DE LA PHOTO (Correction de l'erreur Array to string)
// On suppose que la fonction connectToDBandGetPDOdb() est accessible ici via un include précédent
$pdo = connectToDBandGetPDOdb();

$sql = "SELECT photo_profil FROM users WHERE id_user = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user_id']]); 

// On récupère le résultat sous forme de tableau associatif
$resultat = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérification : est-ce qu'on a un résultat ET est-ce que la colonne n'est pas vide ?
if ($resultat && !empty($resultat['photo_profil'])){
    // C'est ici que l'erreur est corrigée : on prend uniquement la chaîne de caractères
    $_SESSION['user_picture'] = 'http://localhost/projet/' . $resultat['photo_profil'];
}
else {
    // Sinon, on met l'avatar par défaut
    $nomUser = $_SESSION['user_name'] ?? 'User';
    $_SESSION['user_picture'] = 'https://ui-avatars.com/api/?name=' . urlencode($nomUser) . '&background=random';
}




// 1. Récupération de l'URI demandée
$page_demandee = $_SERVER['REQUEST_URI'];

$page_demandee_clean = strtok($page_demandee, '?');


$uri_accueil = '/projet/';
$uri_scores = '/projet/games/memory/scores.php';
$uri_contact = '/projet/contact.php';


function est_active(string $uri_lien, string $uri_actuelle_clean): string {

    return (strcasecmp($uri_lien, $uri_actuelle_clean) === 0) ? ' active-page' : '';
}






if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit; 
}


if (isset($_SESSION['user_name']) && $_SESSION['user_name'] == "root") {
    echo '<pre>';
    echo "User ID: " . $_SESSION['user_id'] . "<br>";
    print_r($_SESSION); 
    echo '</pre>';
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
                        <a onlcick="" href="/projet/disconnect.php">Déconnexion</a>
                    </div>
                </div>
            </li>
        </ol>
    </nav>
</header>
</div>
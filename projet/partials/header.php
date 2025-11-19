<?php 

// 1. Récupération de l'URI demandée
$page_demandee = $_SERVER['REQUEST_URI'];

$page_demandee_clean = strtok($page_demandee, '?');


$uri_accueil = '/projet/';
$uri_scores = '/projet/games/memory/scores.php';
$uri_contact = '/projet/contact.php';


function est_active(string $uri_lien, string $uri_actuelle_clean): string {

    return (strcasecmp($uri_lien, $uri_actuelle_clean) === 0) ? ' active-page' : '';
}

?>
<?php

session_start(); 


if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit; // Always exit after a header redirect
}


if (isset($_SESSION['user_name']) && $_SESSION['user_name'] == "root") {
    echo '<pre>';
    echo "User ID: " . $_SESSION['user_id'] . "<br>";
    print_r($_SESSION); 
    echo '</pre>';
}

// 4. The rest of your page content goes here...
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
                             src="https://ui-avatars.com/api/?name=<?php echo htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?>&background=random" 
                             alt="Profil">
                    </a>
                    
                    <div class="dropdown-content">
                        <a href="/projet/Account.php">Mon Profil</a>
                        <a href="#">Paramètres</a>
                        <a onlcick="" href="./login.php">Déconnexion</a>
                    </div>
                </div>
            </li>
        </ol>
    </nav>
</header>
</div>
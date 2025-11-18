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
    header('Location: ./login.php');
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
    <style>
        .active-page {
            font-weight: bold;
            color: #ffcc00 !important; 
            border-bottom: 3px solid #ffcc00;
        }
    </style>
</head>
<div style="background-color:#070320;">
<header class="header">
    <nav class="navbar">
    <img src="/asset/images/logo.webp" alt="image_logo à définir" width="100" height="100"/>
        <ol>
            <li class="list-nav">
                <a href="<?php echo $uri_accueil; ?>" class="nav-link<?php echo est_active($uri_accueil, $page_demandee_clean); ?>"> Accueil </a>
            </li>
            
            <li class="list-nav">
                <a href="<?php echo $uri_scores; ?>" class="nav-link<?php echo est_active($uri_scores, $page_demandee_clean); ?>"> Scores </a>
            </li>
            
            <li class="list-nav">
                <a class="colored-btn-nav nav-link<?php echo est_active($uri_contact, $page_demandee_clean); ?>" href="<?php echo $uri_contact; ?>"> Nous contacter </a>
            </li>
        </ol>
    </nav>
</header>
</div>
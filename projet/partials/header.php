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
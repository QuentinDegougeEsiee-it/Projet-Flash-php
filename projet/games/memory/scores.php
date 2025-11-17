<!DOCTYPE html>
<html lang="fr">
<head>
    
    <meta charset="utf-8">
    <title>Scores</title>
    <link rel="stylesheet" href="/asset/css/scores.css">
   
    <link rel="shortcut icon" href="/asset/images/favicon.png" type="image/x-icon">
    <style>

    </style>
</head>
<?php include '../../partials/header.php'; ?>
<?php
// Inclure la base de données
require '../../database.php';
$pdo = connectToDBandGetPDOdb();

/*
 * REQUÊTE AMÉLIORÉE (HYPOTHÉTIQUE)
 *
 * J'imagine que vous avez :
 * 1. Une table 'users' avec 'id' et 'username'
 * 2. Une table 'games' avec 'id', 'game_name' et 'game_image'
 * 3. Votre table 'score' a des colonnes 'difficulty' et 'created_at' (ou 'game_date')
 *
 * Adaptez les noms de tables et de colonnes si besoin !
*/
$sql = "
    SELECT 
        s.game_score, 
        s.difficulty, 
        s.created_at,
        u.pseudo AS player_name,
        g.name
        
    FROM score AS s
    JOIN users AS u ON s.id_user = u.id_user
    JOIN jeu AS g ON s.game_id = g.id
    ORDER BY s.game_score DESC
    LIMIT 6";

$request_all_player = $pdo->prepare($sql);
$success = $request_all_player->execute();

if ($success) {
    $all_players = $request_all_player->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Gérer l'erreur (par exemple, afficher un message)
    $all_players = []; // Initialiser en cas d'échec
}

// Fonction helper pour formater le score (si 'game_score' est en secondes)


// Fonction helper pour formater la date
function format_date_fr($date_sql) {
    $date = new DateTime($date_sql);
    return $date->format('d/m/y'); // Format "29/09/25"
}

?>
</body>

    <div>
        <div><h1 class="titre">SCORES</h1></div>
        <p class="sous_titre">Que les esprits des mondes oubliés guident ton destin… Voici ton score, gravé dans les runes du destin !</p>
    </div>
    <section>
        <table id="tableau_score">
            <thead class="ligne1">
                <th>#</th>
                <th class="alignement3">JEU</th>
                <th class="padding_droit1">JOUEUR</th>
                <th class="padding_droit1">DIFFICULTE</th>
                <th class="padding_droit2">SCORE</th>
                <th>Date</th>
            </thead>
<?php




?>



            <tbody class="body">
    <?php if (empty($all_players)): ?>
        
        <tr class="ligne2">
            <td colspan="6" style="text-align: center;">Aucun score à afficher pour le moment.</td>
        </tr>

    <?php else: ?>

        <?php foreach ($all_players as $index => $player): ?>
            <tr class="ligne2">
                
                <td><?php echo $index + 1; // Affiche le rang #1, #2, etc. ?></td>
                
                <td class="alignement2">
                    <div class="arrondis">
                        <img src="/asset/images/avatar-face-score.jpg" alt="image du jeu" width="50" height="50" style="border-radius:15px;"/>
                        <span class="padding_droit3"><?php echo htmlspecialchars($player['name']); ?></span>
                    </div>
                </td>
                
                <td><?php echo htmlspecialchars($player['player_name']); ?></td>
                
                <td><?php echo htmlspecialchars($player['difficulty']); ?></td>
                
                <td><?php echo $player['game_score']; ?></td>
                
                <td><?php echo format_date_fr($player['created_at']); ?></td>

            </tr>
        <?php endforeach; ?>

    <?php endif; ?>
</tbody>
        </table>


        
<section class="container-bottom">
  
    <div class="left-container">
      <h2>Joue au Mémoire — Teste ta mémoire, amuse-toi, gagne des points !</h2>
      <p>Plonge dans l’univers du jeu de mémoire : retrouve les paires cachées, affronte le chronomètre et grimpe au classement ! Idéal pour les enfants comme pour les adultes, ce jeu stimule la concentration et la mémoire visuelle. Prêt(e) à relever le défi ?</p>
      <p>Plus tu joues, plus tu progresses ! Débloque des niveaux, des thèmes et des récompenses en atteignant des scores élevés.</p>
      <a href="Jeu.html">Jouer</a>
  </div>
  <div class="right-container">
      <img src="asset/images/image-memorie.png" alt="">
  </div>

</section>


    
    
<footer class="footer-container">
    <div class="footer">
<div class="one" ><img src="asset/images/logo.webp" alt="">
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse scelerisque in tortor vitae sollicitudin. </p>
</div>
<div class="two"><span>Menu</span>
<a href="">Accueil</a>
<a href="">Scores</a>
<a href="">Contact</a></div>
<div class="three"><span>Contact-nous</span>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
<a href="mailto:contact@web.com">contact@web.com</a></div>
<div class="four">
    <div class="social-row">
        <a href=""><img src="asset/images/facebook-circle-fill.svg" alt=""></a>
        <a href=""><img src="asset/images/instagram-fill.svg" alt=""></a>
        <a href=""><img src="asset/images/linkedin-fill.svg" alt=""></a>
        <a href=""><img src="asset/images/twitter-fill.svg" alt=""></a>
    </div>
</div>


</footer>
<hr>
<div class="mention">
    <p>Copyright © 2025 <img src="asset/images/logo.webp" width="30" alt="Logo"> - All rights reserved</p>
</div>
    </footer>
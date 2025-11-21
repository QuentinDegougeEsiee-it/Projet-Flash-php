<?php 
require 'Database.php';
$pdo = connectToDBandGetPDOdb();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
   
    <link rel="stylesheet" href="../asset/css/index.css">
    <link rel="shortcut icon" href="../asset/images/favicon.png" type="image/x-icon">
</head>
<body>
    <link rel="stylesheet" href="/asset/index.css">

<?php include './partials/header.php'; ?>
<div class="container">
    



        <!--Hero section-->
        <section class="hero-section">
            <small>Jouez. Mémorisez. Gagnez.</small>
            <h1>Des jeux rapides et addictifs</h1>
            <p>Power of Memories vous propose des parties courtes et stimulantes pour entraîner votre mémoire, grimper au
                classement et battre vos amis. Accessible à tous, amusant pour chacun.</p>

            <a href="./views/game.html">Commencer !</a>
            <img src="/asset/images/mannette.png">
        </section>

        <section class="game-section">
            <h2>Nos jeux</h2>

            <div class="flex">
                <figure>
                    <img src="/asset/images/Memory_1.svg" alt="Description de l'image">
                    <figcaption>Power Of Memory</figcaption>
                </figure>

                <figure>
                    <img src="/asset/images/Memory_1.svg"alt="Description de l'image">
                    <figcaption>Jeux #2</figcaption>
                </figure>

                <figure>
                    <img src="/asset/images/Memory_1.svg" alt="Description de l'image">
                    <figcaption>Jeux #2</figcaption>
                </figure>
            </div>
        </section>

        <h2 class="title">Jouez quelques minutes par jour pour améliorer votre attention et votre mémoire.</h2>

        <section class="desc">
            <h2>Lorem Ipsum</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse scelerisque in tortor vitae
                sollicitudin. Aliquam lacus augue, rhoncus eget porta et, egestas ut augue.</p>
        </section>

    
    <section  class="game-img-section">
        <img src="/asset/images/VideoGame 2.svg" class="img-bg">
        <img src="/asset/images/Grid.svg" class="grid-img">
    </section>



        <section class="stats">
        <div class="container">
            <h2>Lorem Ipsum is simply dummy text of the printing<br> and typesetting industry.</h2>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                industry's standard dummy text ever since the 1500s,</p>

            <div class="flex-3">
                <span class="stat stat-blue">
                    <span>
                        <?php 
$request_all_player = $pdo->prepare("SELECT COUNT(id) FROM score");

$success2 = $request_all_player->execute();

if ($success2) {
    $count2 = $request_all_player->fetchColumn();
    echo  $count2;
} else {
    echo "Error executing the database query.";
} ?>
</span>
                    <small>Parties Jouées</small>
                </span>

                <span class="stat stat-white">
                    <span>1020</span>
                    <small>Joueurs Connectés</small>
                </span>

                <span class="stat stat-orange">
                    <span> 
        <?php
$request_all_player = $pdo->prepare("SELECT min(game_score) FROM score");

$success2 = $request_all_player->execute();

if ($success2) {
    $count2 = $request_all_player->fetchColumn();
    $count3 = $count2 / 60;
    echo round( $count3 ,2) . "<span style='font-size: 1rem'>Min</span>";
    
} else {
    echo "Error executing the database query.";
}

                    
                    
                    
                    
                    
                    
                    ?></span>
                    <small>Temps Records</small>
                </span>
            </div>

            <div class="flex-2">
                <span class="stat stat-red">
                    <span>
 <?php 
$request_all_player = $pdo->prepare("SELECT COUNT(id_user) FROM users");

$success2 = $request_all_player->execute();

if ($success2) {
    $count2 = $request_all_player->fetchColumn();
    echo  $count2;
} else {
    echo "Error executing the database query.";

} ?>
</span>
                    <small>Joueurs Inscrits</small>
                </span>

                <span class="stat stat-orange">
                    <span>
                        <?php 
$request_last_record = $pdo->prepare("SELECT count(id_user) 
FROM score 
WHERE 
    
    created_at >= CURDATE() 
    
   
    AND game_score > (
        SELECT MAX(game_score) 
        FROM score 
        WHERE created_at < CURDATE()
    ) ORDER BY game_score DESC LIMIT 1;");
$success3 = $request_last_record->execute();
if ($success3) {
    $count3 = $request_last_record->fetchColumn();
    echo  $count3;
} else {
    echo "Error executing the database query.";

}
                        
                        ?>
                    </span>
                    <small>Records battu aujourd’hui</small>
                </span>
            </div>
        </div>
    </section>
    <!--Crew section-->
    <section class="crew">
        <h2>Notre équipe</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse scelerisque in tortor vitae
            sollicitudin.</p>

        <div class="flex-3">
            <figure>
                <img src="./assets/img/member1.jpeg" alt="Thomas Galabert">
                <figcaption>Tristan</figcaption>
            </figure>

            <figure>
                <img src="./assets/img/member2.png" alt="Description de l'image">
                <figcaption>Quentin</figcaption>
            </figure>
                        <figure>
                <img src="./assets/img/member1.jpeg" alt="Thomas Galabert">
                <figcaption>Emma</figcaption>
            </figure>
        </div>

    </section>

    <div class="container">
        <section class="desc">
            <h2>Lorem Ipsum</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse scelerisque in tortor vitae
                sollicitudin. Aliquam lacus augue, rhoncus eget porta et, egestas ut augue.</p>
        </section>

        <!--Newslatter section-->
        <div class="banner">
            <div>
                <h2>Restez informé</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse scelerisque in tortor vitae
                    sollicitudin.</p>
            </div>

            <form method="post">
                <input type="email" placeholder="Adresse email">
                <button class="confirm-btn">Valider</button>
            </form>
        </div>
    </div>



</div>



<?php include './partials/footer.php'; ?>
</body>
</html>


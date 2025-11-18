<?php 
require 'Database.php';
$pdo = connectToDBandGetPDOdb();

// 1. Prepare the statement
$request = $pdo->prepare("SELECT COUNT(id) FROM score");

// 2. Execute the statement (returns TRUE or FALSE)
$success = $request->execute();

// 3. Check for success and fetch the result (the count is the first column)
if ($success) {
    $count = $request->fetchColumn();
    echo "Nombre de partie jouer " . $count;
} else {
    echo "Error executing the database query.";
    // You might also want to print error details here for debugging
    // print_r($request->errorInfo()); 
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceuil</title>
   
    <link rel="stylesheet" href="../asset/css/index.css">
    <link rel="shortcut icon" href="../asset/images/favicon.png" type="image/x-icon">
</head>
<body>
    

<?php include './partials/header.php'; ?>




    <section class="banniere">
        <p class="o">Découvrez nos jeux</p>
        <h1>Jouez,<br>progressez et<br>défiez vos amis !</h1>
        <p>Une plateforme de jeux en ligne pour tester votre mémoire, vos réflexes et vos stratégies.<br> tout en
            suivant vos scores et ceux de vos amis !</p>
        <a href="contact.html">Commencer !</a>
        <img class="fond_o" src="/asset/images/8bdd2c3954dcf48e04c5934bbab4c1a3cbcad318.png">
    </section>

    <section class="nos_jeux">
        <h2>Nos Jeux</h2>
        <div class="photo">
            <div>
                <figure>
                    <img src="/asset/images/Memory 1.svg">
                </figure>
                <span style="color: white;">Power of Memory</span>
            </div>

            <div>
                <figure>
                    <img src="/asset/images/Controller.svg">
                </figure>
                <span style="color: white;">Jeux #2 </span>
            </div>

            <div>
                <figure>
                    <img src="/asset/images/Controller.svg">
                </figure>
                <span style="color: white;">Jeux #3</span>
            </div>
        </div>
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
                    <span> <?php
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
    <section class="team">
        <h2>Notre équipe</h2>
        <p>tout un groupe compétent certain un peu plus que les autres</p>
        <div class="membre">
            <figure>
                <img src="https://cdn.discordapp.com/attachments/1422198805897412638/1423252936519057540/IMG_0665.jpg?ex=68e04bd6&is=68defa56&hm=95858816bcec17b586f7d6ffab98aac7bafb77797381836487bf7224381cd4d6">
                <figcaption>Sohan</figcaption>
            </figure>

            <figure>
                <img src="https://cdn.discordapp.com/attachments/1422198805897412638/1423582264742252544/IMG_20251002_103834.jpg?ex=68e0d5cc&is=68df844c&hm=c302d28efb7d0dc16dc2cf32bc23755478c6618ab7c97bdb51ecef9496ec1f1f">
                <figcaption>Tristan</figcaption>
            </figure>


            <figure>

                <img src="https://cdn.discordapp.com/attachments/1422198805897412638/1423582276372922378/IMG_20240427_142110.jpg?ex=68e0d5cf&is=68df844f&hm=577918929ebebc4b91997379ee873c5e2e54c74276597bf885723d3ad141ef21">
                <figcaption>Quentin</figcaption>
            </figure>

        </div>
    </section>
    <section class="stay_i">
        <h2></h2>
        <p></p>
        <div>
            <h2>Restez Informé</h2>
            <p>rentrez votre adresse mail pour toute nouveautée</p>
            <form action="">
                <input type="email" name="" id="">
                <button>
                    Valider

                </button>
            </form>

        </div>
    </section>






<?php include './partials/footer.php'; ?>
</body>
</html>

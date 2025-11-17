<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="/asset/css/contact.css">
    <link rel="stylesheet" href="/asset/css/navbar.css">
    <link rel="shortcut icon" href="/asset/images/favicon.png" type="image/x-icon">
</head>
<body>
    <?php include './partials/header.php'; ?>



<section>
    <h1 class="title">
       Contactez-nous
    </h1>
    <p class="under-title">Nous sommes toujours ravis d'échanger avec vous. Que vous ayez une question, un projet à discuter ou simplement envie de nous dire bonjour, n'hésitez pas à nous écrire ! </p>
    <img class="map-img" src="/asset/images/Map.svg" alt="">
<div style="margin-left: 10%;margin-right: 10%;">
    <div class="contact-container">

        <div class="social-network-container">
        <span class="title-network">Suivez nous</span>
        <div>
        <a href=""><img src="/asset/images/facebook-circle-fill (1).svg" alt=""></a>
        <a href=""><img src="/asset/images/instagram-fill (1).svg" alt=""></a>
        <a href=""><img src="/asset/images/linkedin-fill (1).svg" alt=""></a>
        <a href=""><img  src="/asset/images/twitter-fill (1).svg" alt=""></a>
   </div>
        </div>
        <span class="divider-contact"></span>
        <div class="tel-container" >
            <a href="tel:+33601020304"><img src="/asset/images/phone-fill.svg" alt="">+33601020304</a>
        </div>
        <span class="divider-contact"></span>
        <div class="adresse-container">
            <a class="adress-btn" href="23 rue de Paris 75002 Paris"><img src="/asset/images/map-pin-2-fill.svg"  alt=""> 23 rue de Paris <br> 75002 Paris</a>
        </div>
    </div>
</div>
</section>
<hr class="divider-section-1-to-2">
<section>
    <div class="title-form-container">
    <h1 >Contactez-nous !</h1>
    <p>Remplissez simplement les champs ci-dessous. Nous vous répondrons dans les plus brefs délais, généralement sous 24 heures ouvrées.</p>
</div>
       <div class="form-container">
        <form action="#" method="POST">
            <div class="name-fields">
                <div class="form-group">
                    <label for="first-name">First Name</label>
                    <input type="text" id="first-name" name="first_name">
                </div>
                <div class="form-group">
                    <label for="last-name">Last Name</label>
                    <input type="text" id="last-name" name="last_name">
                </div>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email">
            </div>

            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message"  rows="8"></textarea>
            </div>

            <div class="form-group-submit">
                <button type="submit">Envoyer</button>
            </div>
        </form>
    </div>
</section>




<?php include './partials/footer.php'; ?>

</body>
</html>

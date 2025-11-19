

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <link rel="stylesheet" href="/asset/css/Account.css">
    <link rel="stylesheet" href="/asset/css/navbar.css">
    <link rel="shortcut icon" href="/asset/images/favicon.png" type="image/x-icon">
</head>
<body>
    <header class="header-account">
        <div class="back"><a onclick="history.back()" href="#"><img width="30" src="/asset/images/arrow-left-wide-line.svg" alt=""><span class="back-text">Retour</span></a></div>
    </header>
    <section class="header-container-image-account">
        <div class="image-account-banner">
            <figure><img class="image-account" src="/asset/images/Banner-account.jpg" draggable="false" alt=""></figure>
            
        </div>
    </section>
    <h1 class="title">Vos informations</h1>

    <section class="container-modif-global">
        <div class="container-modif">
        <div class="left-container-email">
        <h1 class="txt-modif">Modifier votre email :</h1>
        <form action="" class="form-account">
            <label for="email"></label>
            <div class="input-and-btn">
                
                <input type="email" name="email" id="email" value="Votre.email@gmail.com" readonly >
                <button class="btn-modif" type="submit" value="submit">
                    <figure><img class="btn-modif" src="/asset/images/pencil-fill.svg" alt="Modifier" width="20" height="20"></figure>
                </button>
            </div>
        </form>
        </div>
        <div class="divider"></div>
        <div class="right-container-password">
            <h1 class="txt-modif">Modifier votre mot de passe :</h1>
            <form action="" class="form-account">
            <label for="password"></label>
            <div class="input-and-btn">
                <input type="password" name="password" id="password" value="⸱⸱⸱⸱⸱⸱⸱⸱⸱⸱⸱⸱⸱" readonly >
                <button class="btn-modif" type="submit" value="submit">
                    <figure><img class="btn-modif" src="/asset/images/pencil-fill.svg" alt="Modifier" width="20" height="20"></figure>
                </button>
            </div>
            </div>
        </form>
        </div>
    </section>
    <footer class="footer-container">
    <div class="footer">
<div class="one" ><figure><img src="asset/images/logo.webp" alt=""></figure>
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
        <figure><a href=""><img src="asset/images/facebook-circle-fill.svg" alt=""></a></figure>
        <figure><a href=""><img src="asset/images/instagram-fill.svg" alt=""></a></figure>
        <figure><a href=""><img src="asset/images/linkedin-fill.svg" alt=""></a></figure>
        <figure><a href=""><img src="asset/images/twitter-fill.svg" alt=""></a></figure>
    </div>
</div>


</footer>
<hr>
<div class="mention">
    <p>Copyright © 2025 <img src="asset/images/logo.webp" width="30" alt="Logo"> - All rights reserved</p>
</div>
</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeu</title>
    <link rel="stylesheet" href="../../../asset/css/navbar.css">
    <link rel="stylesheet" href="../asset/css/jeu.css">
    <link rel="shortcut icon" href="asset/images/favicon.png" type="image/x-icon">
</head>
<body>
    
<?php include '../../partials/header.php'; ?>
<section>
<div class="title-and-p-container">
  <h1>The Power Of Memory</h1>
  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse scelerisque in tortor vitae sollicitudin.</p>
</div>
<form action="">
  <div class="form-container">
    <div class="form-group">
      <label for="grid-size">Taille de la grille</label>
      <select name="grid-size" id="grid-size">
        <option value="4x4">4x4</option>
        <option value="6x6">6x6</option>
        <option value="8x8">8x8</option>
        <option value="10x10">10x10</option>
      </select>
    </div>
    <div class="form-group">
      <label for="theme">Thème</label>
      <select name="theme" id="theme">
        <option value="Jeux video">Jeux video</option>
        <option value="Orbe">Orbe</option>
        <option value="Minecraft">Minecraft</option>
        <option value="Fruit">Fruit</option>
      </select>
    </div>
    <input class="gener-btn" type="submit" value="Générer une grille">
  </div>
</form>
<div class="image-grid">
  <img src="asset/images/good.png" alt="img1" class="grid-img">
  <img src="asset/images/good.png" alt="img2" class="grid-img">
  <img src="asset/images/good.png" alt="img3" class="grid-img">
  <img src="asset/images/good.png" alt="img4" class="grid-img">
  <img src="asset/images/good.png" alt="img5" class="grid-img">
  <img src="asset/images/good.png" alt="img6" class="grid-img">
  <img src="asset/images/good.png" alt="img7" class="grid-img">
  <img src="asset/images/good.png" alt="img8" class="grid-img">
  <img src="asset/images/good.png" alt="img9" class="grid-img">
  <img src="asset/images/good.png" alt="img10" class="grid-img">
  <img src="asset/images/good.png" alt="img11" class="grid-img">
  <img src="asset/images/good.png" alt="img12" class="grid-img">
  <img src="asset/images/good.png" alt="img13" class="grid-img">
  <img src="asset/images/good.png" alt="img14" class="grid-img">
  <img src="asset/images/good.png" alt="img15" class="grid-img">
  <img src="asset/images/good.png" alt="img16" class="grid-img">
</div>
</section>
<section class="container-bottom">
  
    <div class="left-container">
      <h2>Joue au Mémoire — Teste ta mémoire, amuse-toi, gagne des points !</h2>
      <p>Plonge dans l’univers du jeu de mémoire : retrouve les paires cachées, affronte le chronomètre et grimpe au classement ! Idéal pour les enfants comme pour les adultes, ce jeu stimule la concentration et la mémoire visuelle. Prêt(e) à relever le défi ?</p>
      <p>Plus tu joues, plus tu progresses ! Débloque des niveaux, des thèmes et des récompenses en atteignant des scores élevés.</p>
      <a href="">Jouer</a>
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
<a href="index.html">Accueil</a>
<a href="scores.html">Scores</a>
<a href="Contact.html">Contact</a></div>
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
</body>
</html>
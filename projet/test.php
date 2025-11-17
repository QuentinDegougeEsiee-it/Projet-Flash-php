    <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: sans-serif;
    background-color: #070320;
    color: #fff;
}

.container {
    max-width: 1260px;
    padding: 0 20px;
    margin: 0 auto;
}

.hero-section {
    margin-top: 7rem;
    position: relative;

    small {
        color: #e87d0e;
        font-size: 1rem;
        font-weight: bold;
    }

    h1 {
        margin-top: 1.5rem;
        font-size: 4rem;
        max-width: 600px;
    }

    p {
        margin-top: 10px;
        margin-top: 2rem;
        max-width: 420px;
    }

    a {
        background: linear-gradient(135deg, red, orange);
        padding: 15px 45px 15px 20px;
        border-radius: 100px;
        display: block;
        width: max-content;
        margin-top: 3rem;
        cursor: pointer;
        color: #fff;
        text-decoration: none;

    }

    img {
        position: absolute;
        top: 0;
        z-index: -1;
        height: 100%;
        right: 20%;
    }
}

.game-section {
    margin-top: 5rem;

    .flex {
        display: flex;
        justify-content: space-between;
        margin-top: 1rem;
    }

    figure {
        text-align: center;

        figcaption {
            margin-top: 1rem;
        }
    }
}

.title {
    font-size: 2rem;
    text-align: center;
    margin: 5rem 0;
}

.desc {
    margin-top: 5rem;
    max-width: 400px;

    p {
        margin-top: 2rem;
    }
}

.game-img-section {
    margin-top: 5rem;
    position: relative;

    .grid-img {
        position: absolute;
        top: -75px;
        right: 75px;
    }
}

.img-bg {
    width: 100%;
}

.stats {
    margin-top: 5rem;
    background-image: url(../img/Background.png);
    background-size: cover;
    background-repeat: no-repeat;
    height: 100vh;

    h2,
    p {
        text-align: center;
    }

    h2 {
        padding-top: 2rem;
        margin-bottom: 2rem;
    }

    .stat {
        padding: 20px 50px;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        width: max-content;
        text-align: center;

        span {
            font-size: 3rem;
            margin-bottom: .5rem;
        }
    }
}

.flex-3 {
    display: flex;
    justify-content: center;
    gap: 4rem;
    margin-top: 4rem;

    img{
        width: 280px;
        border-radius: 10px;
    }
}

.stat-blue {
    background-color: #019adc;
    color: #fff;
}

.stat-white {
    background-color: #fff;
    color: #000;
}

.flex-2 {
    display: flex;
    justify-content: center;
    gap: 4rem;
    margin-top: 4rem;
}

.stat-orange {
    background-color: #dc7000;
    color: #fff;
}

.stat-red {
    background-color: #d80027;
    color: #fff;
}

.crew {

    h2,
    p {
        text-align: center;
    }

    h2 {
        margin: 2rem 0;
    }

    figure {
        figcaption {
            text-align: center;
            margin-top: 1.5rem;
        }
    }
}

.banner {
    display: flex;
    justify-content: space-between;
    background-color: #fff;
    color: #000;
    border-radius: 10px;
    padding: 40px;
    align-items: center;
    margin-top: 2rem;


    h2 {
        margin-bottom: 1rem;
    }

}

form {
    width: 40%;
    position: relative;

    input {
        padding: 15px;
        background-color: #000;
        color: #fff;
        padding: 15px 40px;
        border: none;
        width: 100%;
        outline: none;
        border-radius: 8px;
    }
}

.confirm-btn {
    padding: 10px 40px;
    background: red;
    position: absolute;
    top: 50%;
    right: 5px;
    cursor: pointer;
    border: none;
    border-radius: 8px;
    transform: translateY(-50%);
    color: #fff;
}

@media (max-width: 768px) {

    .hero-section {
        img {
            display: none;
        }

        h1 {
            font-size: 2rem;
        }
    }

    .game-section {
        .flex {
            display: block;
        }

        img {
            width: 100%;
        }

        figure {
            text-align: start;
        }

        figcaption {
            margin-top: 2rem !important;
            margin-bottom: 1rem;
        }
    }

    .game-img-section {

        .grid-img {

            display: none;
        }
    }

    .flex-3,
    .flex-2 {
        flex-direction: column;
        align-items: center;
    }

    .stats {
        height: auto;
        padding: 20px;
    }

    .flex-2,
    .flex-3 {
        .stat {
            width: 100% !important;
        }
    }

    .banner {
        flex-direction: column;

        form {
            width: 100%;
            margin-top: 1rem;
        }
    }
}

    </style>
    <?php
    include "./partials/header.php"
    ?>
    <div class="container">

        <!--Hero section-->
        <section class="hero-section">
            <small>Jouez. Mémorisez. Gagnez.</small>
            <h1>Des jeux rapides et addictifs</h1>
            <p>Power of Memories vous propose des parties courtes et stimulantes pour entraîner votre mémoire, grimper au
                classement et battre vos amis. Accessible à tous, amusant pour chacun.</p>

            <a href="./views/game.html">Commencer !</a>
            <img src="./assets/img/Banner-Image.png">
        </section>

        <section class="game-section">
            <h2>Nos jeux</h2>

            <div class="flex">
                <figure>
                    <img src="./assets/img/Memory 1.png" alt="Description de l'image">
                    <figcaption>Power Of Memory</figcaption>
                </figure>

                <figure>
                    <img src="./assets/img/Controller.png" alt="Description de l'image">
                    <figcaption>Jeux #2</figcaption>
                </figure>

                <figure>
                    <img src="./assets/img/Controller.png" alt="Description de l'image">
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

    </div>
    <section class="game-img-section">
        <img src="./assets/img/VideoGame 2.png" class="img-bg">
        <img src="./assets/img/Grid.png" class="grid-img">
    </section>

    <!--Stats section-->
    <section class="stats">
        <div class="container">
            <h2>Lorem Ipsum is simply dummy text of the printing<br> and typesetting industry.</h2>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                industry's standard dummy text ever since the 1500s,</p>

            <div class="flex-3">
                <span class="stat stat-blue">
                    <span>310</span>
                    <small>Parties Jouées</small>
                </span>

                <span class="stat stat-white">
                    <span>1020</span>
                    <small>Joueurs Connectés</small>
                </span>

                <span class="stat stat-orange">
                    <span>10s</span>
                    <small>Temps Records</small>
                </span>
            </div>

            <div class="flex-2">
                <span class="stat stat-red">
                    <span>9300</span>
                    <small>Joueurs Inscrits</small>
                </span>

                <span class="stat stat-orange">
                    <span>2</span>
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
                <figcaption>Thomas Galabert</figcaption>
            </figure>

            <figure>
                <img src="./assets/img/member2.png" alt="Description de l'image">
                <figcaption>Maxence Boisseau</figcaption>
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

    <!--Footer-->
    <footer>
        <div class="footer-top">
            <div>
                <h2>Logo</h2>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ut cupiditate doloremque saepe molestias
                    fugit minima debitis excepturi in soluta, blanditiis recusandae veritatis officia odio, voluptatibus
                    rem officiis accusantium ratione porro.</p>
            </div>
            <div>
                <h3>Menu</h3>
                <nav>
                    <ul>
                        <li>
                            <a>Accueil</a>
                        </li>

                        <li>
                            <a>Scores</a>
                        </li>

                        <li>
                            <a>Contact</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div>

                <h3>Contactez-nous</h3>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Earum repudiandae numquam placeat pariatur
                    eveniet doloremque exercitationem rerum officia eum maxime ipsum, dignissimos dolorum vero
                    voluptatem est, aperiam nesciunt autem fuga.</p>

                <p class="mail">contact@web.com</p>
            </div>
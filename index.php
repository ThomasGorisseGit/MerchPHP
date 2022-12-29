<?php
session_start();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/main.css">
    <link rel="stylesheet" href="./styles/navbar.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">

    <title>SeinkSansGroove</title>
</head>

<body>
    <header>
        <!-- Header de la page d'accueil -->
        <div class="main-title">

            <img class="logo" src="./assets/Logo.png" alt="Logo de l'entreprise">
            <h1 id="title">SeinkSansGroove</h1>

            <a href="#">
                Marques
            </a>
            <a href="#">
                Panier
            </a>

            <form action="#">
                <input class="research-bar" type="text" placeholder=" Search Courses" name="search">
                <button>
                    <i class="" style="font-size: 18px;">
                    </i>
                </button>
            </form>
            <div class="user">
                <?php require_once("./connectionView.php"); ?>
            </div>
        </div>
        <nav>
            <ul class="brands-list">
                <li>Marshall</li>
                <li>JBL</li>
                <li>Bose</li>
            </ul>
        </nav>
    </header>
    <main>
        <!-- Contenu de la page d'accueil yo-->
        <section class="article-list">
            <article class="article-item">
                <div class="item-image">photo</div>
                <div class="item-content">

                    <h1 class="item-title">JBL - Flip 5 Noir</h1>
                    <div class="item-price-delivery">
                        <span class="item-price">188.56€</span>
                        <span class="item-delivery">truck 5.32€</span>
                    </div>
                    <p class="item-description">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut lobortis, neque egestas elementum lobortis, tellus risus molestie nisi, vitae sagittis lectus diam vitae nulla. Integer nec lorem id elit euismod condimentum.
                    </p>
                    <div class="item-buttons">
                        <button class="item-button-grey">Fiche produit</button>
                        <button class="item-button-green">Ajouter au panier</button>
                    </div>
                    <span class="date-word">Date : </span>
                    <span class="item-date">4 décembre 2022</span>

                </div>
            </article>
            <article class="article-item">
                <div class="item-image">photo</div>
                <div class="item-content">

                    <h1 class="item-title">JBL - Flip 5 Noir</h1>
                    <div class="item-price-delivery">
                        <span class="item-price">188.56€</span>
                        <img src="./assets/truck.png" class="truck">
                        <span class="item-delivery">5.32€</span>
                    </div>
                    <p class="item-description">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut lobortis, neque egestas elementum lobortis, tellus risus molestie nisi, vitae sagittis lectus diam vitae nulla. Integer nec lorem id elit euismod condimentum.
                    </p>
                    <div class="item-buttons">
                        <button class="item-button-grey">Fiche produit</button>
                        <button class="item-button-green">Ajouter au panier</button>
                    </div>
                    <img src="./assets/truck.png" class="truck">
                    <span class="item-delivery">5.32€</span>

                </div>
            </article>

        </section>
    </main>
    <footer>
        <!-- Footer de la page d'accueil -->
    </footer>
</body>
</html>

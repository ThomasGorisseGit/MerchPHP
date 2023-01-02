<?php
session_start();
require "./script/User.php";
if (!isset($_SESSION["email"]) && isset($_COOKIE["email"], $_COOKIE["password"]) && !empty($_COOKIE["email"]) && !empty($_COOKIE["password"])) {
    $user = new User($_COOKIE["name"], $_COOKIE["email"], $_COOKIE["password"]);
    $user->startUserSession();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./styles/main.css">
    <link rel="icon" href="./assets/Logo.png">
    <title>SeinkSansGroove</title>

</head>

<body>
    <?php require_once("./Views/navbarView.php");?>
    <main>
        <!-- Contenu de la page d'accueil yo-->
        <section class="article-list">
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
                    <span class="date-word">Date : </span>
                    <span class="item-date">4 décembre 2022</span>

                </div>
            </article>
            <article class="article-item">
                <div class="item-image">photo</div>
                <div class="item-content">

                    <h1 class="item-title">JBL - Flip 5 Noir</h1>
                    <div class="item-price-delivery">
                        <span class="item-price">17624.56€</span>
                        <img src="./assets/truck.png" class="truck">
                        <span class="item-delivery">500000.32€</span>
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

        </section>
    </main>
    <footer>
        <!-- Footer de la page d'accueil -->
    </footer>
</body>

</html>
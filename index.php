
<?php
/**
require __DIR__ . "/script/Controller/MainController.php";
$controller = new MainController();
*/


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/_navbar.css">
    <link rel="stylesheet" href="./styles/_main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">

    <title>SeinkSansGroove</title>
</head>
<body>
<header>
        <!-- Header de la page d'accueil -->
        <div class="main-title">
            <div class="title">
                <img class="logo" src="/assets/Logo.png" alt="Logo de l'entreprise">
                <h1>SeinkSansGroove</h1>
            </div>
            <div class="search">
                <ul class="searchnav">
                    <a href="#"><li>Marques</li></a>
                    <a href="#"><li>Panier</li></a>
                </ul>
            </div>
            <div class="div-research-bar">
                <form action="#">
                    <input class="research-bar"type="text"
                        placeholder=" Search Courses"
                        name="search">
                    <button>
                        <i class=""
                            style="font-size: 18px;">
                        </i>
                    </button>
                </form>
            </div>
            <div class="user">
                <button class="login">Connexion</button>
                <button class="Sign-in">Inscription</button>
            </div>
        </div>
        <nav>
            <ul>
                <li>Marshall</li>
                <li>JBL</li>
                <li>Bose</li>
            </ul>
        </nav>
    </header>
    <main>
        <!-- Contenu de la page d'accueil -->
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
                        <button class="item-button1">Fiche produit</button>
                        <button class="item-button2">Ajouter au panier</button>
                    </div>
                    <span class="item-date">4 décembre 2022</span>

                </div>
            </article>
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
                        <button class="item-button1">Fiche produit</button>
                        <button class="item-button2">Ajouter au panier</button>
                    </div>
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
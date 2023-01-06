<?php
session_start();
require "./script/User.php";
require "./script/Article.php";

if (!isset($_SESSION["email"]) && isset($_COOKIE["email"], $_COOKIE["password"]) && !empty($_COOKIE["email"]) && !empty($_COOKIE["password"])) {
    $user = new User($_COOKIE["name"], $_COOKIE["email"], $_COOKIE["password"]);
    if(isset($_COOKIE["image"]) && !empty($_COOKIE["image"]))
    {
        $user->setImage($_COOKIE["image"]);
    }
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
    <link rel="icon" href="./assets/Logo.png">
    <link rel="stylesheet" href="./styles/main.css">
    <title>SeinkSansGroove</title>

</head>

<body>
    
    <?php require_once("./Views/navbarView.php");?>
    <main>
        <!-- Contenu de la page d'accueil yo-->
        <section>
            <?php require_once("./Views/ArticleView.php");?>
        </section>
    </main>
    <footer id= "main_footer">
        <!-- Footer de la page d'accueil -->
        <div id="footer_logos_container">
            <img class="logo" src="./assets/Logo.png" alt="Logo de l'entreprise" id="footer_logo">
            <h1 id="footer_title">SeinkSansGroove</h1>
            <div id="contact_us_mail">seinksansgroove@gmail.com</div>
            

        </div>

        <!-- <div id="footer_separator"></div> -->

        <div id="black_container">
            <div id="footer_infos">
                <span id="footer_date">
                    2022 - 2023
                </span>

                <span id="footer_names">
                    Antoine Maïstre-Rice, Léa Jiner, Thomas Gorisse
                </span>
                <span>S3T-G1</span>
            </div>
        </div>
    </footer>
</body>

</html>
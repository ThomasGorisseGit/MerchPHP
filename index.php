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
    <link rel="stylesheet" href="./styles/main.css">
    <link rel="icon" href="./assets/Logo.png">
    <title>SeinkSansGroove</title>

</head>

<body>
    <?php require_once("./Views/navbarView.php");?>
    <main>
        <!-- Contenu de la page d'accueil yo-->
        
        <?php require_once("./Views/ArticleView.php");?>

        </section>
    </main>
    <footer>
        <!-- Footer de la page d'accueil -->
    </footer>
</body>

</html>
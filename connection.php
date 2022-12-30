<?php
session_start();
require "./script/User.php";
require "./script/connexionDatabase.php";

if (isset($_POST["password"])) {
    $user = new User("", htmlspecialchars(trim($_POST["email"])), htmlspecialchars(trim($_POST["password"])));
    if ($user->getUserInfos($db)) {
        $user->startUserSession();
        if (isset($_POST["rememberMe"])) {
            $user->rememberMe();
        }
        header("Location: index.php");
    } else {
        die("error");
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/connexion.css">
    <link rel="stylesheet" href="./styles/navbar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <title>Page de connexion</title>
</head>

<body>
    <header>
        <!-- Header de la page d'accueil -->
        <div class="main-title">
            <img class="logo" src="./assets/Logo.png" alt="Logo de l'entreprise">
            <h1 id="title">SeinkSansGroove</h1>
            <a href="#">Marques</a>
            <a href="#">Panier</a>
            <form action="#" class="form-search">
                <input class="research-bar" type="text" placeholder=" Search Courses" name="search">
                <button id="search-logo">
                    <img src="./assets/search-logo.png" alt="search" width="15px">
                </button>
            </form>
            <div class="user">
                <?php require_once("./connectionView.php"); ?>
            </div>
        </div>
        <nav class="brands-list">
            <button>Marshall</button>
            <button>JBL</button>
            <button>Bose</button>
        </nav>
    </header>
    <main>
        <section class="connexion-main">
            <h2>Connexion</h2>
            <form action="" method="POST">
                <fieldset class="fieldset-form">
                    <label for="adresse-email" class="label-field">Adresse mail</label>
                    <input type="email" name="email" placeholder="jamesbond@gmail.com" required>
                </fieldset>
                <fieldset class="fieldset-form">
                    <label for="mdp" class="label-field">Mot de passe</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                </fieldset>
                <div class="remember">
                    <Label for="rememberMe">Se souvenir de moi</Label>
                    <input type="checkbox" name="rememberMe">
                </div>
                <div class="button-connect-return">
                    <button type="submit" class="item-button-green">Se connecter</button>
                    <button onclick="location.href='index.php'" class="item-button-grey">Retourner à l'accueil</button>
                </div>
            </form>
        </section>
    </main>
</body>

</html>
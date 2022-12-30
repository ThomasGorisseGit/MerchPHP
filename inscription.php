<?php
session_start();
require "./script/connexionDatabase.php";
require "./script/User.php";

function createUser(string $name, string $email, string $password, PDO $db): void
{
    if (checkPassword($password)) {
        $user = new User(htmlspecialchars(trim($name)), htmlspecialchars(trim($email)), htmlspecialchars(trim($password)));
        $user->hashPassword();
        if ($user->addUser($db)) {

            $user->startUserSession();
            if (isset($_POST["rememberMe"])) {
                $user->rememberMe();
            }
            header("Location: ./index.php");
        } else {
            echo "erreur d'insertion";
        }
    } else {
        die("mot de passe trop court");
    }
}
function checkPassword(string $password): bool
{
    if (strlen($password) >= 6) {
        return true;
    }
    return false;
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
    <title>Document</title>
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
            <h2>Inscription</h2>
            <form method="POST" action="">
                <fieldset class="fieldset-form">
                    <label for="nom" class="label-field">Nom</label>
                    <input type="text" placeholder="James" name="name" required>
                </fieldset>
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
                    <button type="submit" class="item-button-green">S'inscrire</button>
                    <button onclick="location.href='index.php'" class="item-button-grey">Retourner à l'accueil</button>
                </div>
            </form>
        </section>
    </main>

</body>

</html>

<?php
if (isset($_POST["submit"])) {
    createUser($_POST["name"], $_POST["email"], $_POST["password"], $db);
}

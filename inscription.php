<?php
session_start();
require "./script/connexionDatabase.php";
require "./script/User.php";

if (isset($_POST["submit"])) {
    createUser($_POST["name"], $_POST["email"], $_POST["password"], $db);
}
function createUser(string $name, string $email, string $password, PDO $db): void
{
    if (checkPassword($password)) {
        $user = new User(htmlspecialchars(trim($name)), htmlspecialchars(trim($email)), htmlspecialchars(trim($password)),"/assets/avatar/default.png");
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
    <?php require_once("./Views/navbarView.php");?>

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
                    <input type="email" name="email" placeholder="jamesratio@gmail.com" required>
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
                    <button type="submit" name="submit" class="item-button-green">S'inscrire</button>
                    <button onclick="location.href='index.php'" class="item-button-grey">Retourner à l'accueil</button>
                </div>
            </form>
        </section>
    </main>

</body>

</html>
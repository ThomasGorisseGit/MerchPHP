<?php
require "../script/connexionDatabase.php";
require "../script/User.php";
$user = new User($_SESSION["name"], $_SESSION["email"], $_SESSION["password"]);
$user->getUserInfos($db);
if (!$user->isAdmin($_SESSION["email"], $db)) {
    header("Location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/Logo.png">
    <link rel="stylesheet" href="../styles/admin_main.css">
    <link rel="stylesheet" href="../styles/admin_menu.css">
    <title>Control pannel</title>
</head>

<body>

    <h1 id="welcome_h1">Bienvenue dans le <br><i>portail administrateur</i><br> <strong><?= $_SESSION["name"] ?></strong></h1>
    <div class="options">
        <a href="./addArticle.php">Ajouter article</a>
        <a href="./addAdministrator.php">Ajouter admin</a>
        <a href="./displayMembers.php">Voir les membres</a>
        <a href="./displayPayment.php">Voir les paiements</a>
    </div>

    <div id="menu_container">
        <a id="menu_button" href="../index.php">Accueil</a>
    </div>
    <div>
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
    </div>

 

</body>

</html>
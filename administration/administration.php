<?php
require "../script/connexionDatabase.php";
require "../script/User.php";
$user = new User($_SESSION["name"],$_SESSION["email"],$_SESSION["password"]);
$user->getUserInfos($db);
if(!$user->isAdmin($_SESSION["email"],$db))
{
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/assets/Logo.png">
    <title>Control pannel</title>
</head>
<body>
    <h1>bienvenu admin</h1>
    <a href="#">Ajouter article</a>
    <a href="./addAdministrator.php">Ajouter admin</a>
    <a href="#">Voir les membres</a>
    <a href="#">Voir les paiements</a>
</body>
</html>
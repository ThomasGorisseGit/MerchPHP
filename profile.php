<?php
session_start();

if(!isset($_SESSION["password"]) or empty($_SESSION["password"]))
{
    header("Location:index.php");
}
if(isset($_POST["disconnect"]))
{
    session_destroy();
    header("Location:index.php");
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile de <?=$_SESSION["name"];?></title>
</head>
<body>
    <main>
        <div class="content">
            <Label>Photo de profile :</Label>
            <img src=<?=$_SESSION["image"]?> width="80px"alt="photo de profile">
            </br> <!-- a supprimer -->
            <Label>Nom :</Label>
            <?= $_SESSION["name"];?>
</br> <!-- a supprimer -->
            <Label>Email :</Label>
            <?= $_SESSION["email"];?>
        </div>
        <button onclick="location.href='index.php' ">Retour a l'accueil</button>
        <button onclick="location.href='editProfile.php' ">Modifier le profile</button>
        <form method="post">
            <button type="submit" name="disconnect">Se deconnecter</button>
        </form>
    </main>
</body>
</html>
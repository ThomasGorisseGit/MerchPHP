<?php
session_start();

if(!isset($_SESSION["password"]) or empty($_SESSION["password"]))
{
    header("Location:index.php");
}
if(isset($_POST["disconnect"]))
{
    session_destroy();
    setcookie("name",null,time() - 3600);
    setcookie("email",null,time() - 3600);
    setcookie("password",null,time() - 3600);
    setcookie("image",null,time() - 3600);
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
    <link rel="stylesheet" href="./styles/profile.css">
</head>
<body>
    <?php require_once("./Views/navbarView.php");?>

    <main>
        <div class="profile_zone">
            
            <img src=<?=$_SESSION["image"]?> width="80px"alt="photo de profile">
            </br> <!-- a supprimer -->
            <Label>Nom : <?= $_SESSION["name"];?></Label>
            
</br> <!-- a supprimer -->
            <Label>Email : <?= $_SESSION["email"];?></Label>
            
        </div>
        <div class="button_zone">
            <button onclick="location.href='index.php' ">Retour a l'accueil</button>
            <button onclick="location.href='editProfile.php' ">Modifier le profil</button>
            <form method="post">
                <button type="submit" name="disconnect">Se deconnecter</button>
            </form> 
        </div>
        

        
    </main>
</body>
</html>
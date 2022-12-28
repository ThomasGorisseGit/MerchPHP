<?php
session_start();
require "./script/User.php";
require "./script/connexionDatabase.php";

if(isset($_POST["password"]))
{
    $user = new User("",htmlspecialchars(trim($_POST["email"])),htmlspecialchars(trim($_POST["password"])));
    if($user->getUserInfos($db))
    {
        $user->startUserSession();
        if(isset($_POST["rememberMe"]))
        {
            $user->rememberMe();
        }
        header("Location: index.php");
    }

    else{
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
    <title>Page de connexion</title>
</head>
<body>
    <form action="" method="POST">
        <input type="email" name="email" placeholder="Entrer votre email" required>
        <input type="password" name="password" placeholder="Entrer votre mot de passe" required>
        <Label for = "rememberMe">Se souvenir de moi</Label>
        <input type="checkbox" name="rememberMe">
        <button type="submit">Se connecter</button>
    </form>
    <button onclick="location.href='index.php'">Retourner à l'accueil</button>
</body>
</html>
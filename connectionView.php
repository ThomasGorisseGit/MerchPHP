<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    if (isset($_SESSION["password"])) {
    ?>
        <h3><?= $_SESSION["name"];?> </h3>        
        <a href="./profile.php">
            <img width="80px" src="<?=$_SESSION['image']?>" alt="PP">
        </a>
        
    <?php
    } else {
    ?>
        <button class="login" onclick="location.href='connection.php'">Connexion</button>
        <button class="Sign-in" onclick="location.href='inscription.php' ">Inscription</button>
    <?php
    }
    ?>
</body>

</html>
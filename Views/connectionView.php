<?php
if(!isset($_SESSION))
{

    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/connexionView.css">
    <title>Document</title>
</head>

<body>
    <?php
    if (isset($_SESSION["password"])) {
    ?>
    <div id="profile_contener">
        <h3 id="user_name"><?= $_SESSION["name"]; ?></h3>
        <a href="./profile.php">
            <img width="80px" src="<?=  $_SESSION["image"] ?>" alt="PP" id="pdp">
        </a> 
    </div>

    <?php
    } else {
    ?>
        <button class="login item-button-green" onclick="location.href='connection.php'">Connexion</button>
        <button class="Sign-in item-button-green" id="greener" onclick="location.href='inscription.php' ">Inscription</button>
    <?php
    }
    ?>
</body>

</html>
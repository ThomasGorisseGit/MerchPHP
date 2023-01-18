<?php

session_start();
require "./script/connexionDatabase.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/panier.css">
    <title>Succès</title>
</head>

<body>
    <?php require_once("./Views/navbarView.php");?>

    <main>

        <div class="successFail">
            <h1>Merci pour votre commande !</h1>
            <p class="thankyou">L'équipe de SeinkSansGroove vous remercie de nous avoir fait confiance et d'avoir
                réalisé vos achats d'enceintes bluetooth avec notre boutique en ligne.</p>
            <p class="thankyou">Vous recevrez votre commande 15 jours après la date de votre commande.</p>
            <p class="attention">En raison de grèves, votre commande peut être retardée d'un délai maximal de 96 heures,
                soit 4 jours. <br>Nous vous remercions de votre patience.</p>
            <p class="thankyou">Si vous avez des questions, n'hésitez pas à contacter notre support à l'adresse 
                <a href="mailto:seinksansgroove@gmail.com">seinksansgroove@gmail.com</a>.</p>
            <a href="./index.php">Retourner à l'accueil</a>
        </div>
    </main>
    <?php require_once("./Views/footerView.html");?>
</body>

</html>
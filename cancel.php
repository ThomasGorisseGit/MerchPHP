<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/panier.css">
    <title>Echec</title>
</head>

<body>
    <?php require_once("./Views/navbarView.php");?>
    <main>

        <div class="successFail">
            <h1>Un problème est servenu lors de votre commande</h1>
            <p class="thankyou">L'équipe de SeinkSansGroove a le regret de vous annoncer l'échec de votre commande.</p>
            <p class="thankyou">Merci de repasser commande afin de surmonter ce problème.</p>
            <p class="thankyou">Si vous avez des questions, n'hésitez pas à contacter notre support à l'adresse 
                <a href="mailto:seinksansgroove@gmail.com">seinksansgroove@gmail.com</a>.</p>
            <a href="./index.php">Retourner à l'accueil</a>
        </div>
    </main>

    <?php require_once("./Views/footerView.html");?>
</body>

</html>
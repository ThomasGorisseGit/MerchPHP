<?php

session_start();
require "./script/connexionDatabase.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$q="SELECT * FROM Panier INNER JOIN Facture ON Facture.id = Panier.idFacture INNER JOIN User ON User.id = Facture.idUser WHERE User.email = ? AND alreadyPaid=false ";
$stmt=$db->prepare($q);
$stmt->execute(array($_SESSION["email"]));
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
function content(array $data) : string
{
    $html= '
    <!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        


    *{
        font-family:  \'Inter\', sans-serif;
    }
    
    body{
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    section {

        margin-top: 150px;
        background-color: #35373B;
        height: 300px;
        padding-top: 20px;
        
        width: 50%;
        border-radius: 5px;
        height: auto;
    }
    
    #main_mail > * {
        color: #bfbfbf;
    }
    
    
    #mail_logos_container {
        margin : 0 auto;
        display: flex;
        justify-content: center;
        flex-direction: row;
        align-items: center;
    
        gap: 60px;
        width: 90%;
    
        margin-bottom: 20px;
    }
    
    
    .mail_title {
        color: white;
        font-size: 1.2rem;
        font-style: oblique;
        user-select: none;
        cursor:auto;
    }
    
    
    #mail_description{
        height: fit-content;
        background-color: #868686;
        color: #f4f4f4;
        padding: 75px;
        padding-bottom: 20px;
    }
    
    #mail_description>div>div{
        font-size: 200%;
        margin-bottom: 7px;
    }
    
    #mail_description > div:nth-child(1) {
        margin-bottom: 50px;
    }
    
    #details_commande{
        margin-bottom: 50px;
    }
    
    #details_commande ul{
        background-color: #1D1F20;
        padding: 20px;
        padding-left: 41px;
        width: fit-content;
        border-radius: 29px;
        margin-bottom: 20px;
    }
    
    #details_commande ul #recap_text{
        max-width: 75%;
        margin-bottom: 20px;
    }
    
    #total_text{
        max-width: 75%;
        margin-top: 20px;
    }
    
    
    
    #mail_infos {
        display: flex;
        justify-content: space-between;
        align-items: center;
        /* gap: 400px; */
        height: 90px;
        width: 90%;
        margin: 0 auto;
        
    }
    
    #mail_infos>*{
        color: #bfbfbf;
    }
    
    #mail_names {
        font-style: italic;
        position: relative;
        right: 20px;
    }
    
    #contact_us_mail {
        margin-top: 20px;
    }
    
    
    
    #mail_logo:hover {
        cursor: auto;
        
    }
    
    
    .logo {
        width: 50px;
        height: 50px;
    }
    
    .logo:hover {
        cursor: pointer;
    }
    
    span>.mail_title{
        display: inline;
    }
    
    
    #black_container {
        margin-top: 50px;
        background-color: #1D1F20;
        /* align-self: flex-end;  */
        margin-top: auto;    
        display: flex;
        justify-content: center;
        flex-direction: column;    
        height: fit-content; 
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
    
    }
    
    #details_commande ul li span{
        display: inline-block;
        min-width: 75px;
    }
    
    
    
    #contact_us{
        margin-top: 20px;
        margin-left: 20px;
        margin-bottom: 20px;
    }
    
    #contact_us #contact_label{
        margin-bottom: 20px;
    }
    
    #contact_us li{
        margin-top: 8px;
        margin-bottom: 8px;
    }
    
    #thanks_text>h1{
        display: inline;
    }
    
    #thanks_text{
        margin-bottom: 20px;
    }
    </style>
    <title>sucess</title>
</head>
';
$html .= '
<body>
    <section id="main_mail">
        <div id="mail_logos_container">
            <h1 class="mail_title">SeinkSansGroove</h1>
            <!-- <div id="contact_us_mail">
                <span>seinksansgroove@gmail.com</span>
            </div> -->
        </div>
        <div id="mail_description">
            <div>
                <div>Bonjour, <strong>'.$_SESSION["email"].'</strong> !</div><br>
                L\'équipe <i>SeinkSansGroove</i> vous informe que votre commande a bien été prise en compte.
            </div>
            <div id="thanks_text">Merci d\'avoir passé une commande chez <h1 class="mail_title">SeinkSansGroove</h1>, nous espérons vous revoir très vite !</div>
        </div>
        <!-- <div id="mail_separator"></div> -->

        <div id="black_container">
            <div id="contact_us">
                <ul>
                    <div id="contact_label">Nous contacter</div>
                    <li>
                        07 82 61 30 11 
                    </li>
                    <li>
                        mailgun@seinksansgroove.studio
                    </li>
                </ul>
            </div>
        </div>
    </section>
</body>

</html>
    ';
    return $html;
}
$mail = $_SESSION["email"];
$phpmailerContent = content($data);

function postCurl($url, $data, $mailgunApi)
{
 
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_USERPWD,$mailgunApi);
    $o = curl_exec($ch);
    curl_close($ch);
    return $o;
}
require_once("./mailgun.php");
postCurl("https://api.eu.mailgun.net/v3/seinksansgroove.studio/messages",
    array(
        'from' => '512Admin mailgun@seinksansgroove.studio',
        'to' => $mail,
        'subject' => 'Confirmation de paiement',
        'html' => $phpmailerContent
    ),
    $MAIL_GUN_API_KEY
);





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
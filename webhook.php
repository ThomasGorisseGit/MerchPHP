<?php
session_start();
require 'vendor/autoload.php';
require "script/connexionDatabase.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// This is your Stripe CLI webhook secret for testing your endpoint locally.
$endpoint_secret = 'whsec_jngCXkgPAhAqIJRImGv6uuN1C3cYG9f1';

$payload = @file_get_contents('php://input');
$event = json_decode($payload);

$q="SELECT * FROM Panier INNER JOIN Facture ON Facture.id = Panier.idFacture INNER JOIN User ON User.id = Facture.idUser WHERE User.email = ? AND alreadyPaid=false ";
$stmt=$db->prepare($q);
$stmt->execute(array($_SESSION["email"]));
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
function content(array $data) : string
{
    foreach($data as $article)
    {
        //  ici tu as pour chaque article.

        //exemple $article["nom"];
        print_r($article);
    }


    $html="";
    $html.='<h1>Paiement accepté</h1>';
    $html.='<p>Merci d\'avoir passé commande chez nous, en éspérant vous revoir très vite !</p>';
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


$session = $event->data->object;
$q = "SELECT Facture.id,User.id FROM Facture INNER JOIN User ON User.id = Facture.idUser WHERE User.email = ? AND alreadyPaid=false";
$stmt = $db->prepare($q);
$stmt->execute(array($session->metadata->client_email));
$data = $stmt->fetch();


// print_r($session);

$idFacture = $data[0];
$idUser = $data[1];
echo $idFacture;
$total =  $session->amount_total/100;
$tva =  $session->amount_subtotal * 20 /10000;
$shipping = $session->shipping_cost->amount_total/100;

$q = "INSERT INTO Billing(idFacture,prixTotal,prixTVA,prixLivraison) VALUES(?,?,?,?)";
$stmt=$db->prepare($q);
$stmt->execute(array(
    $idFacture,
    $total,
    $tva,
    $shipping
));


$q="UPDATE Facture SET alreadyPaid = True WHERE idUser = ? ";
$stmt = $db->prepare($q);
$stmt->execute(array($idUser));


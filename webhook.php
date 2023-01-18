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


$session = $event->data->object;
$q = "SELECT Panier.id FROM Panier INNER JOIN Article ON Panier.idArticle = Article.id INNER JOIN User ON User.id = Panier.idUser WHERE User.email = ?";
$stmt = $db->prepare($q);
$stmt->execute(array($session->metadata->client_email));
$data = $stmt->fetch(PDO::FETCH_ASSOC);


// print_r($session);
echo $session->amount_total;

$idPanier = $data["id"];
$total =  $session->amount_total/100;
$tva =  $session->amount_subtotal/100 * 20;
$shipping = $session->shipping_cost->amount_total/100;

$q = "INSERT INTO Billing(idPanier,prixTotal,prixTVA,prixLivraison) VALUES(?,?,?,?)";
$stmt=$db->prepare($q);
$stmt->execute(array(
    $idPanier,
    $total,
    $tva,
    $shipping
));



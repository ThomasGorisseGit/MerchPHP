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


<?php
require "./script/connexionDatabase.php";
if(isset($_POST["paiement"]))
{
  $q = "SELECT * FROM Panier 
  INNER JOIN Article 
  ON Panier.idArticle = Article.id
  WHERE idUser = ? ";
  $stmt = $db->prepare($q);
  $stmt->execute(array($_POST["paiement"]));
  $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
  print_r($data);
}

require 'vendor/stripe/stripe-php/init.php';
// This is your test secret API key.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
\Stripe\Stripe::setApiKey('sk_test_51MNIkBFTmLjCi6CPKgR6PYl7C0mHB1YCUSj4SVMui30AY2IlrwZ4N1afdnBuwyGdMRxWU8QiIwgt6mqdPGHXY2wa00G64xgEvG');
header('Content-Type: application/json');
$YOUR_DOMAIN = 'http://seinksansgroove.studio';
$item = array();
$livraison=0;
$stripe = new \Stripe\StripeClient('sk_test_51MNIkBFTmLjCi6CPKgR6PYl7C0mHB1YCUSj4SVMui30AY2IlrwZ4N1afdnBuwyGdMRxWU8QiIwgt6mqdPGHXY2wa00G64xgEvG');
$stripe->taxRates->create(
  [
    'display_name' => 'TVA',
    'inclusive' => false,
    'percentage' => 20,
    'country' => 'FR',
    'description' => 'French TVA',
  ]
);
$emailClient = $_POST['email'];

foreach($data as $row)
{
  $items[] = array(
    'price_data'=>array(
      'currency'=>'eur',
      'tax_behavior'=>'exclusive',
      'product_data'=>array(
        'name'=> $row["nom"],
      ),
  
      'unit_amount'=>$row["prix"] * 100
    ),
    'quantity'=>$row["quantity"],
    'tax_rates' => ['txr_1MNiL0FTmLjCi6CPYhx2Hsfc'],
  );
  $livraison += $row["prixLivraison"];
}
$checkout_session = \Stripe\Checkout\Session::create([
  'line_items' => $items,
  'metadata' => [
    'client_email'=> $emailClient
  ],
  'shipping_options' => [
    [
      'shipping_rate_data' => [
        'type' => 'fixed_amount',
        'fixed_amount' => ['amount' => $livraison*100, 'currency' => 'eur'],
        'display_name' => 'Frais de livraisons',
        'delivery_estimate' => [
          'minimum' => ['unit' => 'business_day', 'value' => 5],
          'maximum' => ['unit' => 'business_day', 'value' => 7],
        ],
      ],
    ],
  ],

  'mode' => 'payment',
  'success_url' => $YOUR_DOMAIN . '/success.php',
  'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
  
  
]);
// header("HTTP/1.1 303 See Other");
header("Location: " . $checkout_session->url);

?>

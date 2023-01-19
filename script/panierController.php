<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "./connexionDatabase.php";
require "./Panier2.php";

$panier = new Panier2($db);
if(isset($_POST["ajouterPanier"]))
{
    $panier->addArticle($_POST["ajouterPanier"]);
    $data = $panier->getPanier();

    $total = 0;

    foreach($data as $article)
    {
        
        $total += $article["quantity"];
    }
    echo $total;
}

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require "Article.php";
require "Panier.php";
require "User.php";
require "connexionDatabase.php";


$q = "SELECT * FROM Panier INNER JOIN Article ON Article.id = Panier.idArticle
WHERE idUser = ?
";
$stmt = $db->prepare($q);
$stmt->execute(array(getUserID($db)));
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

if(isset($_POST["id"]))
{
    $type = $_POST["type"];
    $id = $_POST["id"];
    foreach($data as $article)
    {
    
    $qte = $article["quantity"];
    if($article["idArticle"] == $id)
    {
        if($type == 1 )
        {
            if($qte>1)
            {
                $qte--;
                
            }
            else{
                $qte = 1;
            }
            echo $qte;
        }
        else{
            $qte++;
            echo $qte;

        }
    }
    $q = "UPDATE Panier SET quantity = ? WHERE idUser = ? AND idArticle = ? ";
    $stmt = $db->prepare($q);
    $stmt->execute(array($qte,getUserID($db),$article["id"]));
    }

}

function getUserID(PDO $db) :int
{
    $q = "SELECT id FROM User WHERE email = ?";
    $stmt = $db->prepare($q);
    $stmt->execute(array($_SESSION["email"]));
    $id = $stmt->fetch();
    return $id["id"];
}

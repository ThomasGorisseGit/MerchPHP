<?php
session_start();
require "Panier.php";
require "connexionDatabase.php";
require "Article.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
echo"a";
if(isset($_SESSION["email"])&& !empty($_SESSION["email"]))
{
    $panier = new Panier();
    if(isset($_POST["ajouterPanier"]))
    {
        $dataPanier = getArticleFromDatabase(htmlspecialchars(trim($_POST["ajouterPanier"])),$db);
        if(!$dataPanier){
            die("Cet Article n'existe plus");
        }
        $userID = getUserID($db);
        $article = new Article(
            $dataPanier["id"],
            $dataPanier["nom"],
            $dataPanier["prix"],
            $dataPanier["prixLivraison"],
            $dataPanier["description"],
            $dataPanier["dateVente"],
            $dataPanier["imageProduit"]
        );
        addArticleInPanier($userID,$panier,$article,$db);
        
    }
    header("Location:../index.php");
}
else
{
    echo "Veuillez vous connecter. </br>";
    echo '<a href="./index.php">Retourner vers l\'accueil</a>';
}
function getArticleFromDatabase(string $name, PDO $db) : array
{
    $q = "SELECT * FROM Article WHERE nom = ?";
    $stmt = $db->prepare($q);
    if($stmt->execute(array($name)))
    {
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data;
    }
    return false;

}    
function getUserID(PDO $db)
{
    $q = "SELECT id FROM User WHERE email = ?";
    $stmt = $db->prepare($q);
    $stmt->execute(array($_SESSION["email"]));
    $id = $stmt->fetch();
    return $id["id"];
}
function addArticleInPanier(int $userID,Panier $panier,Article $article, PDO $db)
{
    $q = "INSERT INTO Panier(idArticle,idUser) VALUES (?,?)";
    $stmt = $db->prepare($q);
    if($stmt->execute(array($article->getID(),$userID)))
    {
        $panier->addArticle($article);
    }
    else{
        echo " une erreure est survenue";
    }
}
?>

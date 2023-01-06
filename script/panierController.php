<?php
session_start();
require "Panier.php";
require "connexionDatabase.php";
require "Article.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(isset($_SESSION["email"])&& !empty($_SESSION["email"]))
{
    $panier = new Panier();
    $data = $panier->getUserPanier(getUserID($db),$db);
    print_r($data);
    for($i=0;$i<sizeof($data);$i++)
    {
        
        $panier->fillPanierOfArticle($data[$i]["idArticle"],$db);
    }
    if(isset($_POST["ajouterPanier"]))
    {
        $article = selectArticleByName($_POST["ajouterPanier"],$db);
        addArticle($article,getUserID($db), $panier,$db);
        
    }
    header('Location: ../index.php');
}
else
{
    echo "Veuillez vous connecter. </br>";
    echo '<a href="../index.php">Retourner vers l\'accueil</a>';
}


function getUserID(PDO $db)
{
    $q = "SELECT id FROM User WHERE email = ?";
    $stmt = $db->prepare($q);
    $stmt->execute(array($_SESSION["email"]));
    $id = $stmt->fetch();
    return $id["id"];
}
function selectArticleByName(string $name, PDO $db)
{
    $q = "SELECT * FROM Article WHERE nom = ?";
    $stmt = $db->prepare($q);
    $stmt->execute(array($name));
    $data = $stmt->fetch(PDO::FETCH_ASSOC);    
    return new Article(
        $data["id"],
        $data["nom"],
        $data["prix"],
        $data["prixLivraison"],
        $data["description"],
        $data["dateVente"],
        $data["imageProduit"]
    );
    
}
function addArticle(Article $article,int $userID, Panier $panier, PDO $db)
{
    $qte = $panier->getNumberOfArticle($article,$db,$userID);
    echo "</br>" . $qte . "</br>";
    if($qte > 0)
    {
        $q = "UPDATE Panier SET quantity = ? WHERE idUser = ? AND idArticle = ? ";
        $stmt = $db->prepare($q);
        $stmt->execute(array($qte+1,$userID,$article->getID()));
        echo "done1";

    }
    else{
        $q = "INSERT INTO Panier(idUser,idArticle,quantity)VALUES(?,?,?)";
        $stmt = $db->prepare($q);
        $stmt->execute(array($userID,$article->getID(),1));
        echo "done2";
    }
    $panier->addArticle($article);
}
?>

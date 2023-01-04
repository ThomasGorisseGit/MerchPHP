<?php
session_start();
require "script/Panier.php";
require "script/Article.php";

require "script/connexionDatabase.php";
if(isset($_SESSION["email"]) && !empty($_SESSION["email"]))
{
    
    $data = getArticleOfPanier(getUserID($db),$db);
    $articles = array();
    foreach($data as $articleid)
    {
        $q = "SELECT * FROM Article WHERE id = ?";
        $stmt = $db->prepare($q);
        $stmt->execute(array($articleid["idArticle"]));
        $dataArt = $stmt->fetch(PDO::FETCH_ASSOC);
        $art = new Article($dataArt["id"],$dataArt["nom"],$dataArt["prix"],$dataArt["prixLivraison"],$dataArt["description"],$dataArt["dateVente"],$dataArt["imageProduit"]);
        array_push($articles,$art);
    }
    $panier = fillPanier($articles);
    print_r($panier->getPanier());
    displayPanier($articles,$panier);
    
    if(isset($_POST["minus"]))
    {
        for($i=0;$i<count($articles);$i++)
        {
            if($articles[$i]->getName()==$_POST["minus"])
            {
                $panier->deleteQTEArticle($articles[$i]);
            }
        }
    }
}

function fillPanier(array $articles)
{
    $articleName = array();
    foreach($articles as $art)
    {
        array_push($articleName,$art->getName());
    }
    return new Panier($articles,$articleName);
}

function getUserID(PDO $db) : int
{
    $q = "SELECT id FROM User WHERE email = ?";
    $stmt = $db->prepare($q);
    $stmt->execute(array($_SESSION["email"]));
    $id = $stmt->fetch();
    return $id["id"];
}
function getArticleOfPanier(int $userID,PDO $db) : array
{
    $q = "SELECT * FROM Panier WHERE idUser = ?";
    $stmt = $db->prepare($q);
    $stmt->execute(array($userID));
    return $stmt->fetchAll();
}
function displayPanier(array $articles,Panier $panier)
{
    
    foreach ($articles as $article)
    {
        ?>
        <article>
        <img src=<?=$article->getImage()?> alt="">
        <p><b><?= $article->getName()?></b></p>
        <p><?=$article->getDescription()?></p>
        <button type="submit" name="plus" value=<?=$article->getName()?>>-</button>
        <p>Quantité :</p>
        <button type="submit" name="plus" value=<?=$article->getName()?>>+</button>
        <p>Prix : 100€</p>
        </article>
        <?php
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./assets/Logo.png">
    <title>Votre panier</title>
</head>
<body>
    <form action="" method="POST">
        


    </form>
</body>
</html>
<?php
require "script/Article.php";
require "script/Panier.php";
require "script/User.php";
require "script/connexionDatabase.php";

if(isset($_SESSION["email"]) && !empty($_SESSION["email"]))
{
    $panier = new Panier();
    $data = $panier->getUserPanier(getUserID($db),$db);
    for($i=0;$i<sizeof($data);$i++)
    {
        $panier->fillPanierOfArticle($data[$i]["idArticle"],$db);
    }
    if(sizeof($panier->getPanier()) == 0)
    {
        echo "votre panier est vide </br>";
        echo '<a href="./index.php">Retour vers l\'accueil</a>';
    }
    if(isset($_POST["minus"]) && !empty($_POST["minus"]))
    {
        $name = htmlentities(trim($_POST["minus"]));
        $article = selectArticleByName($name,$db);
        $qte = $panier->getNumberOfArticle($article,$db,getUserID($db));
        if($qte>1)
        {
            $q = "UPDATE Panier SET quantity = ? WHERE idUser = ? AND idArticle = ? ";
            $stmt = $db->prepare($q);
            $stmt->execute(array($qte-1,getUserID($db),$article->getID()));
        }
    }
    if(isset($_POST["plus"]) && !empty($_POST["plus"]))
    {
        $name = htmlentities(trim($_POST["plus"]));
        $article = selectArticleByName($name,$db);
        $qte = $panier->getNumberOfArticle($article,$db,getUserID($db));
        $q = "UPDATE Panier SET quantity = ? WHERE idUser = ? AND idArticle = ? ";
        $stmt = $db->prepare($q);
        $stmt->execute(array($qte+1,getUserID($db),$article->getID())); 
    }
    if(isset($_POST["delete"]) && !empty($_POST["delete"]))
    {
        $name = htmlentities(trim($_POST["delete"]));
        $article = selectArticleByName($name,$db);
        $qte = $panier->getNumberOfArticle($article,$db,getUserID($db));
        $q = "DELETE FROM Panier WHERE idUser = ? AND idArticle = ?";
        $stmt = $db->prepare($q);
        $stmt->execute(array(getUserID($db),$article->getID())); 
        header('Refresh:0');
    }
}
else{
    header('Location: ./connection.php');
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
function getprice(PDO $db) :float
{
    $panier = new Panier();
    $data = $panier->getUserPanier(getUserID($db),$db);
    $total = 0;
    for($i=0;$i<sizeof($data);$i++)
    {
        $panier->fillPanierOfArticle($data[$i]["idArticle"],$db);
        
        
    }
    
    for($i=0;$i<sizeof($panier->getPanier());$i++)
    {
        $total+=$panier->getPanier()[$i]->getPrice() * $data[$i]["quantity"];
    } 
    return $total;
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./assets/Logo.png">
    <link rel="stylesheet" href="./styles/panier.css">
    <title>Mon panier</title>
</head>
<body>
    <main>
        <?= $panier->displayPanier($db,getUserID($db))?>
        <?= getprice($db)?>
    </main>
</body>
</html>

<?php
/* Fonctionnel : 

$panier = new Panier();
$article1 = new Article(1,"a",12,1,'je','12','z');
$article2 = new Article(2,"b",12,1,'je','12','z');
$article3 = new Article(3,"a",12,1,'je','12','z');


$panier->addArticle($article1);
$panier->addArticle($article2);
$panier->addArticle($article3);


print_r($panier->getPanier());
echo "</br>";
$panier->removeArticle($article1);
print_r($panier->getPanier());
*/

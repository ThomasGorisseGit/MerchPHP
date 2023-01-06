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
    print_r($panier->getPanier());
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
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./assets/Logo.png">
    <title>Mon panier</title>
</head>
<body>
    
</body>
</html>
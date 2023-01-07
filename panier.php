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
    
    if(isset($_POST["delete"]) && !empty($_POST["delete"]))
    {
        $id = htmlentities(trim($_POST["delete"]));
        $article = selectArticleByName($id,$db);
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
function selectArticleByName(int $id, PDO $db) : Article
{
    
    $q = "SELECT * FROM Article WHERE id = ?";
    $stmt = $db->prepare($q);
    $stmt->execute(array($id));
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
<body >
    <main>
        <?= $panier->displayPanier($db,getUserID($db))?>
        <?=$panier->displayTotalPrice(getprice($db),getUserID($db))?>
    </main>

</body>



<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<!-- DESACTIVER LE RECHARGEMENT DE LA PAGE -->
<script>

    let plus_buttons = document.getElementsByClassName("plus_button");
    let minus_buttons = document.getElementsByClassName("minus_button");
    let buttons_zone = document.getElementsByClassName("qte");
    

/*
    for (let i = 0; i < buttons_zone.length; i++) {
        // pour tous les boutons "+", on envoie au server l'evenement d'incrementation
        buttons_zone[i].children[0].addEventListener("click", function(event) {
            refreshData(0, i);
        });

        // pour tous les boutons "-", on envoie au server l'evenement de decrementation
        buttons_zone[i].children[2].addEventListener("click", function(event) {
            refreshData(1, i);
        });
    }
*/
    /*
    for (let button of plus_buttons) {
        button.addEventListener("click", function(event) {
            updateArticle(0);
        });
    }
    
    for (let button of minus_buttons) {
        button.addEventListener("click", function(event) {
            updateArticle(1);
        });
    }
    */


    // 0 pour incrementer ; 1 pour decrementer ; 2 pour supprimer
    function refreshData(id,type){
      var display = document.getElementById(id);
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.open("POST", "./script/refreshData.php");
      xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xmlhttp.send("id="+encodeURI(id)+"&type="+type);
      xmlhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
          display.innerHTML = this.responseText;
        } else {
          display.innerHTML = "Loading...";
        };
      }
    }
    

   

    
</script>

</html>

<?php

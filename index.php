<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
session_start();
require "./script/User.php";
require "./script/Article.php";
require "./script/connexionDatabase.php";

if (!isset($_SESSION["email"]) && isset($_COOKIE["email"], $_COOKIE["password"]) && !empty($_COOKIE["email"]) && !empty($_COOKIE["password"])) {
    $user = new User($_COOKIE["name"], $_COOKIE["email"], $_COOKIE["password"]);
    
    
    if(isset($_COOKIE["image"]) && !empty($_COOKIE["image"]))
    {
        $user->setImage($_COOKIE["image"]);
    }
    $user->startUserSession();

}
$qte = 0;
if(isset($_SESSION["email"]) && !empty($_SESSION["email"]))
{
    // $q = "SELECT * FROM User INNER JOIN Panier ON User.id = Panier.idUser Where email = ? ";
    $q="SELECT * FROM Panier INNER JOIN User ON User.id=Panier.idUser INNER JOIN Facture ON Panier.idFacture=Facture.id WHERE User.email=? AND Facture.alreadyPaid=False ";
    $stmt = $db->prepare($q);
    $stmt->execute(array($_SESSION["email"]));
    $data = $stmt->fetchAll();
    
    foreach($data as $art)
    {
        $qte += $art["quantity"];
    }


    $user = new User($_SESSION["name"],$_SESSION["email"],$_SESSION["password"]);
    $user->getUserInfos($db);
    
}
function displayAdmin() : string
{
    return '<a href="administration/administration.php">Administration</a>';
}


function displayFilter(string $search,PDO $db)
{
    $query = "SELECT * FROM Article WHERE nom LIKE '%".$search."%'";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(count($data)>0){
        for($i=0;$i<count($data);$i++)
        {
            $id = $data[$i]["id"];
            $name = $data[$i]["nom"];
            $price = $data[$i]["prix"];
            $delivery = $data[$i]["prixLivraison"];
            $description = $data[$i]["description"];
            $date = $data[$i]["dateVente"];
            $image = $data[$i]["imageProduit"];
            $art = new Article($id,$name,$price,$delivery,$description,$date,$image);
            echo $art->displayArticle();
        }
    }
    else{
        echo "Il n'y a aucun article correspondant à votre recherche";
    }
    
}

    


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <link rel="icon" href="./assets/Logo.png">
    <link rel="stylesheet" href="./styles/main.css">
    <link rel="stylesheet" href="./styles/navbar.css">
    <title>SeinkSansGroove</title>

</head>

<body>
    
<header>
    <?php
    
    ?>
        <!-- Header de la page d'accueil -->
        <nav id="nav">
            
            <label for="toggle" class="label-hamburger">☰</label>
            <input type="checkbox" id="toggle">
            <div class="main-title">
                <img onclick="location.href='index.php'" class="logo" src="./assets/Logo.png" alt="Logo de l'entreprise">
                <h1 onclick="location.href='index.php'" id="title">SeinkSansGroove</h1>
                <a class="page_link" href="index.php">Produits</a>
                <?php
                if(is_object($user))
                {
                    if($user->isAdmin($_SESSION["email"],$db))
                    {
                       echo displayAdmin();
                    }
                }
                
                
                ?>
                <a class="page_link" id="panier" href="panier.php">Panier</a>
                <div id= "notification"><span id="echoqte"><?=$qte?></span></div>
                
                <?php
                    if(isset($_POST["a"]))
                    {
                        echo "in";
                    }
                ?>
                <form action="" method="POST" class="form-search">
                    <input class="research-bar" type="text" placeholder="Chercher une enceinte" name="search" id="navbar_searchbar">
                    <button type="submit" id="search_button">
                        <img src="./assets/search-logo.png" alt="search" width="15px">
                    </button>
                </form>
                <div class="user">
                    <?php 
                    
                    require_once("./Views/connectionView.php"); ?>
                </div>
            </div>
        </nav>
        <nav class="brands-list">
            <form action="./index.php" method="POST">
                <button name="submit" value="Marshall">Marshall</button>
                <button name="submit" value="JBL">JBL</button>
                <button name="submit" value="Bose">Bose</button>
            </form>
        </nav>
    </header>
    <main id="article_zone">
        <!-- Contenu de la page d'accueil yo-->
        <section>
            <?php 
            
            if(isset($_POST["submit"]))
            {
                
                displayFilter($_POST["submit"],$db);
            }
            elseif(isset($_POST["search"]))
            {
                displayFilter($_POST["search"],$db);
            }
            else{
                require_once("./Views/ArticleView.php");
            }
            ?>
        </section>
    </main>
    <?php require_once("Views/footerView.html")?>
</body>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script>
        function addArticleToPanier(name) {
            if (!<?= isset($_SESSION['email'])?'true':'false';?>) {
                location.href = 'connection.php';
             } 
            else {
                var display = document.getElementById("echoqte");
                var div = document.getElementById("notification");
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("POST", "./script/panierController.php");
                xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xmlhttp.send("ajouterPanier="+name);
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState === 4 && this.status === 200) {
                        display.innerText = this.responseText;
                        div.style.visibility = "visible";
                    } 
                }
            }
        }
    </script>

    
</html>
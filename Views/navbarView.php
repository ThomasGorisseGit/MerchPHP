<?php

include("script/connexionDatabase.php");
$qte = 0;
if(isset($_SESSION["email"]) && !empty($_SESSION["email"]))
{
    $q = "SELECT * FROM User INNER JOIN Panier ON User.id = Panier.idUser Where email = ? ";
    $stmt = $db->prepare($q);
    $stmt->execute(array($_SESSION["email"]));
    $data = $stmt->fetchAll();
    
    foreach($data as $art)
    {
        $qte += $art["quantity"];
    }
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/navbar.css">
    <link rel="stylesheet" href="./styles/main.css">
    <title>Document</title>
</head>

<body>
    <header>
        <!-- Header de la page d'accueil -->

        <nav id="nav">
            <label for="toggle" class="label-hamburger">☰</label>
            <input type="checkbox" id="toggle">
            <div class="main-title">
                <img onclick="location.href='index.php'" class="logo" src="./assets/Logo.png" alt="Logo de l'entreprise">
                <h1 onclick="location.href='index.php'" id="title">SeinkSansGroove</h1>
                <a class="page_link" href="#">Marques</a>
                <a class="page_link" id="panier" href="panier.php">Panier</a>
                <div id= "notification"><span id="echoqte"><?=$qte?></span></div>
                <form action="#" class="form-search">
                    <input class="research-bar" type="text" placeholder="Chercher une enceinte" name="search" id="navbar_searchbar">
                    <button id="search_button">
                        <img src="./assets/search-logo.png" alt="search" width="15px">
                    </button>
                </form>
                <div class="user">
                    <?php require_once("./Views/connectionView.php"); ?>
                </div>
            </div>
        </nav>
        <nav class="brands-list">
            <button>Marshall</button>
            <button>JBL</button>
            <button>Bose</button>
        </nav>
    </header>
</body>

</html>
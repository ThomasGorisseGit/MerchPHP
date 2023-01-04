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
    <header >
        <!-- Header de la page d'accueil -->
        <div class="main-title" >
            <img onclick="location.href='index.php'" class="logo" src="./assets/Logo.png" alt="Logo de l'entreprise">
            <h1 onclick="location.href='index.php'" id="title">SeinkSansGroove</h1>
            <a href="#">Marques</a>
            <a href="panier.php">Panier</a>
            <form action="#" class="form-search">
                <input class="research-bar" type="text" placeholder="Chercher une enceinte" name="search">
                <button id="search-logo">
                    <img src="./assets/search-logo.png" alt="search" width="15px">
                </button>
            </form>
            <div class="user">
                <?php require_once("./Views/connectionView.php"); ?>
            </div>
        </div>
        <nav class="brands-list">
            <button>Marshall</button>
            <button>JBL</button>
            <button>Bose</button>
        </nav>
    </header>
</body>
</html>
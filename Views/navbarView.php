
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
                <!-- <a class="page_link" href="#">Marques</a> -->
                <a class="page_link" href="index.php">Produits</a>
                <a class="page_link" id="panier" href="panier.php">Panier</a>
                <form action="index.php" method="POST" class="form-search">
                    <input class="research-bar" type="text" placeholder="Chercher une enceinte" name="search" id="navbar_searchbar">
                    <button type="submit" id="search_button">
                        <img src="./assets/search-logo.png" alt="search" width="15px">
                    </button>
                </form>
                <div class="user">
                    <?php require_once("./Views/connectionView.php"); ?>
                </div>
            </div>
        </nav>
        <nav class="brands-list">
            <form action="index.php" method="POST">
                <button name="submit" value="Marshall">Marshall</button>
                <button name="submit" value="JBL">JBL</button>
                <button name="submit" value="Bose">Bose</button>
            </form>
        </nav>
    </header>
</body>

</html>
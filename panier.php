<?php
require "script/Article.php";
require "script/Panier.php";
require "script/User.php";
require "script/connexionDatabase.php";

if (isset($_SESSION["email"]) && !empty($_SESSION["email"])) {

    $panier = new Panier();
    $data = $panier->getUserPanier(getUserID($db), $db);
    for ($i = 0; $i < sizeof($data); $i++) {
        $panier->fillPanierOfArticle($data[$i]["idArticle"], $db);
    }
    if (sizeof($panier->getPanier()) == 0) {
        echo "votre panier est vide </br>";
        echo '<a href="./index.php">Retour vers l\'accueil</a>';
    }

    if (isset($_POST["delete"]) && !empty($_POST["delete"])) {
        $id = htmlentities(trim($_POST["delete"]));
        $article = selectArticleByName($id, $db);
        $qte = $panier->getNumberOfArticle($article, $db, getUserID($db));
        $q = "DELETE FROM Panier WHERE idUser = ? AND idArticle = ?";
        $stmt = $db->prepare($q);
        $stmt->execute(array(getUserID($db), $article->getID()));
        header('Refresh:0');
    }
} else {
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
function selectArticleByName(int $id, PDO $db): Article
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
function getprice(PDO $db): float
{
    $panier = new Panier();
    $data = $panier->getUserPanier(getUserID($db), $db);
    $total = 0;
    for ($i = 0; $i < sizeof($data); $i++) {
        $panier->fillPanierOfArticle($data[$i]["idArticle"], $db);
    }

    for ($i = 0; $i < sizeof($panier->getPanier()); $i++) {
        $total += $panier->getPanier()[$i]->getPrice() * $data[$i]["quantity"];
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
    
<?php require_once("./Views/navbarView.php");?>

    <main>
        <?= $panier->displayPanier($db, getUserID($db)) ?>
        <form action="stripe.php" method="post" id="form_purchase">
            <button class="cta" type="submit" value="<?= getUserID($db) ?>" name = "paiement">
                <span>Acheter les articles</span>
                <svg viewBox="0 0 13 10" height="10px" width="15px">
                    <path d="M1,5 L11,5"></path>
                    <polyline points="8 1 12 5 8 9"></polyline>
                </svg>
            </button>

           
        </form>
        <a href="./index.php">Retourner vers l'accueil</a>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script>
        function refreshData(id, type) {
            var display = document.getElementById(id);
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.open("POST", "./script/refreshData.php");
            xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xmlhttp.send("id=" + encodeURI(id) + "&type=" + type);
            xmlhttp.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    display.innerText = this.responseText;
                } else {
                    //display.innerHTML = "Loading...";
                };
            }
        }
    </script>
    <script src="https://kit.fontawesome.com/dbf52f01db.js" crossorigin="anonymous"></script>
</body>

</html>
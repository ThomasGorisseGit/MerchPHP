<?php
require "script/Article.php";
require "script/Panier2.php";
require "script/User.php";
require "script/connexionDatabase.php";

if (isset($_SESSION["email"]) && !empty($_SESSION["email"])) {

    $panier = new Panier2($db);

    if (isset($_POST["delete"]) && !empty($_POST["delete"])) {
        $id = $_POST["delete"];
        $qte = $panier->getQuantityOfAnArticle($id);
        
        $q = "DELETE FROM Panier WHERE idUser = ? AND idArticle = ?";
        $stmt = $db->prepare($q);
        $stmt->execute(array($panier->getUserID(),$id));
        // header('Refresh:0');
    }
} 
else {
    header('Location: ./connection.php');
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

    <main id="panier_main">
        <?= $panier->displayPanier() ?>
        <form action="stripe.php" method="post" id="form_purchase">
            <button id="button_purchase" class="cta" type="submit" value="<?= $panier->getUserID() ?>" name = "paiement">
                <span>Acheter les articles</span>
                <svg viewBox="0 0 13 10" height="10px" width="15px">
                    <path d="M1,5 L11,5"></path>
                    <polyline points="8 1 12 5 8 9"></polyline>
                </svg>
            </button>

           
        </form>
        <span><a id="home_link" href="./index.php">Retourner vers l'accueil</a></span>
    </main>
    <?php require_once("Views/footerView.html")?>
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
                    console.log(id);

                    // mettre a jour le prix


                } else {
                    //display.innerHTML = "Loading...";
                };
            }
        }
    </script>
    <script src="https://kit.fontawesome.com/dbf52f01db.js" crossorigin="anonymous"></script>
    
</body>

</html>
<?php
session_start();
require "./script/User.php";
require "./script/Article.php";

if (!isset($_SESSION["email"]) && isset($_COOKIE["email"], $_COOKIE["password"]) && !empty($_COOKIE["email"]) && !empty($_COOKIE["password"])) {
    $user = new User($_COOKIE["name"], $_COOKIE["email"], $_COOKIE["password"]);
    if(isset($_COOKIE["image"]) && !empty($_COOKIE["image"]))
    {
        $user->setImage($_COOKIE["image"]);
    }
    $user->startUserSession();
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
    <title>SeinkSansGroove</title>

</head>

<body>
    
    <?php require_once("./Views/navbarView.php");?>
    <main>
        <!-- Contenu de la page d'accueil yo-->
        <section>
            <?php require_once("./Views/ArticleView.php");?>
        </section>
    </main>
    <?php require_once("Views/footerView.html")?>
</body>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script>
        function addArticleToPanier(name) {
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

                } else {
                    //display.innerHTML = "Loading...";
                };
            }
        }
    </script>
</html>
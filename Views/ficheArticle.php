<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require "../script/connexionDatabase.php";
require "../script/Panier2.php";
if(isset($_POST["ajouterPanier"],$_SESSION["email"]))
{
    $panier = new Panier2($db);
    $panier->addArticle($_POST["ajouterPanier"]);
    header('Location:../index.php');
}
elseif((isset($_POST["ajouterPanier"])))
{
    header("Location:../connection.php");
}

function testDisplayArticle()
{
    global $db;
    if (isset($_GET["produit"])) {
        $q = "SELECT * FROM Article WHERE id = ?";
        $stmt = $db->prepare($q);
        $stmt->execute(array($_GET["produit"]));
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        echo displayFicheArticle($data);
    } else {
        echo "produit innexistant, ";
        echo '<a href="../index.php">Retour vers l\'accueil</a>';
    }
}

function displayFicheArticle(array $data): string
{
    $html = "";
    $html .= '<section class="sheet_zone">';
    $html .= '<div id="image_container">';
    $html .= '    <img id="product_image" src="../' . $data["imageProduit"] . '" alt="Fiche du produit numéro ' . $data["nom"] . '">';
    $html .= '</div>';
    $html .= '<div id="division"></div>';

    $html .= '<div id="details_zone">';
    $html .= '  <div class="presentation">';
    $html .= '      <h1>' . $data["nom"] . '</h1>';
    $html .= '      <p>' . $data["description"] . '</p>';
    $html .= '  </div>';
    $html .= '  <div id="item-price-delivery">';
    $html .= '      <span id="item_price" class="item-price">' . $data['prix'] . '€</span>';
    $html .= '      <div id="delivery_zone">';
    $html .= '          <img src="../assets/truck.png" class="truck">';
    $html .= '          <span class="item-delivery">' . $data["prixLivraison"] . '€</span>';
    $html .= '      </div>';
    $html .= '  </div>';
    $html .= '  <div id="shop_cart_container">';
    $html .= '      <form action="" method="post"><button name="ajouterPanier" value="'.$data["id"].'"id="green_button">ajouter au panier</button>';
    $html .= '  <div>';
    $html .= '  </div>';
    $html .= '  </section>';
    $html .= '</div>';
    return $html;
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/product_sheet.css">
    <title>Fiche article</title>
</head>

<body>
    <main>
        <?php testDisplayArticle()?>
        <div id="home_link_container">
            <a id="home_link" href="../index.php">Retour à l'accueil</a>
        </div>
    </main>
</body>

</html>
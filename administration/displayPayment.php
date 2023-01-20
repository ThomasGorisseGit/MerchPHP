<?php
require "../script/connexionDatabase.php";
require "../script/User.php";
$user = new User($_SESSION["name"],$_SESSION["email"],$_SESSION["password"]);
$user->getUserInfos($db);
if(!$user->isAdmin($_SESSION["email"],$db))
{
    header("Location: ../index.php");
}
function displayPayment(PDO $db) : string
{
    $q="SELECT * FROM Billing INNER JOIN Facture ON Facture.id=Billing.idFacture INNER JOIN User ON User.id = Facture.idUser";
    $stmt = $db->prepare($q);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $html ='';
    $html.='<table>';
    $html.='    <thead>';
    $html.='        <tr>';
    $html.='            <td>Nom Utilisateur</td>';
    $html.='            <td>Prix total</td>';
    $html.='            <td>Prix livraison</td>';
    $html.='            <td>TVA</td>';
    $html.='            <td>Prix HT</td>';
    $html.='        </tr>';
    $html.='    </thead>';
    $html.='    <tbody>';
    foreach($data as $pay) {
        $ht=$pay["prixTotal"]-$pay["prixLivraison"]-$pay["prixTVA"];
        $html.='        <tr>';
        $html.='            <td>'.$pay["name"].'</td>';
        $html.='            <td>'.$pay["prixTotal"].'€</td>';
        $html.='            <td>'.$pay["prixLivraison"].'€</td>';
        $html.='            <td>'.$pay["prixTVA"].'€</td>';
        $html.='            <td>'.$ht.'€</td>';
        $html.='        </tr>';
    }
    $html.='    </tbody>';
    $html.='</table>';
    return $html;
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/admin_main.css">
    <title>Liste des paiements</title>
</head>
<body>
    <h1>Liste des paiements</h1>
    <?=displayPayment($db);?>
    <a class="control_pannel" href="./administration.php">Retourner vers le control pannel</a>
</body>
</html>
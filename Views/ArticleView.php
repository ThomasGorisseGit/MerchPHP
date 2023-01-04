<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require "script/connexionDatabase.php";
$query = "SELECT * FROM Article";
$stmt = $db->prepare($query);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

function displayAllArt(array $data)
{
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


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    displayAllArt($data);
    ?>
</body>
</html>

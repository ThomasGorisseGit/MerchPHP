<?php

require "../script/connexionDatabase.php";
require "../script/User.php";
$user = new User($_SESSION["name"],$_SESSION["email"],$_SESSION["password"]);
$user->getUserInfos($db);
if(!$user->isAdmin($_SESSION["email"],$db))
{
    header("Location: index.php");
}
if(isset($_POST["submit"]))
{
    $q = "DELETE FROM User WHERE id = ?";
    $stmt = $db->prepare($q);
    $stmt->execute(array($_POST["submit"]));
}
if(isset($_POST["admin"]))
{
    $q="UPDATE User SET administrator = false WHERE id = ?";
    $stmt=$db->prepare($q);
    $stmt->execute(array($_POST["admin"]));
    header('Refresh:0');
}
function displayMembers(PDO $db) : string
{
    $q="SELECT * FROM User";
    $stmt = $db->prepare($q);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $html="";
    $html.='<table>';
    $html.='    <thead>';
    $html.='        <tr><th>Nom</th>';
    $html.='        <th>Adresse email</th></tr>';
    $html.='    </thead>';
    $html.='    <tbody>';
            
            foreach($data as $user)
            {
                
    $html.='            <tr>';
    $html.='            <td>    '.$user["name"].'</td>';
    $html.='              <td>  '.$user["email"].'</td>';
            if($user["administrator"])
            {
    $html.='                    <td>ADMIN</td>';
    $html.='            <td><form action=""method="POST"><button value='.$user["id"].' name="admin">Retirer les droits</button></form></td>';
            }
    $html.='<td><form method="POST"><button type="submit" name="submit" value='.$user["id"].'>Supprimer</button></form></td>';
    $html.='            </tr>';
            }
    $html.='        </tbody>';

           
        
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
    <title>Liste des membres</title>
</head>
<body>
    <h1>Voici la liste des inscrits</h1>
    <?=displayMembers($db)?>
    <a href="./administration.php">Retour vers le control pannel</a>
</body>
</html>
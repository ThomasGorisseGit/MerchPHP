<?php

require "../script/connexionDatabase.php";
require "../script/User.php";
$user = new User($_SESSION["name"], $_SESSION["email"], $_SESSION["password"]);
$user->getUserInfos($db);
if (!$user->isAdmin($_SESSION["email"], $db)) {
    header("Location: ../index.php");
}
if (isset($_POST["submit"])) {
    $q = "DELETE FROM User WHERE id = ?";
    $stmt = $db->prepare($q);
    $stmt->execute(array($_POST["submit"]));
}
if (isset($_POST["admin"])) {
    $q = "UPDATE User SET administrator = false WHERE id = ?";
    $stmt = $db->prepare($q);
    $stmt->execute(array($_POST["admin"]));
    header('Refresh:0');
}
function displayMembers(PDO $db): string
{
    $q = "SELECT * FROM User";
    $stmt = $db->prepare($q);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $html = "";
    $html .= '<table>';
    $html .= '    <thead>';
    $html .= '        <tr>';
    $html .= '          <td>Nom</td>';
    $html .= '          <td>Adresse email</td>';
    $html .= '          <td>Type</td>';
    $html .= '          <td>Retirer les droits</td>';
    $html .= '          <td>Supprimer l\'utilisateur</td>';
    $html .= '        </tr>';
    $html .= '    </thead>';
    $html .= '    <tbody>';

    foreach ($data as $user) {

        $html .= '            <tr>';
        $html .= '            <td>    ' . $user["name"] . '</td>';
        $html .= '              <td>  ' . $user["email"] . '</td>';
        if ($user["administrator"]) {
            $html .= '                    <td>ADMIN</td>';
            $html .= '            <td><form action=""method="POST"><button class="dangerous_button" value=' . $user["id"] . ' name="admin"><i class="fa fa-close"></i> </button></form></td>';
        }
        else
        {
            $html .= '                    <td>USER</td>';
            $html .= '            <td><form><button disabled class="dangerous_button desactivated"><i class="fa fa-close"></i></button></form></td>';
        }
        $html .= '<td><form method="POST"><button class="dangerous_button" type="submit" name="submit" value=' . $user["id"] . '><i class="fa fa-trash"></i></button></form></td>';
        $html .= '            </tr>';
    }
    $html .= '        </tbody>';



    $html .= '</table>';

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
    <link rel="stylesheet" href="../styles/admin_members.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Liste des inscrits</title>
</head>

<body>
    <h1>Liste des inscrits</h1>
    <?= displayMembers($db) ?>
    

    <a class="control_pannel" href="./administration.php">Retour vers le control pannel</a>
</body>

</html>
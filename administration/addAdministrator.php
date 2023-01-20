<?php
require "../script/connexionDatabase.php";
require "../script/User.php";
$user = new User($_SESSION["name"], $_SESSION["email"], $_SESSION["password"]);
$user->getUserInfos($db);
if (!$user->isAdmin($_SESSION["email"], $db)) {
    header("Location: ../index.php");
}
if (isset($_POST["email"])) {
    addAdministrator($_POST["email"], $db);
}
function accountDoesntExist_or_alreadyAdministrator(string $email, PDO $db): bool
{
    $q = "SELECT * FROM User WHERE email = ?";
    $stmt = $db->prepare($q);
    $stmt->execute(array($email));
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    return $data["administrator"];
}

function addAdministrator(string $email, PDO $db)
{
    if (!accountDoesntExist_or_alreadyAdministrator($email, $db)) {
        $q = "UPDATE User SET administrator = true WHERE email = ?";
        $stmt = $db->prepare($q);
        $stmt->execute(array($email));
        echo "done";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/admin_main.css">
    <title>Ajouter un administrateur</title>
</head>

<body>
    <h1>Ajouter un administrateur</h1>
    <form class="basic_form" action="" method="POST">
        <input type="email" name="email" placeholder="Saisir l'email de votre futur administrateur">
        <button type="submit">Ajouter</button>
    </form>
    <a class="control_pannel" href="./administration.php">Retour vers le control pannel</a>
</body>

</html>
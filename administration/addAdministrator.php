<?php
require "../script/connexionDatabase.php";
require "../script/User.php";
if(isset($_POST["email"]))
{
    addAdministrator($_POST["email"],$db);
}
function accountDoesntExist_or_alreadyAdministrator(string $email,PDO $db) : bool
{
    $q="SELECT * FROM User WHERE email = ?";
    $stmt = $db->prepare($q);
    $stmt->execute(array($email));
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    return $data["administrator"];
}

function addAdministrator(string $email,PDO $db)
{
    if(!accountDoesntExist_or_alreadyAdministrator($email,$db))
    {
        $q = "UPDATE User SET administrator = true WHERE email = ?";
        $stmt = $db->prepare($q);
        $stmt->execute(array($email));
        echo "done";
    }
}

?>
<form action=""method="POST">
    <input type="email" name ="email" placeholder="Saisir l'email de votre futur administrateur">
    <button type="submit">Ajouter</button>
</form>
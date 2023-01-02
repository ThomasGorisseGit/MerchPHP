<?php
require "./script/connexionDatabase.php";
if(isset($_POST["submit"]) && !empty($_POST["email"]))
{
    sendConfirmMail(htmlentities(trim($_POST["email"])),$db);
}
function sendConfirmMail(string $email,PDO $db)
{
    $query = "SELECT * FROM User WHERE email = ?";
    $stmt = $db->prepare($query);
    $stmt->execute(array($email));
    $stmt->fetch(PDO::FETCH_ASSOC);
    if($stmt->rowCount() == 1)
    {
        $new_pass = crypt("123456789","Votre clé unique de cryptage du mot de passe");
        $object = 'Nouveau mot de passe';
        $header = "FROM : SeinkSansGroove \n";
        $header .= "Reply-to : ".$email;
        $content = "<html>".
        "<body>".
        "<p style='text-align: center; font-size:18px'><b>Bonjour Mme, Mr" . $email. " </b></p>".
        "<p style='text-align:justify;'>Voici votre nouveau mot de passe :" .$new_pass." </p>".
        "</body>".
        "</html>";
        mail($email,$object,$content,$header);
        $query = "UPDATE User SET password = ? WHERE email = ?";
        $stmt = $db->prepare($query);
        if($stmt->execute(array($new_pass,$email)))
        {
            echo "Un mail a été envoyé";
            echo "Le site internet rencontre un problème avec l'envoi du mail. L'erreur sera corrigée dans les plus brefs délais";
        }

    }
    else{
        die("Aucun utilisateur ne possède cette adresse email");
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié</title>
    <link rel="icon" href="./assets/Logo.png">

</head>
<body>
    <?php require_once("./Views/navbarView.php");?>

    <form action="" method="POST">
        <input type="email" name="email" placeholder="Saisir votre email" required>
        <button type="submit" name="submit">Envoyer un mail</button>
    </form>
</body>
</html>
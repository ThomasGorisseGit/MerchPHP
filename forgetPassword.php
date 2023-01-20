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
        $header = 'Nouveau mot de passe';
        $header .= "FROM : SeinkSansGroove \n";
        $header .= "Reply-to : ".$email;
        $content = "<html>".
        "<body>".
        "<p style='text-align: center; font-size:18px'><b>Bonjour Mme, Mr " . $email. " </b></p>".
        "<p style='text-align:center;'>Voici votre nouveau mot de passe :" .$new_pass." </p>".
        "</body>".
        "</html>";
        require_once("./mailgun.php");
        postCurl("https://api.eu.mailgun.net/v3/seinksansgroove.studio/messages",
            array(
                'from' => '512Admin mailgun@seinksansgroove.studio',
                'to' => $email,
                'subject' => $header,
                'html' => $content
            ),
            $MAIL_GUN_API_KEY
        );
        $new_pass=password_hash($new_pass, PASSWORD_DEFAULT);
        $query = "UPDATE User SET password = ? WHERE email = ?";
        $stmt = $db->prepare($query);
        if($stmt->execute(array($new_pass,$email)))
        {
            echo "Un mail a été envoyé";
        }

    }
    else{
        die("Aucun utilisateur ne possède cette adresse email");
    }
}
function postCurl($url, $data, $mailgunApi)
{
 
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_USERPWD,$mailgunApi);
    $o = curl_exec($ch);
    curl_close($ch);
    return $o;
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
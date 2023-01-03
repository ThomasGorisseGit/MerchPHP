
<?php
require "./script/connexionDatabase.php";
require "./script/User.php";
if(!isset($_SESSION["password"]) or empty($_SESSION["password"]))
{
    header("Location:index.php");
}

$query = "SELECT * FROM User WHERE email= ?";
$stmt = $db->prepare($query);
$stmt->execute(array($_SESSION["email"]));
$data = $stmt->fetch(PDO::FETCH_ASSOC);

 
$user = new User($data["name"],$data["email"],$data["password"],$data["profilePicture"]);

if(isset($_POST["submit"]))
{
    if(isset($_POST["name"]) && !empty($_POST["name"]))
    {
        $user->setName(htmlspecialchars(trim($_POST["name"])));
    }
    if(isset($_POST["email"])&& !empty($_POST["email"]))
    {
        $user->setEmail(htmlspecialchars(trim($_POST["email"])));
        if( !($user->validateUser($db)))
        {   
            $user->setEmail($data["email"]); // email déja prise
        }
    }
    if(isset($_POST["password"]) && !empty($_POST["password"]))
    {
        $user->setPassword(htmlspecialchars(trim($_POST["password"])));
        $user->hashPassword();
    }
  
    if(isset($_FILES["pp"]) && !empty($_FILES["pp"]["name"]))
    {
        $maxsize = 2030000;
        $ext = array('jpg','jpeg','png','gif');
        if($_FILES["pp"]["size"] < $maxsize)
        {
            $extUpload = strtolower(substr(strrchr($_FILES["pp"]["name"], '.'),1));
            if(in_array($extUpload,$ext))
            {
                $path = "assets/avatar/".$data["id"] .".".$extUpload;                
                
                if(move_uploaded_file($_FILES["pp"]["tmp_name"], $path))
                {
                    $user->setImage($path);
                    $update = $db->prepare("UPDATE User SET profilePicture = ? WHERE id = ?");
                    $update->execute(array(
                        $path,
                        $data["id"]
                    ));
                }
                else{
                    echo("Une erreur est survenue lors de l'importation de votre photo de profil");
                }
                
            }
            else{
                echo("Votre photo n'est pas au bon format' : jpg jpeg png ou gif");
            }
        }
        else{
            echo("Votre photo de profil est trop volumineuse");
        }
    }
    
    if($user->changeUserInfo($data["id"],$db))
    {
        $user->startUserSession();
        if(isset($_POST["rememberMe"]))
        {
            $user->rememberMe();            
        }
        header("Location: profile.php");
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification du profile de <?= $_SESSION["name"];?></title>
    <link rel="icon" href="./assets/Logo.png">

</head>
<body>
    <?php require_once("./Views/navbarView.php");?>

    <form action="" method="POST" enctype="multipart/form-data">
        <input type="file" name="pp" >    
        <input type="text" placeholder="Nom" name="name" >
        <input type="email" placeholder="Email" name="email">
        <input type="password" placeholder="Mot de passe" name="password" >
        <Label for="rememberMe">Se souvenir de moi</Label>
        <input type="checkbox" name="rememberMe">
        <button name="submit" type="submit">Modifier votre profil</button>
    </form >
    <button onclick="location.href='index.php'">Retourner à l'accueil</button>
</body>
</html>

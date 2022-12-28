<?php
require "./script/connexionDatabase.php";
require "./script/User.php";

function createUser(string $name, string $email, string $password,PDO $db) : void 
{
    if(checkPassword($password))
    {
        $user = new User(htmlspecialchars(trim($name)),htmlspecialchars(trim($email)),htmlspecialchars(trim($password)));
        if($user->addUser($db))
        {
            $user->startUserSession();
            if(isset($_POST["rememberMe"]))
            {
                $user->rememberMe(); 
                #Ca fonctionne mais il faut testé si la session fonctionne : si l'user est bien connecté
            }
        }
        else{
            echo "erreur d'insertion";
        }
    }
    else{
        die("mot de passe trop court");
    }
}
function checkPassword(string $password) : bool
{
   if(strlen($password)>=6) {return true;}
    return false;
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
<form method="POST" action="">
    <input type="text" placeholder="Nom" name="name">
    <input type="email" placeholder="Email" name="email">
    <input type="password" placeholder="Mot de passe" name="password">
    <Label for="rememberMe">Remember me</Label>
    <input type="checkbox" value="rememberMe" name="rememberMe">
    <button type="submit" name="submit" value="submit">S'inscrire</button>
</form>
</body>
</html>

<?php
if(isset($_POST["submit"]))
{
    createUser($_POST["name"],$_POST["email"],$_POST["password"],$db );
}
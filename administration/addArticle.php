<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require "../script/connexionDatabase.php";
require "../script/User.php";
$user = new User($_SESSION["name"],$_SESSION["email"],$_SESSION["password"]);
$user->getUserInfos($db);
if(!$user->isAdmin($_SESSION["email"],$db))
{
    header("Location: index.php");
}
$q="SELECT * FROM Article";
    $stmt = $db->prepare($q);
    $stmt->execute();
    $data =$stmt->fetchAll(PDO::FETCH_ASSOC);
    $max = 0;
    foreach($data as $art)
    {
        if($art["id"] > $max)
        {
            $max = $art["id"];
        }
    }
if(isset($_FILES["image"]) && !empty($_FILES["image"]["name"]))
    {
        $maxsize = 4030000;
        $ext = array('jpg', 'jpeg', 'png', 'gif');
        if ($_FILES["image"]["size"] < $maxsize) {
            $extUpload = strtolower(substr(strrchr($_FILES["image"]["name"], '.'), 1));
            if (in_array($extUpload, $ext)) {
                $max +=1;
                $path = "assets/articles" . $max . "." . $extUpload;
                if (move_uploaded_file($_FILES["image"]["tmp_name"],"../".$path)) {
                    $image = $path;
                } else {
                    echo ("Une erreur est survenue lors de l'importation de votre photo");
                }
            } else {
                echo ("Votre photo n'est pas au bon format' : jpg jpeg png ou gif");
            }
        } else {
            echo ("Votre photo de profil est trop volumineuse");
        }
    }
if(isset($_POST["name"]) && $image!="")
{
    $q="INSERT INTO Article(nom,prix,prixLivraison,description,dateVente,imageProduit)VALUES(?,?,?,?,?,?)";
    $stmt = $db->prepare($q);
    $stmt->execute(array($_POST["name"],$_POST["price"],$_POST["delivery"],$_POST["description"],$_POST["date"],$image));
    ?>
    <script>alert("Article ajouté avec succès");</script>
    <?php
}

/* TODO 
if (isset($_FILES["pp"]) && !empty($_FILES["pp"]["name"])) {
    $maxsize = 2030000;
    $ext = array('jpg', 'jpeg', 'png', 'gif');
    if ($_FILES["pp"]["size"] < $maxsize) {
        $extUpload = strtolower(substr(strrchr($_FILES["pp"]["name"], '.'), 1));
        if (in_array($extUpload, $ext)) {
            $path = "assets/avatar/" . $data["id"] . "." . $extUpload;

            if (move_uploaded_file($_FILES["pp"]["tmp_name"], $path)) {
                $user->setImage($path);
                $update = $db->prepare("UPDATE User SET profilePicture = ? WHERE id = ?");
                $update->execute(array(
                    $path,
                    $data["id"]
                ));
            } else {
                echo ("Une erreur est survenue lors de l'importation de votre photo de profil");
            }
        } else {
            echo ("Votre photo n'est pas au bon format' : jpg jpeg png ou gif");
        }
    } else {
        echo ("Votre photo de profil est trop volumineuse");
    }
}
*/
?>
<h1>Ajouter article</h1>
<form action="" method="POST" enctype="multipart/form-data">
<input type="nom" placeholder="nom " name="name" required>
<input type="number" step="0.01" placeholder="prix" name="price"required>
<input type="number" step="0.01" placeholder="prix de la livraison" name="delivery"required>
<input type="text" name="description" placeholder="description" id="" required>
<input type="text" placeholder="date de mise en vente" name="date"required>
<input type="file" placeholder="Photo de l'article" name="image"required>
<button type="submit">Ajouter</button>
</form>
<a href="./administration.php">Retour vers le control pannel</a>
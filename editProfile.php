<?php
require "./script/connexionDatabase.php";
require "./script/User.php";
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
if (!isset($_SESSION["password"]) or empty($_SESSION["password"])) {
    header("Location:index.php");
}

$query = "SELECT * FROM User WHERE email= ?";
$stmt = $db->prepare($query);
$stmt->execute(array($_SESSION["email"]));
$data = $stmt->fetch(PDO::FETCH_ASSOC);

$user = new User($data["name"], $data["email"], $data["password"], $data["profilePicture"]);

if (isset($_POST["submit"])) {
    if (isset($_POST["name"]) && !empty($_POST["name"])) {
        $user->setName(htmlspecialchars(trim($_POST["name"])));
    }
    if (isset($_POST["email"]) && !empty($_POST["email"])) {
        $user->setEmail(htmlspecialchars(trim($_POST["email"])));
        if (!($user->validateUser($db))) {
            $user->setEmail($data["email"]); // email déja prise
        }
    }
    if (isset($_POST["password"]) && !empty($_POST["password"])) {
        $user->setPassword(htmlspecialchars(trim($_POST["password"])));
        $user->hashPassword();
    }

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

    if ($user->changeUserInfo($data["id"], $db)) {
        $user->startUserSession();
        if (isset($_POST["rememberMe"])) {
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
    <title>Modification du profile de <?= $_SESSION["name"]; ?></title>
    <link rel="icon" href="./assets/Logo.png">
    <link rel="stylesheet" href="./styles/editProfile.css">
</head>

<body>
    <?php require_once("./Views/navbarView.php"); ?>
    <main id="principalContener">
        <form action="" method="POST" enctype="multipart/form-data" class="profile_zone">
            <label for="pp" name="pp">
                <div class="photos">
                    <div class="ancienne_photo">
                        <div id="oldtext">Cliquer pour modifier votre photo de profil</div>
                        <label for="pp" id="labelImport">
                            <img src=<?= $_SESSION["image"] ?> width="80px" alt="photo de profil" id="oldpic">
                        </label>
                        <div id="greyblock"></div>
                    </div>
                    <div class="nouvelle_photo" id="newpicdiv">
                        <div>nouvelle photo</div>
                        <img src=<?= $_SESSION["image"] ?> width="80px" id="newpic" alt="">
                    </div>
                </div>
                <div id="image_format_error">Format d'image non supporté</div>

            </label>
            <input type="file" id="pp" name="pp" onchange="loadFile(event)"></input>
            <label>Modifier votre nom d'utilisateur</label>
            <input type="text" value=<?= $_SESSION["name"]; ?> name="name">
            <label>Modifier votre adresse mail</label>
            <input type="email" name="email">

            <label>Modifier le mot de passe</label>

            <input type="password" name="password">
            <label for="rememberMe">Se souvenir de moi <input id="remember" type="checkbox" name="rememberMe"></label>

            <button name="submit" type="submit" id="save_changes_button">Sauvegarder les modifications</button>
        </form>

        <div class="buttons">
            <button id="home_button" onclick="location.href='index.php'">Retourner à l'accueil</button>
        </div>
        </div>
    </main>

    <script>
        var loadFile = function(event) {

            let input = document.getElementById("pp");

            // faire attention au type du fichier
            const supported_types = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];

            let image_type = input.files[0].type;
            console.log(image_type);
            // console.log("inclusion " + supported_types.includes(image_type) + " type " + typeof(image_type));
            if (!supported_types.includes(image_type)) {
                console.log("le format de l'image n'est pas supporté");
                let error_message = document.getElementById("image_format_error");
                error_message.style.opacity = 1;
                return;
            }

            let image = document.getElementById("newpic");
            let maskeddiv = document.getElementById("newpicdiv");

            let oldtext = document.getElementById("oldtext");
            let photoContener = document.getElementsByClassName("photos")[0];

            image.src = URL.createObjectURL(event.target.files[0]);
            maskeddiv.style.display = "flex";
            oldtext.innerText = "ancienne photo";
            oldtext.style.opacity = 1;
            photoContener.classList.add("gapped");
        }
    </script>
</body>

</html>
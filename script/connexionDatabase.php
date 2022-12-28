<?php
$host = 'localhost';
$user ='Site';
$pass = '#WebsiteAcces2022';
$name = 'phpMerch';
try{
    $db = new PDO("mysql:host=".$host.";dbname=".$name, $user, $pass);

}
catch(PDOException $e){
    echo("Database can't load");
}

<?php
require "./script/connexionDatabase.php";
require "./script/User.php";


$user = new User('admin','j','admin');
echo $user . "</br>";

$user->addUser($db);
<?php
require "./script/Controller/UserController.php";
require "./script/Model/UserModel.php";
$user = new UserModel("Tho","ma","admin");
$userController = new UserController();
$userController->setModel($user);
$userController->insertUser();
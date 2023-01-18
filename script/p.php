<?php
require "./connexionDatabase.php";
require "./Panier2.php";
$p = new Panier2($db);
$p->removeArticle(1);

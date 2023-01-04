<?php
require "./Panier.php";
require "./Article.php";

$art1 = new Article(1,"JBL",2.1,1,"description","auj","non");
$art2 = new Article(2,"JBL",2,1,"description","auj","non");
$art3 = new Article(3,"Non",21,122,"ahah","auj","non");
$art4 = new Article(4,"JBL",2,1,"description","auj","non");

$panier = new Panier();

$panier->addArticle($art1);
$panier->addArticle($art2);
$panier->addArticle($art3);
$panier->addArticle($art4);



echo ($panier->getTotal());

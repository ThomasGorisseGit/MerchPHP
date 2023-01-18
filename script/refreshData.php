<?php
session_start();

require "connexionDatabase.php";
require "Panier2.php";




if(isset($_POST["id"]))
{
    $panier = new Panier2($db);
    if($_POST["type"]==1)
    {
        if($panier->getQuantityOfAnArticle($_POST["id"])>1)
        {
            $panier->removeArticle($_POST["id"]);
        }       
    }  
    if($_POST["type"]==0)
    {
        $panier->addArticle($_POST["id"]);
    }
    echo $panier->getQuantityOfAnArticle($_POST["id"]);
    
}

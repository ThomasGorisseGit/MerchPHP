<?php

class Article{

    private int $id;
    private string $name;
    private float $price;
    private float $delivery;
    private string $description;
    private string $date;
    private string $image;

    function __construct(int $id,string $name, float $price, float $delivery,string $description,string $date,string $image)
    {
        $this->id = $id;
        $this->name = $name;  
        $this->price = $price;  
        $this->delivery = $delivery;
        $this->description = $description;
        $this->date = $date;
        $this->image = $image;
    }
    function getName() : string
    {
        return $this->name;
    }
    function __toString() : string
    {
        return "article :" . $this->name. $this->price. $this->delivery.$this->description.$this->date;
    }
    function getPrice() : float
    {
        return $this->price;
    }
    function getDelivery() : float
    {
        return $this->delivery;
    }
    function getID() : int
    {
        return $this->id;
    }
    function displayArticle() : string
    {
         
       
        $html ='<article class="article-item">';
        $html .='    <div class="item-image">';
        $html .='        <img width="200px" src="'.$this->image.'" alt="image de l\'article '.$this->name.'">';
        $html .='    </div>';
        $html .='    <div class="item-content">';
        $html .='        <h1 class="item-title">'.$this->name.'</h1>';
        $html .='        <div class="item-price-delivery">';
        $html .='            <span class="item-price">' . $this->price .'€</span>';
        $html .='            <img src="./assets/truck.png" class="truck">';
        $html .='            <span class="item-delivery">'.$this->delivery.'€</span>';
        $html .='        </div>';
        $html .='        <p class="item-description">';
        $html .='            '.$this->description.'';
        $html .='    </p>';
        $html .= '       <form action="panierController.php" method="POST">';
        $html .='           <div class="item-buttons">';                  
        $html .='               <button class="item-button-grey">Fiche produit</button>';
        $html .='               <button name="ajouterPanier" value = "'.$this->name.'"class="item-button-green" >Ajouter au panier</button>';
        $html .='           </div>';
        $html .='        </form>';
        $html .='        <span class="date-word">Date : </span>';
        $html .='        <span class="item-date">'.$this->date.'</span>';
        $html .='    </div>';
        $html .='</article>';
    
      
        return $html; 
    }
}
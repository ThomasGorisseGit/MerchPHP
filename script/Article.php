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
    function getImage() : string
    {
        return $this->image;
    }
    function getDescription() : string
    {
        return $this->description;
    }
    function displayArticle() : string
    {
        /**
         * Display dans index.php
         */
    
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
        $html .='           <div class="item-buttons">';                  
        $html .='               <form action="Views/ficheArticle.php" method="GET" ><button name="produit" value="'.$this->id.'" class="item-button-grey"><span>Fiche produit</span></button></form>';
        $html .='               <button name="ajouterPanier" data-hover="ratio" onclick="addArticleToPanier('.$this->id.')" value = "'.$this->name.'"class="item-button-green" >Ajouter au panier</button>';
        $html .='           </div>';
        $html .='        <span class="date-word">Date : </span>';
        $html .='        <span class="item-date">'.$this->date.'</span>';
        $html .='    </div>';
        $html .='</article>';
        return $html;
            
    }
    function articleInPanier()
    {
         /**
         * Display dans panier.php
         */
        $html = "";
        $html .='<article>';
        $html .='    <section class="description">';
        $html .='        <div class="image">';
        $html .='            <img src="'.$this->image.'" alt="'.$this->name.'">';
        $html .='        </div>';
        $html .='        <div class="content">';
        $html .='            <h3 class="name">'.$this->name;
        $html .='            </h3>';
        $html .='            <p class="description">'.$this->description;
        $html .='            </p>';
        $html .='        </div>';
        $html .='    </section>';
        $html .='    <section class = "diverses_prices">';
        $html .='        <div class="prix"><img width="30px" src = "./assets/caddie.png" alt=""/>'.'<span class="prix_value">'.$this->price.'</span>';
        $html .='€        </div>';
        $html .='        <div class="livraison">';
        $html .=' <img width="30px" src = "./assets/truck.png" alt=""/>';
        $html .=' '.$this->delivery.'€';
        $html .='       </div>';
        $html .='    </section>';
        return $html;
    }
}
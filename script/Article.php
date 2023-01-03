<?php

class Article{

    private int $id;
    private string $name;
    private float $price;
    private float $delivery;
    private string $description;
    private string $date;
    private string $image;

    function __construct(string $name, float $price, float $delivery,string $description,string $date,string $image)
    {
        $this->name = $name;  
        $this->price = $price;  
        $this->delivery = $delivery;
        $this->description = $description;
        $this->date = $date;
        $this->image = $image;
    }
    function getArticle(PDO $db)
    {
        $q = "SELECT * FROM Article";
    }
    function __toString() : string
    {
        return "article :" . $this->name. $this->price. $this->delivery.$this->description.$this->date;
    }
    function displayArticle()
    {
       ?>
        <article class="article-item">
            <div class="item-image">
                <img width="200px" src="<?= $this->image; ?>" alt="image de l\'article <?= $this->id;?>">
            </div>
            <div class="item-content">
                <h1 class="item-title"><?=$this->name;?></h1>
                <div class="item-price-delivery">
                    <span class="item-price"><?=$this->price;?>€</span>
                    <img src="./assets/truck.png" class="truck">
                    <span class="item-delivery"><?=$this->delivery;?></span>
                </div>
                <p class="item-description">
                    <?= $this->description;?>
            </p>
                <div class="item-buttons">
                    <button class="item-button-grey">Fiche produit</button>
                    <button class="item-button-green">Ajouter au panier</button>
                </div>
                <span class="date-word">Date : </span>
                <span class="item-date"><?=$this->date;?></span>
            </div>
        </article>
    <?php
    }
}
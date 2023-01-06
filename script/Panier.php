<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class Panier{
    private array $articles;
    
    function __construct(?array $articles = array())
    {
        $this->articles = $articles;
    }

    function addArticle(Article $article) : void
    {
        array_push($this->articles,$article);
    }
    function removeArticle(Article $article) : void
    {
        foreach($this->articles as $art)
        {
            if($art->getName()== $article->getName())
            {
                array_splice($this->articles,array_search($art,$this->articles),1);
                return;
            }
        }
    }
    function getPanier() : array
    {
        return $this->articles;
    }
    function totalPrice(array $articles) : void
    {
        print_r($articles);
    }
    function totalDelivery() : float
    {
        $total = 0;
        foreach($this->articles as $article)
        {
            $total += $article->getDelivery();
        }
        return $total;
    }
    function getTotal() : float
    {
        return $this->totalDelivery() ;
    }

    function __toString()

    {
        $res =" </br> ";
        foreach($this->articles as $article)
        {
            $res .=$article->getName() ."</br>"; 
        }
        return $res;
    }
    function getNumberOfArticle(Article $article,$db, int $userID) : int
    {
        $q="SELECT * FROM Panier WHERE idArticle = ? AND idUser = ?";
        $stmt = $db->prepare($q);   
        $stmt->execute(array($article->getID(),$userID));  
        $total = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!empty($total["quantity"]))
        {
            return $total["quantity"];
        }
        return 0;
    }
    function getUserPanier(int $userID,PDO $db) : array
    {
        $q = "SELECT * FROM Panier WHERE idUser = ?";
        $stmt = $db->prepare($q);
        $stmt->execute(array($userID));
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
    function fillPanierOfArticle(int $articleID,PDO $db)
    {
        $q = "SELECT * FROM Article WHERE id = ?";
        $stmt = $db->prepare($q);
        $stmt->execute(array($articleID));
        $articleList = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($articleList as $tempart)
        {
            $article = new Article(
                $tempart["id"],
                $tempart["nom"],
                $tempart["prix"],
                $tempart["prixLivraison"],
                $tempart["description"],
                $tempart["dateVente"],
                $tempart["imageProduit"]
            );
            $this->addArticle($article);
        }
    }
    function displayPanier(PDO $db,int $userID) : string
    {
        $html='';
        foreach($this->articles as $article)
        {
            $html .= $article->articleInPanier(); 
            $html.='<form action="" method="post">';
            $html.='    <section class="qte">';

            $html.='        <div class="qte-item">';
            $html.='            <button type="submit" name="plus" value="'.$article->getName().'">+</button>';
            $html.='        </div>';

            $html.='        <div class="qte-item">';
            $html.='            <p class="quantite">'.$this->getNumberOfArticle($article,$db,$userID).'</p>';
            $html.='        </div>';

            $html.='        <div class="qte-item">';
            $html.='            <button type="submit" name="minus" value="'.$article->getName().'">-</button>';
            $html.='        </div>';

            $html.='    </section>';
            $html.='</form>';
            $html.='<form action="" method="post">';
            $html.='<button type="submit" name="delete" value="'.$article->getName().'">supprimer</button>';
            $html.='</form>';
            $html.='</article>';
            
        }
        return $html;
    }
    function displayTotalPrice(float $total) : string
    {
        
        $html = '';
        
        $html.='<section>';
        $html.='    <div>';
        $html.='        <p class="prix">prix des articles '.$total .' </p> ';
        $html.='        <p class="livraison">prix de la livraison '.$this->totalDelivery().'</p>   ';
        $html.='        <p class="total">TTC : '.$total + $this->totalDelivery().'</p>           ';
        $html.='    </div>';
        $html.='    <form method="post" action="./paiement.php">';
        $html.='        <button type="submit" value="paiement" name="paiement">Passer au règlement</button>';
        $html.='    </form>';
        $html.='</section>';
    
        return $html;
        
        
    }
}

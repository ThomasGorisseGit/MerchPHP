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
            $id = $article->getID();
            $html .= $article->articleInPanier(); 
            // $html.='<form action="" method="POST">';
            $html.='    <section id="qte" class="qte">';
            //$html.='        <div class="qte-item">';
            $html.='            <button type="submit" onclick=refreshData('.$id.',0) class="plus_button" name="plus" value='.$article->getID().'>+</button>';
            //$html.='        </div>';
            //$html.='        <div class="qte-item">';
            $html.='            <p id="'.$id.'" class="quantite">'.$this->getNumberOfArticle($article,$db,$userID).'</p>';
            //$html.='        </div>';
            //$html.='        <div class="qte-item">';
            $html.='            <button type="submit" onclick=refreshData('.$id.',1) class="minus_button" name="minus" value='.$article->getID().'>-</button>';
            //$html.='        </div>';
            $html.='    </section>';
            // $html.='</form>';
            $html.='<form action="" method="post">';
            
            
            $html.= "<button type='submit' id='delete' name='delete' value='".$article->getID()."'>
                <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20' height='25' width='25'>
                    <path fill='#9D0000' d='M8.78842 5.03866C8.86656 4.96052 8.97254 4.91663 9.08305 4.91663H11.4164C11.5269 4.91663 11.6329 4.96052 11.711 5.03866C11.7892 5.11681 11.833 5.22279 11.833 5.33329V5.74939H8.66638V5.33329C8.66638 5.22279 8.71028 5.11681 8.78842 5.03866ZM7.16638 5.74939V5.33329C7.16638 4.82496 7.36832 4.33745 7.72776 3.978C8.08721 3.61856 8.57472 3.41663 9.08305 3.41663H11.4164C11.9247 3.41663 12.4122 3.61856 12.7717 3.978C13.1311 4.33745 13.333 4.82496 13.333 5.33329V5.74939H15.5C15.9142 5.74939 16.25 6.08518 16.25 6.49939C16.25 6.9136 15.9142 7.24939 15.5 7.24939H15.0105L14.2492 14.7095C14.2382 15.2023 14.0377 15.6726 13.6883 16.0219C13.3289 16.3814 12.8414 16.5833 12.333 16.5833H8.16638C7.65805 16.5833 7.17054 16.3814 6.81109 16.0219C6.46176 15.6726 6.2612 15.2023 6.25019 14.7095L5.48896 7.24939H5C4.58579 7.24939 4.25 6.9136 4.25 6.49939C4.25 6.08518 4.58579 5.74939 5 5.74939H6.16667H7.16638ZM7.91638 7.24996H12.583H13.5026L12.7536 14.5905C12.751 14.6158 12.7497 14.6412 12.7497 14.6666C12.7497 14.7771 12.7058 14.8831 12.6277 14.9613C12.5495 15.0394 12.4436 15.0833 12.333 15.0833H8.16638C8.05588 15.0833 7.94989 15.0394 7.87175 14.9613C7.79361 14.8831 7.74972 14.7771 7.74972 14.6666C7.74972 14.6412 7.74842 14.6158 7.74584 14.5905L6.99681 7.24996H7.91638Z' clip-rule='evenodd' fill-rule='evenodd'></path>
                </svg>
                </button>";
            $html.='</form>';
            $html.='</article>';

            
            
            

        }
        return $html;
    }



}



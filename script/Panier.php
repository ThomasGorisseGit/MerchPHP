<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class Panier{
    private array $articles;
    private array $articleList;
    function __construct(?array $articles = array(),?array $articleList = array())
    {
        $this->articles = $articles;
        $this->articleList = $articleList;
    }

    function addArticle(Article $article) : void
    {
    
        if(isset($this->articles[$article->getName()]))
        {
            $this->articles[$article->getName()]+=1;
        }
        else{
            $this->articles[$article->getName()]=1;
        }
        array_push($this->articleList,$article);
       
    }
    function removeArticle(Article $article) : void
    {
        unset($this->articles[$article->getName()]);
        $i=0;
        foreach($this->articleList as $articleL)
        {
            
            if($articleL->getName()==$article->getName())
            {
                unset($this->articleList[$i]);
            }
            $i++;
        }
        $this->articleList = array_values($this->articleList);

    }
    function deleteQTEArticle(Article $article) : void
    {
        if(isset($this->articles[$article->getName()]) && $this->articles[$article->getName()]>1)
        {
            $this->articles[$article->getName()]-=1;
        }
        else{
            $this->removeArticle($article);
        }
        for($i=0;$i<count($this->articleList);$i++)
        {
            if(isset($this->articleList[$i]) && $this->articleList[$i]->getName()==$article->getName())
            {
                
                array_splice($this->articleList,$i,1);
                return;
            }
        }
    }
    function getArticleList() : array
    {
        return $this->articleList;
    }
    
    function totalPrice() : float
    {
        $total = 0;
        foreach($this->articleList as $article)
        {
            $total += $article->getPrice();
        }
        return $total;
    }
    function totalDelivery() : float
    {
        $total = 0;
        foreach($this->articleList as $article)
        {
            $total += $article->getDelivery();
        }
        return $total;
    }
    function getTotal() : float
    {
        return $this->totalDelivery() + $this->totalPrice();
    }

    function __toString()

    {
        $res =" </br> ";
        foreach($this->articles as $article)
        {
            $res .=$article ."</br>"; 
        }
        return $res;
    }
    function getPanier() : array
    {
        return $this->articles;
    }
}
<?php

abstract class Model{
    //Connexion à la base de donnée

    
    /**Renvoie la connexion à la base de données.
     * @return PDO 
     */
    public function getConnection() : PDO
    {
        return new PDO("","");
    }
}
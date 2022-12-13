<?php

class Model{
    private $db;
    
    public function __construct() {
        $this->setConnection();
    }

    /**
     * Set the connection to the database
     * @return void
     */
    public function setConnection() 
    {
        $host = 'localhost';
        $user ='Site' ;
        $pass = '#WebsiteAcces2022';
        $name = 'phpMerch';
        try{
            $this->db = new PDO("mysql:host=".$host.";dbname=".$name, $user, $pass);
        }
        catch(PDOException $e){
            throw Exception($e);
        }
    }
    /**
     * Renvoie la connexion à la base de données.
     * @return PDO 
     */
    protected function getConnection() : Object
    {
        return $this->db;
    }
}
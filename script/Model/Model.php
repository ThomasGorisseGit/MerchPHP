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
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, 
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, 
          ];
        $host = 'localhost';
        $user ='Site' ;
        $pass = '#WebsiteAcces2022';
        $name = 'phpMerch';
        try{
            $this->db = new PDO("mysql:host=".$host.";dbname=".$name, $user, $pass,$options);
        }
        catch(PDOException $e){
            error_log($e->getMessage());
            exit("Database can't load");
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
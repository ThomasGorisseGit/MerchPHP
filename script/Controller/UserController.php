<?php
include "./script/Model";
class UserController {
    private UserModel $model;

    public function __construct() 
    {

    }
    public function setModel(UserModel $userModel)
    {
        $this->model = $userModel;
    }
    public function getModel() : UserModel
    {
        return $this->model;
    }
    public function insertUser() : bool
    {
        if($this->checkUserNotInsert())
        {
            
            $name = $this->model->getNickname(); 
            $email = $this->model->getEmail();
            $hash = $this->model->getPassword();
            echo"as";
            /*
            $query = "INSERT INTO User(Nickname,Email,PasswordHash) VALUES :nickname , :email , :passwordhash";
           
            $sth = $this->model->getConnection()->prepare($query);
            echo"i";
            $result = $sth->execute(array(
                'nickname'=>$name,
                'email'=>$email,
                'passwordhash'=>$hash
            ));
            if($result) 
            {   
                echo"done";
                return true;
            }
        */
        echo"w";
            $q="INSERT INTO User VALUES (5,'$name','$email','$hash')"; 
            $db = $this->model->getConnection();
            echo",";
            $stmt = $db->query($q) ;
            echo"h";
            if($stmt)
            {
                echo"done";
            }   
            echo"non";
        }
        return false;
        

    }
    public function checkUserNotInsert() 
    {
        
        $name = $this->model->getNickname(); 
        $email = $this->model->getEmail();
        $db = $this->model->getConnection();
        $q = "SELECT * FROM User WHERE Nickname = :Nickname AND Email = :Email ";
        $stmt = $db->prepare($q)->execute(array(
            'Nickname'=>$name, 
            'Email'=>$email
        ));
        if($stmt)
        {
            return true;
        }
        return false;
    }
}
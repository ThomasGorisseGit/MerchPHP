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
            echo'in';
            echo $this->checkUserNotInsert();
            $name = $this->model->getNickname(); 
            $email = $this->model->getEmail();
            $hash = $this->model->getPassword();
            $q="INSERT INTO User VALUES (8,'$name','$email','$hash')"; 
            $db = $this->model->getConnection();
            $stmt = $db->query($q) ;
            if($stmt)
            {
                echo "insert";
                return true;
            }   
        }
        echo "already exist";
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
       // TODO : Fetch data
        if($stmt->num_rows==0)
        {
            return true;
        }
        return false;
    }

}
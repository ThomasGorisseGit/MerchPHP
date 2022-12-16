<?php 

require "./script/Model/Model.php";



class UserModel extends Model{
    private string $nickname;
    private string $email;
    private string $password;
    public function __construct(string $name, string $email, string $password)
    {
        parent::__construct();
        $this->nickname = $name;
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }
    public function getNickname() : string 
    {
        return $this->nickname;
    }
    public function getEmail() : string  
    {
        return $this->email;
    }   
    public function getPassword() : string
    {
        return $this->password;
    }
    public function getConnection() : Object
    {
        return parent::getConnection();
    }
    public function __toString() : string
    {
        return $this->nickname . " " . $this->email . " " . $this->password;
    }

}
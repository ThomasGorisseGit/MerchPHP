<?php 

include __DIR__ . "/Model.php";



class UserModel extends Model{
    private string $nickname;
    private string $email;
    private string $password;
    public function __construct(string $n, string $email, string $password)
    {
        parent::__construct();
        $this->nickname = $n;
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }
    public function getNickname() : string 
    {
        return $this->getNickname;
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
        return $this->parent::getConnection();
    }
}
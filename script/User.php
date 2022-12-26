<?php
class User{
    
    private string $name;
    private string $email;
    private string $password;


    function __construct(string $name, string $email, string $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    function __toString() : string
    {
        return "name : $this->name ; email : $this->email ; password : $this->password ";
    }

    
}
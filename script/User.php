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
    function addUser(PDO $db) : bool
    {
        if($this->validateUser($db))
        {
            $query = 'INSERT INTO User(name,email,password) VALUES (?,?,?)';
            $stmt = $db->prepare($query);
            $stmt->execute(array(
                $this->name,
                $this->email,
                $this->password
            ));

            return true;
        }
        return false;
    }
    function validateUser(PDO $db) : bool
    {
        $query = "SELECT * FROM User WHERE email = ?";
        $stmt = $db->prepare($query);
        $stmt->execute(array($this->email));
        if($stmt->rowCount() == 0)
        {
            return true;
        }
        echo "Cet adresse email possède déjà un compte. </br>";
        return false;

    }
    function startUserSession() 
    {
        $_SESSION["name"] = $this->name;
        $_SESSION["email"] = $this->email;
        $_SESSION["password"] = $this->password;
    }
    function rememberMe()
    {
        $name = $this->name;
        $email = $this->email;
        $password = $this->password;
        setcookie("name",$name,time() * 60 * 60);
        setcookie("email",$email ,time() * 60 * 60);
        setcookie("password",$password,time() * 60 * 60);
    }

}
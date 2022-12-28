<?php
session_start();
class User{
    
    private string $name;
    private string $email;
    private string $password;
    private string $image;

    function __construct(string $name, string $email, string $password)
    {
        $this->image = "/assets/profilePictures/default.png";
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }
    function getUserInfos(PDO $db)
    {
        $query = "SELECT * FROM User WHERE email = ?";
        $stmt = $db->prepare($query);
        $stmt->execute(array($this->email));
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if(password_verify($this->password,$data["password"]))
        {
            $this->password = $data["password"];
            $this->name = $data["name"];
            return true;
        }
        return false;

    }
    function hashPassword() 
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
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
        die("Cet adresse email possède déjà un compte. </br>");
        return false;

    }
    function startUserSession() 
    {
        $_SESSION["name"] = $this->name;
        $_SESSION["email"] = $this->email;
        $_SESSION["password"] = $this->password;
        $_SESSION["image"] = $this->image;
    }
    function rememberMe()
    {
        $name = $this->name;
        $email = $this->email;
        $password = $this->password;
        $image = $this->image;
        setcookie("name",$name,time() * 60 * 60);
        setcookie("email",$email ,time() * 60 * 60);
        setcookie("password",$password,time() * 60 * 60);
        setcookie("password",$image,time() * 60 * 60);
    }
    function setName(string $name) 
    {
        $this->name=$name;
    }
    function setEmail(string $email) 
    {
        $this->email=$email;
    }
    function setPassword(string $password) 
    {
        $this->password=$password;
    }
    function changeUserInfo(int $id, PDO $db) : bool
    {
        $query = "UPDATE User SET name = ? , email = ? , password = ? WHERE id = ?";
        $stmt = $db->prepare($query);
        if($stmt->execute(array(
            $this->name,
            $this->email,
            $this->password,
            $id
        )))
        {
            return true;
        }
        
        return false;
    }
}
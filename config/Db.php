<?php

class Db 
{
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $database = "novelnest";
    public $con;
    
    function connect()
    {
        $this->con = new mysqli($this->host,$this->user,$this->password,$this->database);

        if($this->con->connect_error)
        {
            die("Database is not connected");
        }
        return $this->con;
    }

} 

?>

<?php

namespace app\classes;

class Database
{
    //propriedade estatica que é a instancia do PDO
    public static $PDO;
    
    public function __construct(){

    }

    //método que instancia o pdo e adiciona a propriedade estática da classe
    public function connection(string $database){
        try{
            self::$PDO = new \PDO("mysql:dbname=".$database.";host=localhost", "root", "");
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
}
<?php

namespace app\classes;
use app\classes\Database;

class Auth
{
    public function __construct(){
        session_start();
    }

    public function restringirAcessoLogado() : void{
        if(isset($_SESSION['email-usuario'])){
            header("Location: panel.php");
        }
    }

    public function restringirAcessoDeslogado() : void{
        if(!isset($_SESSION['email-usuario'])){
            header("Location: index.php");
        }
    }
}
<?php
namespace app\traits;

//trait usada pra validar dados recebidos pelo usuário
trait AuthUser
{
    //método que valida email passado pelo usuário
    public function AuthEmail(string $email) : bool{
        $bool = filter_var($email, FILTER_VALIDATE_EMAIL) ? true : false;
        return $bool;
    }

    //método que valida a senha passada pelo usuário (se tem os critérios mínimos)
    public function AuthPass(string $pass) : bool{
        $bool = mb_strlen($pass) >= 10 ? true : false;
        return $bool;
    }

    //método que valida a confirmacao da senha passada pelo usuário (verifica se é igual a senha)
    public function AuthPassRegister(string $pass, string $passConfirmation) : bool{
        $bool = $pass === $passConfirmation ? true : false;
        return $bool;
    }

    //método que valida o nome do usuário
    public function AuthName(string $name) : bool{
        //nome não é um espaço vazio
        $bool1 = $name === "" ? false : true;
        //nome tem no mínimo 4 caracteres
        $bool2 = mb_strlen($name) >= 4 ? true : false;
        //nome é alfanumerico (só letras e/ou números)
        $bool3 = preg_match('/[^a-zA-Z0-9 \p{L}]/u', $name) ? false : true;

        //se alguma das validações for falsa, retorna falso
        if($bool1 == false || $bool2 == false || $bool3 == false){
            return false;
        }
        return true;
    }
}
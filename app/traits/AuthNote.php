<?php
namespace app\traits;

//trait que valida dados de uma nota enviada pelo usuário
trait AuthNote
{
    public function AuthTitle(string $title) : bool{
        //expressão regular (inclui todas as letras com e sem acentos e nº)
        $bool = preg_match('/[^a-zA-Z0-9 -\p{L}]/u', $title) ? false : true;
        return $bool; 
    }

    public function AuthContent(string $content) : bool{
        //expressão regular (inclui todas as letras com e sem acentos e nº)
        $bool = preg_match('/[^a-zA-Z0-9 -\p{L}]/u', $content) ? false : true;
        return $bool;
    }
}
<?php
    date_default_timezone_set('America/Sao_Paulo'); 
    include_once("../db/conexao.php");
    include_once("../db/database.php");
    function corrigirQuebraLinha($text){
        $quebralinha = array("\r\n", "\n");
        return str_replace($quebralinha, '<br />', $text);
    }

    function corrigirAspas($text){
        return str_replace('\'', '\\\'', str_replace('\"', '\\"', $text));
    }

?>
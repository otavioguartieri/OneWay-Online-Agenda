<?php
include_once("../libs/globals.php");
if ($_REQUEST['action'] ?? ''){
    switch(($_REQUEST['action'] ?? '')){
        case 'send':
            $newmessage = $conn->query("SELECT dados FROM chat WHERE id = '" . $_REQUEST['idconversa'] . "'");
            $mensagemArrayNew = array(
                    "id"=>$_REQUEST['idMensagem'], 
                    "created"=>strtotime('now'), 
                    "message"=>corrigirQuebraLinha(corrigirAspas(($_REQUEST['mensagem'] ?? ''))),
                    "type"=>($_REQUEST['type'] ?? 'text'),
                    "user"=>($_REQUEST['user'] ?? '0'),
                    "visualized"=>($_REQUEST['visualized'] ?? '0'),
                );

            if (mysqli_num_rows($newmessage) > 0) {

                $row = $newmessage->fetch_array(MYSQLI_BOTH);
                $mensagemArray = json_decode($row['dados'],true);
                $mensagemArray[] = $mensagemArrayNew;

                $newmessage = $conn->query("UPDATE chat SET dados = '".json_encode(array_values($mensagemArray))."' WHERE id = '" . $_REQUEST['idconversa'] . "'");
            }else{
                $mensagemArray = [];
                $mensagemArray[] = $mensagemArrayNew;
                $newmessage = $conn->query("INSERT INTO chat (users,dados,inclusao) VALUES ('".($_REQUEST['user'] ?? '0')."','".json_encode(array_values($mensagemArray))."','".strtotime('now')."')");
            }
        break;
    } 
}

$getresponse = $conn->query("SELECT dados FROM chat WHERE `id` = '" . $_REQUEST['idconversa'] . "'");
if (mysqli_num_rows($getresponse) > 0) {
    $row = $getresponse->fetch_array(MYSQLI_BOTH);
    exit(json_encode([
        'data' => array_values(json_decode($row['dados'],true)),
        'result'=>'1',
        'header'=>header('Content-Type: application/json')
    ]));
}else{
    exit(json_encode([
        'data' => [],
        'result'=>'-1',
        'header'=>header('Content-Type: application/json')
    ]));
}

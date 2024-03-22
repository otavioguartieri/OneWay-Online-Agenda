<?php
include_once("../libs/globals.php");
if ($_REQUEST['action'] ?? ''){
    switch(($_REQUEST['action'] ?? '')){
        case 'send':

            $note = $conn->query("SELECT id FROM notes WHERE id = '" . $_REQUEST['id'] . "'");
            if (mysqli_num_rows($note) > 0) {
                $note = $conn->query("UPDATE notes SET data = '" . $_REQUEST['data'] . "' WHERE id = '" . $_REQUEST['id'] . "'");
            }else{
                $note = $conn->query("INSERT INTO notes (title,data,created) VALUES ('".($_REQUEST['title'] ?? '0')."','".($_REQUEST['data'] ?? '0')."','".strtotime('now')."')");
            }
        break;
        case 'get':
            $row = $conn->query("SELECT title, data FROM notes WHERE `id` = '" . $_REQUEST['id'] . "'");
            $response = $row->fetch_array();
            if ($response > 0) {
                exit(json_encode([
                    'data' => $response,
                    'type'=>'get',
                    'result'=>'1',
                    'header'=>header('Content-Type: application/json')
                ]));
            }else{
                exit(json_encode([
                    'data' => [],
                    'type'=>'get',
                    'result'=>'-1',
                    'header'=>header('Content-Type: application/json')
                ]));
            }
        break;
        case 'list':
            $list = $conn->query("SELECT * FROM notes WHERE `active` = '1'");
            $rows = array();
            if ($list->num_rows > 0) {
                // Exibe os dados de cada linha
                while($row = $list->fetch_assoc()) {
                    // Adiciona os dados da linha ao array $rows
                    $rows[] = $row;
                }
                exit(json_encode([
                    'data' => $rows,
                    'type'=>'list',
                    'result'=>'1',
                    'header'=>header('Content-Type: application/json')
                ]));
            }else{
                exit(json_encode([
                    'data' => [],
                    'type'=>'list',
                    'result'=>'-1',
                    'header'=>header('Content-Type: application/json')
                ]));
            }
        break;
        case 'create':
            $create = $conn->query("INSERT INTO notes (title,data,created) VALUES ('".($_REQUEST['title'] ?? "Nova anotação")."','','".strtotime('now')."')");
            $row = $conn->query("SELECT * FROM notes WHERE `id` = '" . $conn->insert_id . "'");
            $response = $row->fetch_array();
            if ($response >= 0) {
                exit(json_encode([
                    'data' => $response,
                    'type'=>'create',
                    'result'=>'1',
                    'header'=>header('Content-Type: application/json')
                ]));
            }else{
                exit(json_encode([
                    'data' => [],
                    'type'=>'create',
                    'result'=>'-1',
                    'header'=>header('Content-Type: application/json')
                ]));
            }
        break;
    } 
}
/* 
$getresponse = $conn->query("SELECT * FROM notes WHERE `id` = '" . $_REQUEST['id'] . "'");
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
} */

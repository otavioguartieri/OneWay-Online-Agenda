<?php
    $reg = json_decode(file_get_contents("../notes/".$_REQUEST['id']."/content.txt"),true);
    exit(json_encode([
        'data' => $reg,
        'result'=>'1',
        'header'=>header('Content-Type: application/json')
    ]));
?>
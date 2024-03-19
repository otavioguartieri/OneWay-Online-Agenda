<?php
    mkdir("notes/".$_REQUEST['id']."/", 0777, true);
    $reg = json_decode(file_get_contents("notes/".$_REQUEST['id']."/content.txt"),true);
    $reg['note_content'] = '';
    $reg['note_launch'] = 1;
    file_put_contents("notes/".$_REQUEST['id']."/content.txt", json_encode($reg, JSON_PRETTY_PRINT));
?>
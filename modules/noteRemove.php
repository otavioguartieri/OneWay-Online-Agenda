<?php
    $reg = json_decode(file_get_contents("../notes/".$_REQUEST['id']."/config.txt"),true);
    $reg['note_launch'] = 0;
    file_put_contents("../notes/".$_REQUEST['id']."/config.txt", json_encode($reg, JSON_PRETTY_PRINT));
?>
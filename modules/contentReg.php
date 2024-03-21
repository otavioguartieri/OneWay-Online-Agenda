<?php
    $reg = json_decode(file_get_contents("../notes/".$_REQUEST['id']."/content.txt"),true);
    $reg['note_content'] = ($_REQUEST['change']);
    file_put_contents("../notes/".$_REQUEST['id']."/content.txt", json_encode($reg, JSON_PRETTY_PRINT));
?>
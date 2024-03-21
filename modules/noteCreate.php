<?php
    $log = json_decode(file_get_contents("log.txt"),true);
    $noteId = $log['autoIncrementId'];
    $log['autoIncrementId'] = $log['autoIncrementId'] + 1;
    file_put_contents("log.txt", json_encode($log, JSON_PRETTY_PRINT));
    $path = "../notes/".$noteId."/";

    mkdir($path, 0777, true);

    $content = json_decode(file_get_contents($path."content.txt"),true);
    $content['note_content'] = "";
    file_put_contents($path."content.txt", json_encode($content, JSON_PRETTY_PRINT));
    
    $config = json_decode(file_get_contents($path."config.txt"),true);
    $config['note_launch'] = 1;
    $config['note_id'] = $noteId;
    $config['note_title'] = substr($noteId,0,10);

    file_put_contents($path."config.txt", json_encode($config, JSON_PRETTY_PRINT));
?>
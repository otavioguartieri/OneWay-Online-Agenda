<?php
    $notesfolder = "notes/";
    $reg = []; /* create new array for the apps */
    $notes = scandir($notesfolder); /* search for folders somewhere */
    array_shift($notes); /* remove the first "." from array (trash) */
    array_shift($notes); /* remove the second ".." from array (trash) */

    foreach($notes as $k => $v){ /* $k is the key from array ex: [0] $v is the value... lol */

        $reg[$k][1] = json_decode(file_get_contents($notesfolder.$v."/content.txt"),true);

        if($reg[$k][1]['note_launch'] == true){

            if($reg[$k][1]['note_id'] == null)
                $reg[$k][1]['note_id'] = md5($v.$reg[$k][0]);

            if($reg[$k][1]['note_title'] == null)
                $reg[$k][1]['note_title'] = md5($v.$reg[$k][0]);

            file_put_contents($notesfolder.$v."/content.txt", json_encode($reg[$k][1], JSON_PRETTY_PRINT));
        }

        /* defines the value [0] w/ the folder name */
        $reg[$k][0] = $v;
    }
    
    exit(json_encode([
        'data' => $reg,
        'result'=>'1',
        'header'=>header('Content-Type: application/json')
    ]));
?>
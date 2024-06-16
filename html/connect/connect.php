<?php
    $host = "localhost";
    $user = "wlsdks";
    $pw = "wlsdk9916v#";
    $db = "wlsdks";

    $connect = new mysqli($host, $user, $pw, $db);
    $connect -> set_charset("utf-8");

    if($connect->connect_error){
        echo "Connect Failed" . $connect->connect_error;
    }
?>

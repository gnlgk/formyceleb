<?php
    include "../connect/connect.php";
    $sql = "CREATE TABLE board(";
    $sql .= "boardID int(10) UNSIGNED AUTO_INCREMENT,";
    $sql .= "memberID int(10) NOT NULL,";
    $sql .= "boardTitle varchar(100) NOT NULL,";
    $sql .= "boardContents longtext NOT NULL,";
    $sql .= "boardView int(10) DEFAULT 1,";
    $sql .= "boardDelete int(10) DEFAULT 1,";
    $sql .= "regTime int(40) NOT NULL,";
    $sql .= "PRIMARY KEY(boardID)";
    $sql .= ") CHARSET=utf8";
    $connect -> query($sql);
?>
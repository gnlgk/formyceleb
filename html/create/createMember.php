<?php
    include "../connect/connect.php";
    $sql = "CREATE TABLE members(";
    $sql .= "memberID int(10) UNSIGNED AUTO_INCREMENT,";
    $sql .= "youID varchar(40) NOT NULL UNIQUE,";
    $sql .= "youEmail varchar(40) NOT NULL,";
    $sql .= "youPass varchar(255) NOT NULL,";
    $sql .= "profile_image VARCHAR(100) DEFAULT 'default',";
    $sql .= "regTime int(11) NOT NULL,"; 
    $sql .= "tokenReset varchar(255) DEFAULT NULL,";
    $sql .= "tokenExpiry datetime DEFAULT NULL,";
    $sql .= "PRIMARY KEY(memberID)";
    $sql .= ") DEFAULT CHARSET=utf8";
    $result = $connect -> query($sql);
?>
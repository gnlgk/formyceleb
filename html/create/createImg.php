<?php
    include "../connect/connect.php";
    $sql = "CREATE TABLE photos(";
    $sql .= "imgID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,";
    $sql .= "image_url VARCHAR(255) NOT NULL";
    $sql .= ") DEFAULT CHARSET=utf8";

    if ($connect -> query($sql) === TRUE) {
        echo "Table 'photos' created successfully.";
    } else {
        echo "Error creating table: " . $connect->error;
    }

    $connect -> query($sql);
?>

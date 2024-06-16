<?php
include "../connect/connect.php";

$sql = "CREATE TABLE comments (
    commentID INT AUTO_INCREMENT PRIMARY KEY,
    imgID INT NOT NULL,
    memberID INT NOT NULL,
    commentText TEXT NOT NULL,
    regTime TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (imgID) REFERENCES photos(imgID),
    FOREIGN KEY (memberID) REFERENCES members(memberID)
) DEFAULT CHARSET=utf8";

$result = $connect->query($sql);

if ($result === TRUE) {
    echo "Table 'comments' created successfully";
} else {
    echo "Error creating table: " . $connect->error;
}

$connect->close();
?>

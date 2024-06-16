<?php
include "../connect/connect.php";

$sql = "SELECT image_url FROM photos ORDER BY RAND() LIMIT 10"; // 이미지 테이블과 컬럼 이름에 맞게 수정해주세요.
$result = $connect->query($sql);

$images = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $images[] = $row['image_url'];
    }
}

echo json_encode($images);
?>

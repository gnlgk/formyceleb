<?php
include "../connect/connect.php"; 

$userId = mysqli_real_escape_string($connect, $_POST['register-user']);

$sql = "SELECT youID FROM members WHERE youID = '$userId'";
$result = $connect->query($sql);

if ($result->num_rows > 0) {
    echo "이미 사용중인 아이디입니다.";
} else {
    echo "사용 가능한 아이디입니다.";
}

mysqli_close($connect);
?>

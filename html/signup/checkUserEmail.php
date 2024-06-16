<?php
include "../connect/connect.php"; 

$userEmail = mysqli_real_escape_string($connect, $_POST['register-email']);

$sql = "SELECT youEmail FROM members WHERE youEmail = '$userEmail'";
$result = $connect->query($sql);

if ($result->num_rows > 0) {
    echo "이미 사용중인 이메일입니다.";
} else {
    echo "사용 가능한 이메일입니다.";
}

mysqli_close($connect);
?>

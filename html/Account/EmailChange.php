<?php
include "../connect/connect.php";
include "../connect/session.php";

header('Content-Type: application/json');

$memberID = $_SESSION['memberID'];
$newEmail = mysqli_real_escape_string($connect, $_POST['newEmail']);
$password = mysqli_real_escape_string($connect, $_POST['password']);


$sql = "SELECT youPass FROM members WHERE memberID = '$memberID'";
$result = $connect->query($sql);
$row = $result->fetch_assoc();

if (password_verify($password, $row['youPass'])) {
    
    $sql = "UPDATE members SET youEmail = '$newEmail' WHERE memberID = '$memberID'";
    if ($connect->query($sql) === TRUE) {
        $_SESSION['youEmail'] = $newEmail;
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => '이메일 변경에 실패했습니다.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => '비밀번호가 일치하지 않습니다.']);
}

$connect->close();
?>

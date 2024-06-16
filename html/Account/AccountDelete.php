<?php
include "../connect/connect.php";
include "../connect/session.php";

header('Content-Type: application/json');

$memberID = $_SESSION['memberID'];
$password = mysqli_real_escape_string($connect, $_POST['password']);


$sql = "SELECT youPass FROM members WHERE memberID = '$memberID'";
$result = $connect->query($sql);
$row = $result->fetch_assoc();

if (password_verify($password, $row['youPass'])) {

    $sql = "DELETE FROM members WHERE memberID = '$memberID'";
    if ($connect->query($sql) === TRUE) {
        session_destroy();
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => '계정 삭제에 실패했습니다.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => '비밀번호가 일치하지 않습니다.']);
}

$connect->close();
?>

<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include "../connect/connect.php";

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userEmail = $_POST['youEmail'];

    // 디버깅: 입력된 데이터 출력
    error_log("DEBUG: Received userEmail = $userEmail");

    $sql = "SELECT youID FROM members WHERE youEmail=?";
    $stmt = $connect->prepare($sql);
    if ($stmt === false) {
        $response['status'] = 'error';
        $response['message'] = 'SQL prepare failed: ' . $connect->error;
        error_log("DEBUG: SQL prepare failed: " . $connect->error);
    } else {
        $stmt->bind_param("s", $userEmail);

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $response['status'] = 'success';
            $response['username'] = $row['youID'];
        } else {
            $response['status'] = 'error';
            $response['message'] = '해당 이메일로 등록된 아이디가 없습니다.';
            error_log("DEBUG: 해당 이메일로 등록된 아이디가 없습니다.");
        }

        $stmt->close();
    }
} else {
    $response['status'] = 'error';
    $response['message'] = '잘못된 요청입니다.';
    error_log("DEBUG: 잘못된 요청입니다.");
}

$connect->close();

header('Content-Type: application/json');
echo json_encode($response);
?>

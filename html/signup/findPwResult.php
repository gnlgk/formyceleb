<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include "../connect/connect.php";

require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';
require '../PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = $_POST['youID'];
    $userEmail = $_POST['youEmail'];

    // 디버깅: 입력된 데이터 출력
    error_log("DEBUG: Received userID = $userID, userEmail = $userEmail");

    $sql = "SELECT * FROM members WHERE youID=? AND youEmail=?";
    $stmt = $connect->prepare($sql);
    if ($stmt === false) {
        $response['status'] = 'error';
        $response['message'] = 'SQL prepare failed: ' . $connect->error;
        error_log("DEBUG: SQL prepare failed: " . $connect->error);
    } else {
        $stmt->bind_param("ss", $userID, $userEmail);

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $token = bin2hex(random_bytes(50));
            $expiry = date("Y-m-d H:i:s", strtotime('+1 hour'));

            $update_sql = "UPDATE members SET tokenReset=?, tokenExpiry=? WHERE youID=? AND youEmail=?";
            $update_stmt = $connect->prepare($update_sql);
            if ($update_stmt === false) {
                $response['status'] = 'error';
                $response['message'] = 'Update SQL prepare failed: ' . $connect->error;
                error_log("DEBUG: Update SQL prepare failed: " . $connect->error);
            } else {
                $update_stmt->bind_param("ssss", $token, $expiry, $userID, $userEmail);
                $update_stmt->execute();

                $resetLink = "http://ssm971213.dothome.co.kr/signup/resetPw.php?token=$token";
                $subject = "[formyceleb]비밀번호 재설정의 건";
                $message = "비밀번호를 재설정하려면 다음 링크를 클릭하세요: $resetLink";

                $mail = new PHPMailer(true);
                try {
                    // 서버 설정
                    $mail->isSMTP();
                    $mail->Host = 'smtp.naver.com';
                    $mail->Port = 465;
                    $mail->SMTPSecure = 'ssl';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'ssm971213'; // 네이버 이메일 계정
                    $mail->Password = '101212s'; // 네이버 이메일 비밀번호
                    $mail->CharSet = 'UTF-8';

                    // 발신자 정보
                    $mail->setFrom('ssm971213@naver.com', 'formyceleb 관리자');
                    $mail->addReplyTo('ssm971213@naver.com', 'formyceleb 관리자');
                    $mail->addAddress($userEmail, $userID); // 수신자

                    // 콘텐츠 설정
                    $mail->isHTML(true);
                    $mail->Subject = $subject;
                    $mail->Body = $message;

                    $mail->send();
                    $response['status'] = 'success';
                    $response['message'] = '비밀번호 재설정 이메일이 전송되었습니다.';
                } catch (Exception $e) {
                    $response['status'] = 'error';
                    $response['message'] = "이메일 전송에 실패했습니다. 메일러 오류: {$mail->ErrorInfo}";
                    error_log("DEBUG: 이메일 전송에 실패했습니다. 메일러 오류: {$mail->ErrorInfo}");
                }
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = '해당 아이디와 이메일이 존재하지 않습니다.';
            error_log("DEBUG: 해당 아이디와 이메일이 존재하지 않습니다.");
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

<?php
require 'src/PHPMailer.php';
require 'src/SMTP.php';
require 'src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);
// if ($result) {
//     $count = $result->num_rows;
//     if ($count == 0) {
//         $jsonResult = "not_found";
//     } else {
        function generateRandomCode($length = 6) {
            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            $charactersLength = strlen($characters);
            $randomCode = '';
            for ($i = 0; $i < $length; $i++) {
                $randomCode .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomCode;
        }
        $randomCode = generateRandomCode();
        date_default_timezone_set('Asia/Seoul');
        $mail = new PHPMailer;
        $mail->SMTPSecure = 'ssl';
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Debugoutput = 'html';
        $mail->Host = 'smtp.naver.com';
        $mail->Port = 465;
        $mail->SMTPAuth = true;
        $mail->Username = "ssm971213";
        $mail->Password = "101212s";
        $mail->setFrom('ssm971213@naver.com', 'picker');      // 보내는 사람
        $mail->addReplyTo('ssm971213@naver.com', 'picker');   //수신받을 이름
        $mail->addAddress($youEamil, $youName);
        $mail->Subject = '[PICKSTOM] 비밀번호 재설정 코드';
        $mail->CharSet = 'UTF-8';
        $mail->msgHTML("<html><body>안녕하세요 [PICKSTOM] 관리자 픽커 입니다. 귀하의 비밀번호 재설정을 위해 보안코드를 발송해드립니다.<br> 코드: <b>".$randomCode."</b><br>주의: 대소문자를 구분해 입력해주세요.</body></html>", dirname(__FILE__));
        $mail->AltBody = "안녕하세요 [PICKSTOM] 관리자 픽커 입니다. 귀하의 비밀번호 재설정을 위해 보안코드를 발송해드립니다. 코드: ".$randomCode."\n주의: 대소문자를 구분해 입력해주세요.";
        if (!$mail->send()) {
            $jsonResult = "email_error";
        } else {
            $jsonResult = "success";
        }

//     }
// } else {
//     $jsonResult = "error";
// }
?>
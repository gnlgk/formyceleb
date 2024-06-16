<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include "../connect/connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $newPassword = $_POST['youPass'];

    // 새로운 비밀번호 해시
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // 디버깅: SQL 쿼리와 prepare 실패 이유 출력
    $sql = "UPDATE members SET youPass=?, tokenReset=NULL, tokenExpiry=NULL WHERE tokenReset=?";
    $stmt = $connect->prepare($sql);
    if ($stmt === false) {
        die('SQL prepare failed: ' . $connect->error);
    }

    $stmt->bind_param("ss", $hashedPassword, $token);

    if ($stmt->execute()) {
        echo "<script>alert('비밀번호가 성공적으로 변경되었습니다.');</script>";
    } else {
        echo "<script>alert('비밀번호 변경에 실패했습니다.');</script>";
    }

    $stmt->close();
    $connect->close();
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include "../include/head.php"; ?>
</head>
<body>
<div class="reset-wrap">
    <div class="reset-html">
        <button class="close">✕</button>
        <div class="reset-form">
            <!-- 비밀번호 재설정 폼 -->
            <form action="resetPw.php" method="post" class="reset-up__htm">
                <div class="logo">• formyceleb •</div>
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
                <div class="group">
                    <label for="reset__Pass" class="label"></label>
                    <input id="reset__Pass" name="youPass" type="password" class="input" placeholder="새로운 비밀번호" autocomplete="off">
                </div>
                <div class="group">
                    <label for="password__confirm" class="label"></label>
                    <input id="password__confirm" name="password_confirm" type="password" class="input" placeholder="비밀번호 확인" autocomplete="off">
                </div>
                <div class="group">
                    <input type="submit" class="button" value="비밀번호 변경">
                </div>
                <div class="foot-lnk">
                    <a href="http://ssm971213.dothome.co.kr/">메인으로</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>

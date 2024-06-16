<?php
    include "../connect/connect.php";  // 데이터베이스 연결 설정 파일

    // 폼 데이터 수집
    $youID = mysqli_real_escape_string($connect, $_POST['youID']);
    $youPass = mysqli_real_escape_string($connect, $_POST['youPass']);
    $password_confirm = mysqli_real_escape_string($connect, $_POST['password_confirm']);
    $youEmail = mysqli_real_escape_string($connect, $_POST['youEmail']);

    // 비밀번호 일치 확인
    if ($youPass !== $password_confirm) {
        echo "<script>
                alert('비밀번호가 일치하지 않습니다.');
                history.back();
              </script>";
        exit;
    }

    // 비밀번호 해싱
    $hashedPassword = password_hash($youPass, PASSWORD_DEFAULT);

    // 회원가입 시각
    $regTime = time();

    $defaultImage = "../coding/assets/uploads/default.png";

    // 쿼리: 회원 데이터 삽입
    $sql = "INSERT INTO members (youID, youPass, youEmail, profile_image, regTime) VALUES ('$youID', '$hashedPassword', '$youEmail', '$defaultImage','$regTime')";

    $result = $connect->query($sql);

    // 쿼리 실행 결과 확인
    if ($result) {
        echo "<script>
                alert('회원 가입이 성공적으로 완료되었습니다.');
                history.back();
              </script>";
    } else {
        echo "<script>
                alert('회원 가입에 실패했습니다: " . $connect->error . "');
                history.back();
              </script>";
    }

    // 데이터베이스 연결 해제
    mysqli_close($connect);
?>



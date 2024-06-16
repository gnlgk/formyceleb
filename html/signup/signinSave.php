<?php
    include "../connect/connect.php";
    include "../connect/session.php";  // 세션 관리 파일 포함

    // 폼 데이터 수집
    $youID = mysqli_real_escape_string($connect, $_POST['youID']);
    $youPass = mysqli_real_escape_string($connect, $_POST['youPass']);

    // SQL 쿼리: 사용자 정보 조회
    $sql = "SELECT memberID, youID, youPass FROM members WHERE youID = '$youID'";
    $result = $connect->query($sql);

    if($result){
        $count = $result->num_rows;

        if($count == 0){
            // 사용자의 ID가 존재하지 않는 경우
            echo "<script>alert('정보를 찾을 수 없습니다. 회원가입을 해주세요!');</script>";
            echo "<script>history.back();</script>";
        } else {
            $memberInfo = $result->fetch_array(MYSQLI_ASSOC);

            if(password_verify($youPass, $memberInfo['youPass'])){
                // 로그인 성공, 세션 설정
                $_SESSION['memberID'] = $memberInfo['memberID'];
                $_SESSION['youID'] = $memberInfo['youID'];
         
                echo "<script>alert('로그인 성공');</script>";
                echo "<script>window.location.href = '../index.php';</script>";

            } else {
                // 비밀번호가 일치하지 않는 경우
                echo "<script>alert('아이디 또는 비밀번호가 잘못되었습니다.');</script>";
                echo "<script>window.history.back();</script>";
            }
        }
    } else {
        // SQL 실행 오류
        echo "<script>alert('로그인 처리 중 오류가 발생했습니다.');</script>";
        echo "<script>history.back();</script>";
    }
?>

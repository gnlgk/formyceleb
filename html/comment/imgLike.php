<?php
    include "../connect/connect.php";
    include "../connect/session.php";
    
    if (!isset($_SESSION['memberID'])) {
        echo json_encode(['status' => 'error', 'message' => '로그인이 필요합니다.']);
        exit;
    }

    $memberID = $_SESSION['memberID'];
    $imgID = $_POST['imgID'];

    // 좋아요 상태 확인
    $sql = "SELECT * FROM blogLike WHERE memberID = {$memberID} AND imgID = {$imgID}";
    $result = $connect -> query($sql);

    if ($result -> num_rows > 0) {
        // 이미 좋아요를 누른 경우 좋아요 취소
        $sql = "DELETE FROM blogLike WHERE memberID = {$memberID} AND imgID = {$imgID}";

        //조회수 증가 -1
        // $updateSql = "UPDATE blog SET blogLike = blogLike - 1 WHERE imgID = {$imgID}";
    } else {
        // 좋아요를 누르지 않은 경우 좋아요 추가
        $sql = "INSERT INTO blogLike (imgID, memberID) VALUES ({$imgID}, {$memberID})";

        //조회수 증가 +1
        // $updateSql = "UPDATE blog SET blogLike = blogLike + 1 WHERE imgID = {$imgID}";
    }

    if ($connect -> query($sql) === TRUE) {
        // 좋아요 수 계산
        $sql = "SELECT COUNT(*) AS likeCount FROM blogLike WHERE imgID = {$imgID}";
        $result = $connect -> query($sql);
        $row = $result -> fetch_assoc();
        $likeCount = $row['likeCount'];
        echo json_encode(['status' => 'success', 'likeCount' => $likeCount]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'DB 처리 실패']);
    }

    $connect -> close();
?>
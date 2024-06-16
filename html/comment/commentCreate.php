<?php
include "../connect/connect.php";
include "../connect/session.php";

header('Content-Type: application/json');

// 폼 데이터 가져오기
$commentText = $_POST['commentText'];
$memberID = $_SESSION['memberID']; // 로그인된 사용자의 ID를 받아와야 합니다
$imgID = $_POST['imgID'];

// echo "<pre>";
// var_dump($memberID);
// echo "</pre>";
// 현재 시간 가져오기
$regTime = date('Y-m-d H:i:s');

// 입력 데이터 검증
if (!empty($commentText) && !empty($memberID) && !empty($imgID)) {
    // 댓글 저장을 위한 SQL 쿼리 작성
    $sql = "INSERT INTO comments (imgID, memberID, commentText, regTime) VALUES (?, ?, ?, ?)";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("iiss", $imgID, $memberID, $commentText, $regTime);

    // 쿼리 실행 및 결과 확인
    if ($stmt->execute()) {
        // imgID에 맞는 imgURL을 photos에서 가져오기 위한 쿼리
        $sql = "SELECT image_url FROM photos WHERE imgID=?";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("i", $imgID);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $imageURL = $row['image_url'];
            $encodedImageURL = base64_encode($imageURL);
            // 작성된 댓글 정보 반환
            echo json_encode([
                'status' => 'success',
                'commentText' => $commentText,
                'youID' => $_SESSION['youID'],
                'regTime' => date('Y.m.d H:i', strtotime($regTime)),
                'commentID' => $stmt->insert_id, // 새로 추가된 댓글 ID 반환
                'imageURL' => $encodedImageURL
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => '이미지 경로를 찾을 수 없습니다.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => '댓글 작성에 실패했습니다.']);
    }
    // 스테이트먼트 닫기
    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => '로그인이 필요합니다.']);
}

// 데이터베이스 연결 종료
$connect->close();
?>
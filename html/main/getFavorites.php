<?php
include "../connect/connect.php";
include "../connect/session.php";

header('Content-Type: application/json');

if (isset($_SESSION['memberID'])) {
    $memberID = $_SESSION['memberID'];

    $sql = "SELECT p.image_url FROM photos p 
            JOIN blogLike b ON p.imgID = b.imgID 
            WHERE b.memberID = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("i", $memberID);
    $stmt->execute();
    $result = $stmt->get_result();

    $photos = [];
    while ($row = $result->fetch_assoc()) {
        $photos[] = ['image_url' => $row['image_url']];
    }

    echo json_encode(['status' => 'success', 'photos' => $photos]);
} else {
    echo json_encode(['status' => 'error', 'message' => '로그인이 필요합니다.']);
}
?>
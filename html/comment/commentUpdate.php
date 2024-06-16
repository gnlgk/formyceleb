<?php
    include "../connect/connect.php";
    include "../connect/session.php";
    include "../connect/sessionCheck.php";

    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_SESSION['memberID']) && isset($_POST['commentID']) && isset($_POST['commentText'])) {
            $memberID = $_SESSION['memberID'];
            $commentID = intval($_POST['commentID']);
            $commentText = trim($_POST['commentText']);

            // 댓글 소유자인지 확인
            $sql = "SELECT memberID FROM comments WHERE commentID = ?";
            $stmt = $connect -> prepare($sql);
            $stmt -> bind_param("i", $commentID);
            $stmt -> execute();
            $result = $stmt -> get_result();

            if ($result -> num_rows > 0) {
                $row = $result -> fetch_assoc();
                if ($row['memberID'] == $memberID) {
                    // 댓글 수정
                    $updateSql = "UPDATE comments SET commentText = ? WHERE commentID = ?";
                    $updateStmt = $connect -> prepare($updateSql);
                    $updateStmt -> bind_param("si", $commentText, $commentID);
                    if ($updateStmt -> execute()) {
                        echo json_encode(["status" => "success", "message" => "댓글이 성공적으로 수정되었습니다."]);
                    } else {
                        echo json_encode(["status" => "error", "message" => "댓글 수정에 실패했습니다."]);
                    }
                    $updateStmt -> close();
                } else {
                    echo json_encode(["status" => "error", "message" => "권한이 없습니다."]);
                }
            } else {
                echo json_encode(["status" => "error", "message" => "존재하지 않는 댓글입니다."]);
            }
            $stmt -> close();
        } else {
            echo json_encode(["status" => "error", "message" => "잘못된 요청입니다."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "잘못된 요청 방식입니다."]);
    }

    $connect -> close();
?>
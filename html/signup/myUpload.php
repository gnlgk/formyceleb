<?php
include "../connect/connect.php";
include "../connect/session.php";

$memberID = $_SESSION['memberID'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profileImage'])) {
   
    $targetDir = "../coding/assets/uploads/";
    $targetFile = $targetDir . basename($_FILES["profileImage"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    //파일 정보
    $blogFileSize = $_FILES["profileImage"]["size"];
    $allowedExt = array('jpg', 'jpeg', 'png', 'gif', 'webp');
    $blogImgFile = "default.png"; 
    
    // 이미지 파일인지 확인
    $check = getimagesize($_FILES["profileImage"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "<script>alert('이미지가 아닙니다.')</script>";
        echo "<script>window.history.back();</script>";
        $uploadOk = 0;
    }
    
    // 특정 파일 형식 허용 (jpg, png, jpeg, gif)
     if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "<script>alert('죄송합니다, JPG, JPEG, PNG 및 GIF 파일만 허용됩니다.')</script>";
        echo "<script>window.history.back();</script>";
        $uploadOk = 0;
    }
        
    if ($blogFileSize > 1048576) { 
        //파일이름 랜덤으로
        echo "<script>alert('파일 용량이 너무 큽니다. 1MB 이하로 해주세요.');history.back();</script>";
        $uploadOk = 0;
    }
    
    // echo "<pre>";
    // var_dump($fileDestination);
    // echo "</pre>";
    
    $sql = "SELECT * FROM members WHERE memberID = {$memberID}";
    $result = $connect->query($sql);

    if ($result) {
        $info = $result->fetch_array(MYSQLI_ASSOC);
        // 파일 업로드 시도
        if ($uploadOk == 1) {
            $newFileName = "img_" . uniqid('', true) . "." . $imageFileType;
            $fileDestination = $targetDir . $newFileName;
            if (move_uploaded_file($_FILES["profileImage"]["tmp_name"], $fileDestination)) {
                $blogImgFile = $newFileName;
                // 파일이 성공적으로 업로드된 경우, 데이터베이스에 경로 저장
                $userId = $memberID; // 사용자 ID (예시로 1을 사용, 실제로는 로그인된 사용자 ID를 사용)
                $query = "UPDATE members SET profile_image = ? WHERE memberID = ?";
                $stmt = $connect->prepare($query);
                $stmt->bind_param("si", $fileDestination, $userId);
                if ($stmt->execute()) {
                    echo "<script>alert('파일 " . htmlspecialchars(basename($_FILES["profileImage"]["name"])) . " 이(가) 업로드되었습니다.')</script>";
                    echo "<script>window.history.back();</script>";
                } else {
                    echo "<script>alert('죄송합니다, 프로필 이미지를 업데이트하는 중 오류가 발생했습니다.')</script>";
                }
            } else {
                echo "<script>alert('죄송합니다, 파일을 업로드하는 중 오류가 발생했습니다.')</script>";
            }
        }
    } else {
        echo "<script>alert('관리자에게 문의하세요!')</script>";
    }

}
?>

<?php
include "../connect/connect.php";
include "../connect/session.php";

// 로그인 확인
if (!isset($_SESSION['memberID'])) {
    echo "<script>alert('로그인이 필요합니다.'); window.location.href = '../index.php';</script>";
    exit;
}
$memberID = htmlspecialchars($_SESSION['memberID']);
$youID = htmlspecialchars($_SESSION['youID']);

$sql = "SELECT * FROM members WHERE memberID = {$memberID}";
$result = $connect -> query($sql);

if($result){
    $info = $result -> fetch_array(MYSQLI_ASSOC);

    $youEmail = $info['youEmail'];
    $profileImg = $info['profile_image'];
    $regTime = date('Y-m-d', $info['regTime']);
}

// 기본 이미지 설정
$defaultImg = '../coding/assets/img/sample.jpg'; // 기본 이미지 경로 설정
if (empty($profileImg)) {
    $profileImg = $defaultImg;
}

// echo "<pre>";
// var_dump($regTime);
// echo "</pre>";
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include "../include/head.php"; ?>
    <link rel="stylesheet" href="../coding/assets/css/mypage.css">
    <script src="../coding/assets/js/mypage.js"></script>
</head>
<body>
    <?php include "../include/header.php"; ?>
    <main>
        <div class="mypage-container" >
            <div class="mypage-header">
                <h1>MY PAGE</h1>

                <div id="profile">
                    <form id="uploadForm" action="../signup/myUpload.php" method="post" enctype="multipart/form-data">
                        <input type="file" id="fileInput" name="profileImage" accept="image/*" style="display: none;" onchange="handleFileSelect(this)">
                        <div class="circle" onclick="document.getElementById('fileInput').click();">
                            <img id="profileImagePreview" src='<?php echo $profileImg; ?>' alt="">
                        </div>
                    </form>
                    <button class="btn-set" onclick="saveProfileImage()">save</button>
                </div>
            <!-- // 내 프로필 이미지 초기화 -->

                <p>안녕하세요, <?php echo $youID; ?>님!</p>
            </div>

            <div class="mypage-section profile-info">
                <div class="section-title">프로필 정보</div>
                <div class="profile-info-item"><span>아이디</span> : <?php echo $youID; ?></div>
                <div class="profile-info-item"><span>이메일</span> : <?php echo $youEmail; ?></div>
                <div class="profile-info-item"><span>가입일</span> : <?php echo $regTime; ?></div> 
        
            </div>
            <div class="mypage-section settings">
                <div class="section-title">설정</div>
                <div class="setting-item" id="openIdModal"><a href="#">아이디 변경</a></div>
                <div class="setting-item" id="openEmailModal"><a href="#">이메일 변경</a></div>
                <div class="setting-item" id="openDeleteModal"><a href="#">계정삭제</a></div>
            </div>

            <div class="mypage-section questions">
                <div class="section-title">QnA</div>
                <div class="questions-item"><a href="mailto:ssm971213@naver.com">문의하기(E-mail)</a></div>
            </div>
        </div>

        <!-- 아이디 변경 모달 -->
        <div id="idModal" class="modal">
            <div class="modal-content">
                <!-- <span class="close" id="closeIdModal">&times;</span> -->
                <form id="idForm">
                    <label for="newId">새 아이디:</label>
                    <input type="text" id="newId" name="newId" required>
                    <label for="password">비밀번호 확인:</label>
                    <input type="password" id="password" name="password" required>
                    <button class="modal_btn" type="submit">변경</button>
                </form>
            </div>
        </div>

        <!-- 이메일 변경 모달 -->
        <div id="emailModal" class="modal">
            <div class="modal-content">
                <!-- <span class="close" id="closeEmailModal">&times;</span> -->
                <form id="emailForm">
                    <label for="newEmail">새 이메일:</label>
                    <input type="email" id="newEmail" name="newEmail" required>
                    <label for="passwordEmail">비밀번호 확인:</label>
                    <input type="password" id="passwordEmail" name="password" required>
                    <button class="modal_btn" type="submit">변경</button>
                </form>
            </div>
        </div>

        <!-- 계정 삭제 모달 -->
        <div id="deleteModal" class="modal">
            <div class="modal-content">
                <!-- <span class="close" id="closeDeleteModal">&times;</span> -->
                <form id="deleteForm">
                    <label for="passwordDelete">비밀번호 확인:</label>
                    <input type="password" id="passwordDelete" name="password" required>
                    <button class="modal_btn" type="submit">계정 삭제</button>
                </form>
            </div>
        </div>
    </main>
    <?php include "../include/footer.php"; ?>

    <script>

    function handleFileSelect(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('profileImagePreview').src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function saveProfileImage() {
        var form = document.getElementById('uploadForm');
        form.submit();
    }


    </script>
</body>
</html>

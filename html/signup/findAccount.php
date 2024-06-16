<?php
include "../connect/connect.php";
include "../connect/session.php";
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <?php
        include "../include/head.php";
    ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- <script> src="../coding/assets/js/findPw.js"</script> -->
    <script>
         $(document).ready(function(){
            $(".sign-in-htm").submit(function(event){
                event.preventDefault();
                var email = $("#find-email").val();
                
                $.ajax({
                    type: "POST",
                    url: "../signup/findIdResult.php",
                    data: { youEmail: email },
                    dataType: "json",
                    success: function(response){
                        if(response.status == "success"){
                            alert("귀하의 아이디: " + response.username);
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error){
                        console.error("AJAX 요청 중 오류 발생:", status, error);
                        alert("서버와 통신 중 오류가 발생했습니다.");
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function () {
    $(".find-up-htm").submit(function (event) {
        event.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            type: "POST",
            url: "../signup/findPwResult.php",
            data: formData,
            dataType: "json",
            success: function (response) {
                console.log(response); // 서버 응답 확인
                if (response.status == "success") {
                    alert(response.message);
                } else {
                    alert(response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX 요청 중 오류 발생:", status, error);
                console.error(xhr.responseText); // 서버 응답 내용 확인
            }
        });
    });
});
    </script>
</head>
<body>
<div class="login-wrap">
    <div class="login-html">
        <button class="close">✕</button>

        <input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">아이디 찾기</label>
        <input id="tab-2" type="radio" name="tab" class="find-up"><label for="tab-2" class="tab">비밀번호 찾기</label>
        <div class="login-form">
            <!-- 아이디 찾기 -->
            <form action="" method="post" class="sign-in-htm">
                <div class="logo">• formyceleb •</div>
                <div class="group">
                    <label for="find-email" class="label"></label>
                    <input id="find-email" name="youEmail" type="email" class="input" placeholder="이메일" autocomplete="off">
                </div>
                <div class="group">
                    <input type="submit" class="button" value="아이디 찾기">
                </div>
            </form>
            <!-- 비밀번호 찾기 폼 -->
            <form action="" method="post" class="find-up-htm">
                <div class="logo">• formyceleb •</div>
                <div class="group">
                    <label for="find-user" class="label"></label>
                    <input id="find-user" name="youID" type="text" class="input" placeholder="아이디" autocomplete="off">
                </div>
                <div class="group">
                    <label for="find-pass-email" class="label"></label>
                    <input id="find-pass-email" name="youEmail" type="email" class="input" placeholder="이메일" autocomplete="off">
                </div>
                <div class="group">
                    <input type="submit" class="button" value="비밀번호 찾기">
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>

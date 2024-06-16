<link rel="stylesheet" href="../coding/assets/css/fonts.css">


<div class="login-wrap">
    <div class="login-html">
        <button class="close">✕</button>

        <input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1"
            class="tab">로그인</label>
        <input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2"
            class="tab">회원가입</label>
        <div class="login-form">
            <!-- 로그인 폼 -->
            <form action="../signup/signinSave.php" method="post" class="sign-in-htm">
            <div class="logo">• formyceleb •</div>
                <div class="group">
                    <label for="login-user" class="label"></label>
                    <input id="login-user" name="youID" type="text" class="input" placeholder="아이디" autocomplete="off">
                </div>
                <div class="group">
                    <label for="login-pass" class="label"></label>
                    <input id="login-pass" name="youPass" type="password" class="input" data-type="password" placeholder="비밀번호" autocomplete="off">
                </div>
                <div class="group">
                    <input type="submit" class="button" value="로그인">
                </div>
                <div class="foot-lnk">
                    <a href="../signup/findAccount.php">아이디 / 비밀번호 찾기</a>
                </div>
                

            </form>
            <!-- 회원가입 폼 -->
            <form action="../signup/signupResult.php" method="post" class="sign-up-htm">
                <div class="group">
                    <label for="register-user" class="label"></label>
                    <input id="register-user" name="youID" type="text" class="input" placeholder="아이디를 입력해주세요" autocomplete="off">
                    <div id="userIdResult"></div>
                </div>
                <div class="group">
                    <label for="register-pass" class="label"></label>
                    <input id="register-pass" name="youPass" type="password" class="input" placeholder="비밀번호를 입력해주세요" autocomplete="off"
                        data-type="password">
                </div>
                <div class="group">
                    <label for="confirm-pass" class="label"></label>
                    <input id="confirm-pass" name="password_confirm" type="password" class="input" placeholder="비밀번호 확인" autocomplete="off"
                        data-type="password">
                </div>
                <div class="group">
                    <label for="register-email" class="label"></label>
                    <input id="register-email" name="youEmail" type="text" class="input" placeholder="이메일을 입력해주세요" autocomplete="off">
                    <div id="userEmailResult"></div>  <!-- 중복 검사 결과를 표시할 요소 -->
                </div>
                <div class="group">
                    <input type="submit" class="button" value="가입하기">
                </div>
                <div class="foot-lnk">
                 <a href="#">이미 회원이신가요?</a>
                </div>
            </form>
        </div>
    </div>
</div>
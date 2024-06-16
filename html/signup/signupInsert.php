<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>For My Celebrity</title>
    <link rel="stylesheet" href="../coding/assets/outcss/login.css">
</head>

<body>
    <div class="login-wrap">
        <div class="login-html">
            <input id="tab-1" type="radio" name="tab" class="sign-in" checked><label for="tab-1" class="tab">Sign In</label>
            <input id="tab-2" type="radio" name="tab" class="sign-up"><label for="tab-2" class="tab">Sign Up</label>
            <div class="login-form">
                <!-- 로그인 폼 -->
                <form action="login.php" method="post" class="sign-in-htm">
                    <div class="group">
                        <label for="login-user" class="label">아이디</label>
                        <input id="login-user" name="username" type="text" class="input">
                    </div>
                    <div class="group">
                        <label for="login-pass" class="label">비밀번호</label>
                        <input id="login-pass" name="password" type="password" class="input" data-type="password">
                    </div>
                    <div class="group">
                        <input id="login-check" type="checkbox" class="check" checked>
                        <label for="login-check"><span class="icon"></span>아이디 저장하기</label>
                    </div>
                    <div class="group">
                        <input type="submit" class="button" value="로그인">
                    </div>
                    <div class="hr"></div>
                    <div class="foot-lnk">
                        <a href="#forgot">비밀번호 찾기</a>
                    </div>
                </form>
                <!-- 회원가입 폼 -->
                <form action="signupResult.php" method="post" class="sign-up-htm">
                    <div class="group">
                        <label for="register-user" class="label">아이디</label>
                        <input id="register-user" name="username" type="text" class="input">
                    </div>
                    <div class="group">
                        <label for="register-pass" class="label">비밀번호</label>
                        <input id="register-pass" name="password" type="password" class="input" data-type="password">
                    </div>
                    <div class="group">
                        <label for="confirm-pass" class="label">비밀번호 확인</label>
                        <input id="confirm-pass" name="password_confirm" type="password" class="input" data-type="password">
                    </div>
                    <div class="group">
                        <label for="register-email" class="label">이메일</label>
                        <input id="register-email" name="email" type="text" class="input">
                    </div>
                    <div class="group">
                        <input type="submit" class="button" value="가입하기">
                    </div>
                    <div class="hr"></div>
                    <div class="foot-lnk">
                        <label for="tab-1">이미 회원이신가요?</label>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
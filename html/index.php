<?php
    include "connect/connect.php";
    include "connect/session.php";
?>

<!DOCTYPE html>
<html lang="ko" class="no-js">
<!-- php -->
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="디자인, 코딩, 개발을 이용하여 만든 나만의 블로그 사이트입니다.">
    <meta name="keywords" content="포트폴리오, PHP, 디자인, 풀스택, 코딩, 블로그">

    <meta property="og:title" content="포트폴리오, PHP, 디자인, 풀스택, 코딩, 블로그">
    <meta property="og:url" content="포트폴리오, PHP, 디자인, 풀스택, 코딩, 블로그">
    <meta property="og:image" content="http://kingsong97.dothome.co.kr/coding/assets/ico/favicon.png">
    <meta property="og:description" content="포트폴리오, PHP, 디자인, 풀스택, 코딩, 블로그" />

    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Kingsong Blog">
    <meta name="twitter:url" content="http://kingsong97.dothome.co.kr">
    <meta name="twitter:image" content="http://kingsong97.dothome.co.kr/coding/assets/ico/favicon.png">
    <meta name="twitter:description" content="포트폴리오, PHP, 디자인, 풀스택, 코딩, 블로그" />

    <link href="http://kingsong97.dothome.co.kr/coding/assets/ico/favicon.png" rel="shortcut icon">
    <link rel="stylesheet" href="../coding/assets/outcss/index.css">
    <link rel="stylesheet" href="../coding/assets/outcss/login.css">
    <link rel="stylesheet" href="../coding/assets/css/cate.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../coding/assets/js/login.js"></script>
    <script src="../coding/assets/js/regCheck.js"></script>

</head>

<body class="loading">
    <main>
        <div class="frame">
            <h1 class="frame__title"><span id="categoryTitle">category</span></h1>
            <div class="menu">
                <div class="menuContent">
                    <ul>
                        <li><a href="#" id="nmixx">nmixx</a></li>
                        <li><a href="#" id="stayc">stayc</a></li>
                        <li><a href="#" id="qwer">QWER</a></li>
                        <li><a href="#" id="lesserafim">LE SSERAFIM</a></li>
                        <li><a href="#" id="illit">ILLIT</a></li>
                        <li><a href="#" id="babymonster">BABYMONSTER</a></li>
                        <li><a href="#" id="newjeans">NewJeans</a></li>
                        <li><a href="#" id="aespa">aespa</a></li>
                        <li><a href="#" id="ive">IVE</a></li>
                    </ul>
                </div>
            </div>
            <nav class="frame__links">
            <a href="board/boardList.php">community</a>
                <a href="#" id="favorite">favorite</a>
                <a href="signup/myPage.php">mypage</a>
            </nav>
            <?php if (isset($_SESSION['memberID'])) { ?>
    <button class="unbutton button-menu" aria-label="Logout">
        <span><a href="signup/signOut.php" id="logoutButton">Logout</a></span>
    </button>
<?php } else { ?>
    <button class="unbutton button-menu" aria-label="Open the menu">
        <span><a href="#" id="loginButton">Login</a></span>
    </button>
<?php } ?>

            <!-- <button class="unbutton button-menu" aria-label="Open the menu"><span><a href="#"
                        id="loginButton">login</a></span></button> -->
        </div>
        <h2 class="heading heading--up">formyceleb</h2>
        <h2 class="heading heading--down">formyceleb</h2>

        <div id="login_modal" class="login_modal">
                    <div class="modal_content">
                        <?php include 'signup/login.php';?>
                    </div>
                  </div>
        <!-- modal -->
        
        <div class="columns" data-scroll-container="">
            <div class="column-wrap column-wrap--height">
                <div class="column idol1">

                </div>
                <!-- /column -->
            </div>
            <!-- /column-wrap -->
            <div class="column-wrap">
                <div class="column idol2" data-scroll-section="">

                </div>
                <!-- /column -->
            </div>
            <div class="column-wrap column-wrap--height">
                <div class="column idol3">

                </div>
                <!-- /column -->
            </div>
            <!-- /column-wrap -->
        </div>
        <!-- columns -->

        <!-- main 모달 창 -->
        <div id="image-modal" class="modal">
            <div class="modal-content">
                <div id="dynamic-content"></div>
            </div>
        </div>
    </main>

    <!-- 팝업창 -->
    <div id="noticePopup">
            <p>본 사이트는 교육용으로 어떠한 사업적 이용을 불허합니다.</p>
            <button id="closePopup">닫기</button>
            <div class="dont-show">
                <input type="checkbox" id="dontShowToday" />
                <label for="dontShowToday">오늘 다시 보지 않기</label>
            </div>
        </div>

    <!-- GSAP 라이브러리 로드 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.6.1/gsap.min.js"></script>
    <!-- ScrollTrigger 라이브러리 로드 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.6.1/ScrollTrigger.min.js"></script>
    <!-- Locomotive Scroll 라이브러리 로드 -->
    <script src="https://cdn.jsdelivr.net/npm/locomotive-scroll@4.1.3/dist/locomotive-scroll.min.js"></script>
    <!-- 사용자 정의 JS 로드 -->

    <script src="coding/assets/js/index.js"></script>
    <script src="coding/assets/js/login.js"></script>
    <script src="coding/assets/js/cate.js"></script>
    <script src="coding/assets/js/regCheck.js"></script>
</body>

</html>
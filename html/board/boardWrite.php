<?php
    include "../connect/connect.php";
    include "../connect/session.php";
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <title>COMMUNITY</title>
<?php
include "../include/head.php"
?>
</head>

<body>
<?php
include "../include/header.php"
?>

    <!-- //header -->
    <main id="main" role="main">
        <div class="container">
        <div class="navigation line-bot">
                <!-- <nav class="tab">
                    <button class="tablink" onclick="openTab(event, 'Community')"
                        data-title="COMMUNITY">COMMUNITY</button>
                    <button class="tablink active" onclick="openTab(event, 'Notice')"
                        data-title="NOTICE">NOTICE</button>
                </nav> -->

            </div>
            <div class="intro__inner line-bot">
            <div class="intro__img2">
                    <div class="svglogo"></div>
                </div>
                <h2 class="intro__title">• Board •</h2>
            </div>
            <!-- //intro_inner -->
            <div class="board__inner">
                <div class="board__write">
                    <form action="boardWriteSave.php" name="boardWriteSave" method="post">
                        <fieldset>
                            <legend class="blind">게시글 작성하기</legend>
                            <div>
                                <label for="boardTitle">제목</label>
                                <input type="text" id="boardTitle" name="boardTitle" class="input-style" placeholder="제목을 작성해주세요!">
                            </div>
                            <div>
                                <label for="boardContents">내용</label>
                                <textarea name="boardContents" id="boardContents" rows="40"
                                    class="input-style" placeholder="내용을 작성해주세요!"></textarea>
                            </div>
                            <div class="btn">
                                <button type="submit" class="btn-style">저장하기</button>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <!-- //board inner -->
    </main>
    <!-- //main -->
<?php
include "../include/footer.php"
?>
    <!-- //footer -->
</body>

</html>
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
                <form action="boardModifySave.php" name="boardModifySave" method="post">
                        <fieldset>
                        <legend class="blind">게시글 수정하기</legend>
                            <?php
                                $boardID = $_GET['boardID'];

                                $sql = "SELECT * FROM board WHERE boardID = {$boardID}";
                                $result = $connect -> query($sql);

                                if($result){
                                    $info = $result -> fetch_array(MYSQLI_ASSOC);

                                    echo "<div style='display:none'><label for='boardID'>번호</label><input type='text' id='boardID' name='boardID' class='input-style' value='".$info['boardID']."'></div>";
                                    echo "<div><label for='boardTitle'>제목</label><input type='text' id='boardTitle' name='boardTitle' class='input-style' value='".$info['boardTitle']."'></div>";
                                    echo "<div><label for='boardContents'>내용</label><textarea name='boardContents' id='boardContents' rows='20' class='input-style'>".$info['boardContents']."</textarea></div>";
                                    echo "<div><label for='boardPass' class='mt50'>비밀번호</label><input type='password' id='boardPass' name='boardPass' class='input-style mb10' autocomplete='off' placeholder='글을 수정하려면 비밀번호를 입력하셔야 합니다.' requireed></div>";
                                }
                            ?>
                            
                            <div class="btn">
                                <button type="submit" class="btn-style">수정하기</button>
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
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
                <div class="board__view">
                    <table>
                        <colgroup>
                            <col style="width: 20%" />
                            <col style="width: 80%" />
                        </colgroup>
                        <tbody>
                        <?php
    $boardID = $_GET['boardID'];

    // 보드뷰 + 1
    $sql = "UPDATE board SET boardView = boardView + 1 WHERE boardID = {$boardID}";
    $connect -> query($sql);

    $sql = "SELECT b.boardTitle, m.youID, b.regTime, b.boardView, b.boardContents FROM board b JOIN members m ON(b.memberID = m.memberID) WHERE b.boardID = {$boardID}";
    $result = $connect -> query($sql);

    if($result){
        $info = $result -> fetch_array(MYSQLI_ASSOC);

        echo "<tr><th>제목</th><td>".$info['boardTitle']."</td></tr>";
        echo "<tr><th>등록자</th><td>".$info['youID']."</td></tr>";
        echo "<tr><th>등록일</th><td>".date('Y-m-d', $info['regTime'])."</td></tr>";
        echo "<tr><th>조회수</th><td>".$info['boardView']."</td></tr>";
        echo "<tr><th>내용</th><td>".$info['boardContents']."</td></tr>";
    }
?>
                        </tbody>

                    </table>
                    <div class="btn">
                        <a href="boardModify.php?boardID=<?=$_GET['boardID']?>" class="btn-style">수정하기</a>
                        <a href="boardDelete.php?boardID=<?=$_GET['boardID']?>" class="btn-style" onclick="retrun confirm('삭제하시겠습니까?')">삭제하기</a>
                        <a href="boardList.php" class="btn-style">목록보기</a>
                    </div>
                </div>
            </div>
            <!-- //board__inner -->
    </main>
    <!-- //main -->
<?php
include "../include/footer.php"
?>
    <!-- //footer -->
</body>

</html>
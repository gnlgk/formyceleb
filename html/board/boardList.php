<?php
    include "../connect/connect.php";
    include "../connect/session.php";

    // 총 게시글 갯수
    $sql = "SELECT count(boardID) FROM board";
    $result = $connect -> query($sql);

    $boardTotalCount = $result -> fetch_array(MYSQLI_ASSOC);
    $boardTotalCount = $boardTotalCount['count(boardID)'];
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
                <?php
                if (isset($_SESSION['memberID'])) {
                    echo '<a href="boardWrite.php" class="write">글쓰기</a>';
                }
                ?>
            </div>
            <!-- //intro_inner -->
            <div class="board__inner">
                <div class="board__search">
                    <div class="left">
                        * 총 <em><?=$boardTotalCount?></em>개 게시물이 등록되어 있습니다.
                    </div>
                    <div class="right">
                        <form action="boardSearch.php" name="boardSearch" method="get">
                            <fieldset>
                                <legend class="blind">게시판 검색 영역</legend>
                                <input type="text" name="searchKeyword" id="searchKeyword" placeholder="검색어를 입력하세요.">
                                <select name="searchOption" id="searchOption">
                                    <option value="title">제목</option>
                                    <option value="content">내용</option>
                                    <option value="name">작성자</option>
                                </select>
                                <button type="submit">검색</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
                <div class="board__table">
                    <table>
                        <colgroup>
                            <col style="width:10%" />
                            <col style="width:55%" />
                            <col style="width:10%" />
                            <col style="width:15%" />
                            <col style="width:10%" />
                        </colgroup>
                        <thead>
                            <tr>
                                <th>번호</th>
                                <th>제목</th>
                                <th>등록자</th>
                                <th>등록일</th>
                                <th>조회수</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(isset($_GET['page'])){
                                    $page = (int) $_GET['page'];
                                } else {
                                    $page = 1;
                                }   
                                $viewNum = 10;
                                $viewLimit = ($viewNum * $page) - $viewNum;
                                // 1~10 LIMIT 0, 10  --> page1 ($viewNum * 1) - $viewNum
                                // 11~20 LIMIT 10, 10 --> page2 ($viewNum * 2) - $viewNum
                                // 21~30 LIMIT 20, 10 --> page3 ($viewNum * 3) - $viewNum
                                // 31~40 LIMIT 30, 10 --> page4 ($viewNum * 4) - $viewNum

                                $sql = "SELECT b.boardID, b.boardTitle, m.youID, b.regTime, b.boardView FROM board b JOIN members m ON(b.memberID = m.memberID) ORDER BY boardID DESC LIMIT {$viewLimit}, {$viewNum}";
                                $result = $connect -> query($sql);

                                if($result){
                                    $count = $result -> num_rows;

                                    if($count > 0){
                                        for($i = 0; $i<$count; $i++){
                                            $info = $result -> fetch_array(MYSQLI_ASSOC);

                                            echo "<tr>";
                                            echo "<td>".$info['boardID']."</td>";
                                            echo "<td><a href='boardView.php?boardID={$info['boardID']}'>".$info['boardTitle']."</a></td>";
                                            echo "<td>".$info['youID']."</td>";
                                            echo "<td>".date('Y-m-d', $info['regTime'])."</td>";
                                            echo "<td>".$info['boardView']."</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='5'>게시글이 없습니다.</td></tr>";
                                    }
                                } else {
                                    echo "<script>alert('에러 발생! 관리자에게 문의하세요!')</script>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- //board_table -->
                <div class="board__pages">
                   <ul>
                    <?php
                    // 총 페이지 갯수
                    $boardTotalCount = ceil($boardTotalCount/$viewNum);
                    
                    $pageView = 4; 
                    $startPage = $page - $pageView;
                    $endPage = $page + $pageView;
                    
                    // 처음 페이지 초기화 / 마지막 페이지 초기화
                    if($startPage < 1) $startPage = 1;
                    if($endPage >= $boardTotalCount) $endPage = $boardTotalCount;

                    // 처음으로/이전
                    if($page != 1){
                        $prevPage = $page - 1;
                        echo "<li class='prev'><a href='boardList.php?page={$prevPage}'>◁</a></li>";
                    }

                    // 페이지
                    for($i=$startPage; $i<=$endPage; $i++){
                        $active = "";
                        if($i === $page) $active = "active";
                        echo "<li class={$active}><a href='boardList.php?page={$i}'>{$i}</a></li>";
                    }

                    // 마지막으로/다음
                    if($page < $boardTotalCount){
                        $nextPage = $page + 1;
                        echo "<li class='next'><a href='boardList.php?page={$nextPage}'>▷</a></li>";
                    }
                    ?>
                    <!-- <li class="prev"><a href="#"><</a></li>
                    <li class="active"><a href="boardList.php?page=1">1</a></li>
                    <li><a href="boardList.php?page=2">2</a></li>
                    <li><a href="boardList.php?page=3">3</a></li>
                    <li><a href="boardList.php?page=4">4</a></li>
                    <li><a href="boardList.php?page=5">5</a></li>
                    <li><a href="boardList.php?page=6">6</a></li>
                    <li><a href="boardList.php?page=7">7</a></li>
                    <li><a href="boardList.php?page=8">8</a></li>
                    <li class="next"><a href="#">></a></li> -->
                   </ul>
                </div>
                <!-- //board pages -->
            </div>
            <!-- //board inner -->
    </main>
    <!-- //main -->
<?php
include "../include/footer.php"
?>
    <!-- //footer -->

<script>
    function openTab(evt, tabName) {
    // 모든 tabcontent 요소 숨기기
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // 모든 tablink 요소의 active 클래스 제거
    tablinks = document.getElementsByClassName("tablink");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // 클릭한 tablink 요소에 active 클래스 추가
    evt.currentTarget.className += " active";

    // 클릭한 탭의 제목으로 header-title 변경
    var newTitle = evt.currentTarget.getAttribute("data-title");
    document.getElementById("header-title").textContent = newTitle;

    // 클릭한 tabcontent 요소 보이기
    document.getElementById(tabName).style.display = "block";
}

// 기본으로 표시할 탭 설정
document.addEventListener("DOMContentLoaded", function () {
    document.querySelector(".tablink.active").click();
});
</script>
</body>

</html>
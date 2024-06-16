<?php
    include "../connect/connect.php";
    include "../connect/session.php";

    if(isset($_GET['page'])){
        $page = (int) $_GET['page'];
    } else {
        $page = 1;
    }

    $searchKeyword = $connect -> real_escape_string(trim($_GET['searchKeyword']));
    $searchOption = $connect -> real_escape_string(trim($_GET['searchOption']));

    $sql = "SELECT b.boardID, b.boardTitle, b.boardContents, m.youID, b.regTime, b.boardView FROM board b JOIN members m ON(b.memberID = m.memberID) ";

    // $sql = "SELECT b.boardID, b.boardTitle, b.boardContents, m.youID, b.regTime, b.boardView FROM board b JOIN member m ON(b.memberID = m.memberID) WHERE b.boardTitle LIKE '%{$searchKeyword}%' ORDER BY boardID DESC";
    // $sql = "SELECT b.boardID, b.boardTitle, b.boardContents, m.youID, b.regTime, b.boardView FROM board b JOIN member m ON(b.memberID = m.memberID) WHERE b.boardContents LIKE '%{$searchKeyword}%' ORDER BY boardID DESC";
    // $sql = "SELECT b.boardID, b.boardTitle, b.boardContents, m.youID, b.regTime, b.boardView FROM board b JOIN member m ON(b.memberID = m.memberID) WHERE m.youID LIKE '%{$searchKeyword}%' ORDER BY boardID DESC";

    switch($searchOption){
        case "title" :
            $sql .= "WHERE b.boardTitle LIKE '%{$searchKeyword}%' ORDER BY boardID DESC";
            break;
        case "content" :
            $sql .= "WHERE b.boardContents LIKE '%{$searchKeyword}%' ORDER BY boardID DESC";
            break;
        case "name" :
            $sql .= "WHERE m.youID LIKE '%{$searchKeyword}%' ORDER BY boardID DESC";
            break;
    }
    $result = $connect -> query($sql);
    $totalCount = $result -> num_rows;
    // echo $totalCount;
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
                        * <em><?=$searchKeyword?></em>에 대한 검색 결과가 <em><?=$totalCount?></em>개 나왔습니다.
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
    $viewNum = 10;
    $viewLimit = ($viewNum * $page) - $viewNum;

    $sql .= " LIMIT {$viewLimit}, {$viewNum}";
    $result = $connect -> query($sql);

    if($result){
        $count = $result -> num_rows;

        if($count > 0){
            for($i=0; $i<$count; $i++){
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
                    $boardTotalCount = ceil($totalCount/$viewNum); 
                                         
                    $pageView = 4; 
                    $startPage = $page - $pageView;
                    $endPage = $page + $pageView;
                    
                    // 처음 페이지 초기화 / 마지막 페이지 초기화
                    if($startPage < 1) $startPage = 1;
                    if($endPage >= $boardTotalCount) $endPage = $boardTotalCount;

                    // 처음으로/이전
                    if($page != 1){
                        $prevPage = $page - 1;
                        echo "<li class='prev'><a href='boardSearch.php?page={$prevPage}'>◁</a></li>";
                    }

                    // 페이지
                    for($i=$startPage; $i<=$endPage; $i++){
                        $active = "";
                        if($i === $page) $active = "active";
                        echo "<li class={$active}><a href='boardSearch.php?page={$i}'>{$i}</a></li>";
                    }

                    // 마지막으로/다음
                    if($page < $boardTotalCount){
                        $nextPage = $page + 1;
                        echo "<li class='next'><a href='boardSearch.php?page={$nextPage}'>▷</a></li>";
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
</body>

</html>
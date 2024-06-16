<?php
echo "<link rel='stylesheet' href='../coding/assets/css/style.css'>";
include "../connect/connect.php";
include "../connect/session.php";

// 이미지링크 디코딩
$encodedImageURL = $_GET['imageURL'] ?? '';
$imageURL = base64_decode($encodedImageURL);

// 이미지 URL로 imgID를 가져오기
$sql = "SELECT imgID FROM photos WHERE image_url='$imageURL'";
$result = $connect->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $imgID = $row['imgID'];

    //댓글, 로그인아이디 가져오기
    $commentSql = "SELECT c.*, m.youID, m.profile_image FROM comments c JOIN members m ON c.memberID = m.memberID WHERE imgID={$imgID} ORDER BY regTime DESC";
    $commentResult = $connect -> query($commentSql);
    $comments = [];
    $defaultImage = "../coding/assets/uploads/default.png";

    // echo "<pre>";
    // var_dump($commentRow['profile_image']);
    // echo "</pre>";

    if ($commentResult->num_rows > 0) {
        while ($commentRow = $commentResult->fetch_assoc()) {
            $profileImage = !empty($commentRow['profile_image']) ? $commentRow['profile_image'] : $defaultImage;
    
            $comments[] = [
                'commentID' => $commentRow['commentID'],
                'youID' => $commentRow['youID'],
                'profile_image' => $profileImage,
                'commentText' => $commentRow['commentText'],
                'regTime' => date('Y.m.d H:i', strtotime($commentRow['regTime'])),
                'memberID' => $commentRow['memberID']
            ];
        }
    }

    // 댓글 수 조회
    $commentCount = 0;
    if (isset($imgID)) {
        $commentSql = "SELECT COUNT(*) AS commentCount FROM comments WHERE imgID = ?";
        $stmt = $connect->prepare($commentSql);
        $stmt->bind_param("i", $imgID);
        $stmt->execute();
        $commentResult = $stmt->get_result();

        if ($commentResult) {
            $commentCountData = $commentResult->fetch_assoc();
            $commentCount = $commentCountData['commentCount'];
        }
    }

    // 좋아요 상태 및 개수 가져오기
    $isLiked = false;
    $likeCount = 0;
    if (isset($_SESSION['memberID'])) {
        $memberID = $_SESSION['memberID'];

        // 좋아요 상태 가져오기
        $likeSql = "SELECT COUNT(*) as count FROM blogLike WHERE imgID = {$imgID} AND memberID = {$memberID}";
        $likeResult = $connect->query($likeSql);
        if ($likeResult) {
            $likeData = $likeResult->fetch_assoc();
            $isLiked = $likeData['count'] > 0;
        }

        // 좋아요 개수 가져오기
        $likeCountSql = "SELECT COUNT(*) as count FROM blogLike WHERE imgID = {$imgID}";
        $likeCountResult = $connect->query($likeCountSql);
        if ($likeCountResult) {
            $likeCountData = $likeCountResult->fetch_assoc();
            $likeCount = $likeCountData['count'];
        }
    }
    ?>

<div class="img_wrap">
        <div class="left__photo">
            <?php echo '<img src="' . htmlspecialchars($imageURL, ENT_QUOTES, 'UTF-8') . '" alt="Image">'; ?>
        </div>
        <div class="right__cnt">
            <div class="blog__comments">
                <div class="comment__head">
                    <h4>comment</h4>
                    <a class="downloadButton" href="<?php echo '../main/download.php?url=' . urlencode($imageURL); ?>" class="download-button">
    <?php echo file_get_contents("../coding/assets/svg/download.svg"); ?>
</a>

                </div>
                
                <?php if (is_array($comments) && count($comments) > 0) { ?>
                    <?php foreach ($comments as $comment) { ?>
                        <div class='comment'>
                            <div class='comment__view'>
                                <div class='avata'>
                                    <img src='<?php echo htmlspecialchars($comment['profile_image'], ENT_QUOTES, 'UTF-8'); ?>' alt=''>
                                </div>
                                <div class='info'>
                                    <div class='author'><?php echo htmlspecialchars($comment['youID'], ENT_QUOTES, 'UTF-8'); ?></div>
                                    <div class='text'><?php echo htmlspecialchars($comment['commentText'], ENT_QUOTES, 'UTF-8'); ?></div>
                                </div>
                                <div class='controls'>
                                    <span class='date'><?php echo htmlspecialchars($comment['regTime'], ENT_QUOTES, 'UTF-8'); ?></span>
                                    <?php if ($_SESSION['memberID'] == $comment['memberID']) { ?>
                                        <a href='#' class='update' data-commentID="<?php echo $comment['commentID']; ?>">[수정]</a>
                                        <a href='#' class='delete' data-commentID="<?php echo $comment['commentID']; ?>">[삭제]</a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <div class='comment__view'><?php echo '➟ 아직 댓글이 없습니다!'; ?></div>
                <?php } ?>
                

                <div class="comment__Create">
                    <div class="countandlike">
                        <div class="comment__count">
                            <span class="count"><?php echo $commentCount ? "댓글 " . $commentCount . "개" : "어떠셨나요?"; ?></span>
                        </div>
                        <div class="comment__like">
                            <a href="#" id="likeButton" class="<?php echo $isLiked ? "on" : "" ?>">
                                <span class="love">
                                <svg width="24" height="24" viewBox="0 0 24 24">
        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"></path>
    </svg>
                                </span>
                                <span class="like"><?php echo $likeCount > 0 ? $likeCount : "좋아요"; ?></span>
                            </a>
                        </div>
                    </div>
                    <div>
                    <form id="commentCreate" name="commentCreate" method="post">
                        <fieldset>
                            <input type="hidden" name="imgID" value="<?php echo htmlspecialchars($imgID ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                            <div class="commentName">
                                <label for="commentName" class="blind">작성자</label>
                                <input type="text" id="commentName" name="commentName" value="<?php echo htmlspecialchars($_SESSION['youID'], ENT_QUOTES, 'UTF-8'); ?>" required>
                            </div>
                            <div class="commentText">
                                <label for="commentText" class="blind">댓글</label>
                                <input type="text" id="commentText" name="commentText" placeholder="댓글을 입력해주세요!" required>
                            </div>
                            <div class="btn">
                                <button type="submit" class="btn-style">⪢</button>
                            </div>
                        </fieldset>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
           
            // 댓글 작성 폼 제출 시 AJAX 요청
            $('#commentCreate').submit(function(e) {
                e.preventDefault(); 

                $.ajax({
                    url: '../comment/commentCreate.php',
                    type: 'POST',
                    data: $(this).serialize(), // 폼 데이터를 직렬화하여 전송
                    success: function(response) {
                        try {
                            let res = JSON.parse(response);
                            console.log(res);
                            if (res.status === 'success') {
                                // alert(res.message);
                                // location.reload(); // 페이지 새로고침
                                // 새 댓글을 HTML에 추가
                                let newComment = `      
                                    <div class='comment__view'>
                                        <div class='avata'>
                                            <img src='../coding/assets/uploads/default.png' alt=''>
                                        </div>
                                        <div class='info'>
                                            <div class='author'>${res.data.youID}</div>
                                            <div class='text'>${res.data.commentText}</div>
                                            </div>  
                                        <div class='controls'>
                                            <span class='date'>${res.data.regTime}</span>
                                            <a href='#' class='update' onclick="showUpdateForm('${res.data.commentID}')">[수정]</a>
                                            <a href='#' class='delete' onclick="showDeleteForm('${res.data.commentID}')">[삭제]</a>
                                        </div>  
                                    </div>
                                `;
                                $('.blog__comments').prepend(newComment); // 새 댓글을 목록의 맨 위에 추가
                                $('#commentCreate')[0].reset(); // 폼 초기화
                            } else {
                                alert(res.message);
                            }
                        } catch (e) {
                            alert('서버 응답을 처리하는 중 오류가 발생했습니다.');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('댓글 작성 중 오류가 발생했습니다.');
                    }
                });
            });
        });
            // 삭제버튼 처리
            document.querySelectorAll('.comment__view .delete').forEach(function(button){
                button.addEventListener('click',function(e){
                    e.preventDefault();

                    if(confirm('정말 삭제하시겠습니까?')){
                        let commentID = this.getAttribute('data-commentID');
                        let formData = new FormData();
                        formData.append('commentID', commentID);

                        let xhr = new XMLHttpRequest();
                        xhr.open('POST', '../comment/commentDelete.php', true);
                        xhr.onload = function() {
                            if (xhr.status === 200) {
                                try {
                                    let response = JSON.parse(xhr.responseText);
                                    if (response.status === 'success') {
                                        // alert(response.message);
                                        // location.reload();  // 페이지 새로고침하여 댓글 목록 업데이트
                                    } else {
                                        alert(response.message);
                                    }
                                } catch (e) {
                                    alert('로그인을 하셔야 댓글을 작성할 수 있습니다.', e.message);
                                }
                            } else {
                                alert('서버와의 통신에 실패했습니다.');
                            }
                        };
                        xhr.send(formData);
                    }
                });
            });

            // 댓글수정
            document.querySelectorAll('.comment__view .update').forEach(function(button){
                button.addEventListener("click",function(e) {
                    e.preventDefault();

                    let commentID = this.getAttribute('data-commentID');
                    let commentDiv = this.closest('.comment__view');
                    let commentText = commentDiv.querySelector('.text');
                    let originalText = commentText.textContent.trim();

                    commentText.innerHTML = `<input type="text" class="edit" value="${originalText}" required><button class="save">저장</button><button class="cancel">취소</button></input>`

                    commentDiv.querySelector(".save").addEventListener('click',function(){
                        let updateText = commentDiv.querySelector(".edit").value.trim();
                        console.log(originalText)

                        if(updateText) {
                            let formData = new FormData();
                            formData.append('commentID',commentID);
                            formData.append('commentText',updateText);

                            let xhr = new XMLHttpRequest();
                            xhr.open('POST', '../comment/commentUpdate.php', true);
                            xhr.onload = function() {
                                if (xhr.status === 200) {
                                    try {
                                        let response = JSON.parse(xhr.responseText);
                                        if (response.status === 'success') {
                                            alert(response.message);
                                            location.reload();  // 페이지 새로고침하여 댓글 목록 업데이트
                                        } else {
                                            alert(response.message);
                                        }
                                    } catch (e) {
                                        alert('로그인을 하셔야 합니다.', e.message );
                                    }
                                } else {
                                    alert('서버와의 통신에 실패했습니다.');
                                }
                            };
                            xhr.send(formData);
                        } else {
                            alert('댓글 내용을 입력해주세요');
                        }
                    });
                    commentDiv.querySelector(".cancel").addEventListener('click',function(){
                        commentText.innerHTML = originalText;
                    });
                })
            });

            //좋아요 버튼
            const likeButton = document.querySelector('#likeButton');

            likeButton.addEventListener('click',function(e){
                e.preventDefault();

                const imgID = "<?php echo $imgID; ?>";
                let formData = new FormData();
                formData.append('imgID',imgID);

                let xhr = new XMLHttpRequest();
                xhr.open('POST', '../comment/imgLike.php', true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        if (response.status === 'success') {
                            likeButton.classList.toggle('on');
                            document.querySelector('.like').textContent = response.likeCount;
                        } else {
                            alert(response.message);
                        }
                    } else {
                        alert('서버와의 통신에 실패했습니다.');
                    }
                };
                xhr.send(formData);
            })
       
    </script>
    <?php
} else {
    echo "<div>이미지를 찾을 수 없습니다.</div>";
}
?>

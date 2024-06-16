// 선택자
const column1 = document.querySelector(".idol1");
const column2 = document.querySelector(".idol2");
const column3 = document.querySelector(".idol3");
const modal = document.getElementById("image-modal");
const modalContent = document.getElementById("dynamic-content");
const closeBtn = document.querySelector(".close");

document.addEventListener("DOMContentLoaded", async () => {
    const nmixxUrl = "https://gnlgk.github.io/formyceleb/coding/json/nmixx.json";
    await fetchPhoto(nmixxUrl);  // 이미지 로드를 기다립니다.


// 팝업 기능
const popup = document.getElementById('noticePopup');
const closePopupButton = document.getElementById('closePopup');
const dontShowCheckbox = document.getElementById('dontShowToday');

const dontShowToday = localStorage.getItem('dontShowToday');
if (!dontShowToday || new Date().getTime() > dontShowToday) {
    popup.style.display = 'block';
}

closePopupButton.addEventListener('click', function () {
    if (dontShowCheckbox.checked) {
        const now = new Date();
        const endOfDay = new Date(now.getFullYear(), now.getMonth(), now.getDate(), 23, 59, 59);
        localStorage.setItem('dontShowToday', endOfDay.getTime());
    }
    popup.style.display = 'none';
});
});

let photoInfo = [];

const button1 = document.getElementById("nmixx");
const button2 = document.getElementById("stayc");
const button3 = document.getElementById("qwer");
const button4 = document.getElementById("lesserafim");
const button5 = document.getElementById("illit");
const button6 = document.getElementById("babymonster");
const button7 = document.getElementById("newjeans");
const button8 = document.getElementById("aespa");
const button9 = document.getElementById("ive");
const button10 = document.getElementById("favorite");

button1.addEventListener("click", async () => {
    const nmixxUrl = "https://gnlgk.github.io/class2024/json/nmixx.json"; // 첫 번째 버튼이 클릭되었을 때 가져올 JSON 파일의 URL
    await fetchPhoto(nmixxUrl);
    resetScroll(); // 스크롤 위치 초기화
});

button2.addEventListener("click", async () => {
    const staycUrl = "https://gnlgk.github.io/class2024/json/stayc.json"; // 두 번째 버튼이 클릭되었을 때 가져올 JSON 파일의 URL
    await fetchPhoto(staycUrl);
    resetScroll(); // 스크롤 위치 초기화
});
button3.addEventListener("click", async () => {
    const qwerUrl = "https://gnlgk.github.io/class2024/json/QWER.json";
    await fetchPhoto(qwerUrl);
    resetScroll(); // 스크롤 위치 초기화
});
button4.addEventListener("click", async () => {
    const lesserafimUrl = "https://gnlgk.github.io/class2024/json/LESSERAFIM.json";
    await fetchPhoto(lesserafimUrl);
    resetScroll(); // 스크롤 위치 초기화
});
button5.addEventListener("click", async () => {
    const illitUrl = "https://gnlgk.github.io/class2024/json/ILLIT.json";
    await fetchPhoto(illitUrl);
    resetScroll(); // 스크롤 위치 초기화
});
button6.addEventListener("click", async () => {
    const babymonsterUrl = "https://gnlgk.github.io/class2024/json/BABYMONSTER.json";
    await fetchPhoto(babymonsterUrl);
    resetScroll(); // 스크롤 위치 초기화
});
button7.addEventListener("click", async () => {
    const newjeansUrl = "https://gnlgk.github.io/class2024/json/newjeans.json";
    await fetchPhoto(newjeansUrl);
    resetScroll(); // 스크롤 위치 초기화
});
button8.addEventListener("click", async () => {
    const aespaUrl = "https://gnlgk.github.io/class2024/json/aespa.json";
    await fetchPhoto(aespaUrl);
    resetScroll(); // 스크롤 위치 초기화
});
button9.addEventListener("click", async () => {
    const iveUrl = "https://gnlgk.github.io/class2024/json/ive.json";
    await fetchPhoto(iveUrl);
    resetScroll(); // 스크롤 위치 초기화
});
button10.addEventListener("click", async () => {
    await fetchFavoritePhotos();
    resetScroll(); // 스크롤 위치 초기화
});

const fetchPhoto = async (url) => {
    try {
        const res = await fetch(url);
        const items = await res.json();
        photoInfo = items.map(item => ({ imgurl: item.image_url }));
        updatePhotos();
        initScroll();
    } catch (error) {
        console.error('Error fetching JSON:', error);
    }
};
// // favorite photo
const fetchFavoritePhotos = async () => {
    try {
        const res = await fetch('../../main/getFavorites.php');
        const data = await res.json();
        if (data.status === 'success') {
            photoInfo = data.photos.map(photo => ({ imgurl: photo.image_url }));
            updatePhotos();
        } else {
            alert(data.message);
        }
    } catch (error) {
        console.error('Error fetching favorites:', error);
    }
};

// 사진을 업데이트하는 함수
const updatePhotos = () => {
    updatePhoto1();
    updatePhoto2();
    updatePhoto3();
    initImageInteractions(); // 이미지 업데이트 후 확대 애니메이션 초기화
};

const updatePhoto1 = () => {
    column1.innerHTML = "";
    for (let index = 0; index < photoInfo.length; index++) {
        let photo = photoInfo[index * 3 + 1];

        if (photo && photo.imgurl) {
            let photoWrapTag = `
                <figure class="column__item">
                    <div class="column__item-imgwrap">
                        <div class="column__item-img" style="background-image:url(${photo.imgurl})"></div>
                    </div>
                    <figcaption class="column__item-caption">
                        <span>${index + 1}</span>
                        <span>${index + 1}</span>
                    </figcaption>
                </figure>
            `;
            column1.innerHTML += photoWrapTag;
        }
    }
    addClickEventToPhotos(column1); // 클릭 이벤트 추가
    initImageInteractions();
};

const updatePhoto2 = () => {
    column2.innerHTML = "";
    for (let index = 0; index < photoInfo.length; index++) {
        let photo = photoInfo[index * 3];

        if (photo && photo.imgurl) {
            let photoWrapTag = `
                <figure class="column__item">
                    <div class="column__item-imgwrap">
                        <div class="column__item-img" style="background-image:url(${photo.imgurl})"></div>
                    </div>
                    <figcaption class="column__item-caption">
                        <span>${index + 1}</span>
                        <span>${index + 1}</span>
                    </figcaption>
                </figure>
            `;
            column2.innerHTML += photoWrapTag;
        }
    }
    addClickEventToPhotos(column2); // 클릭 이벤트 추가
    initImageInteractions();
};

const updatePhoto3 = () => {
    column3.innerHTML = "";
    for (let index = 0; index < photoInfo.length; index++) {
        let photo = photoInfo[index * 3 + 2];
        if (photo && photo.imgurl) {
            let photoWrapTag = `
                <figure class="column__item">
                    <div class="column__item-imgwrap">
                        <div class="column__item-img" style="background-image:url(${photo.imgurl})"></div>
                    </div>
                    <figcaption class="column__item-caption">
                        <span>${index + 1}</span>
                        <span>${index + 1}</span>
                    </figcaption>
                </figure>
            `;
            column3.innerHTML += photoWrapTag;
        }
    }
    addClickEventToPhotos(column3); // 클릭 이벤트 추가
    initImageInteractions();
};


// 이미지 클릭 시 모달 창을 여는 함수
const addClickEventToPhotos = (column) => {
    column.querySelectorAll('.column__item-img').forEach(img => {
        img.addEventListener('click', () => {
            const imageURL = img.style.backgroundImage.slice(5, -2); // URL만 추출하여 전달
            const encodedImageURL = btoa(imageURL); // Base64 인코딩
            openImageInSameWindow(encodedImageURL);
        });
    });
};

const openImageInSameWindow = async (encodedImageURL) => {
    try {
        const res = await fetch(`main/main.php?imageURL=${encodedImageURL}`);
        const html = await res.text();
        modalContent.innerHTML = html;
        modal.style.display = "block"; // 모달 창 열기
        initDynamicContent(); // 동적 콘텐츠 초기화
    } catch (error) {
        console.error('Error fetching image details:', error);
    }
};

// 모달 창 닫기 이벤트
closeBtn.addEventListener('click', () => {
    modal.style.display = "none";
});

window.addEventListener('click', (event) => {
    if (event.target == modal) {
        modal.style.display = "none";
    }
});

function initDynamicContent() {
    // 댓글 작성 처리
    const commentForm = document.querySelector('form[name="commentCreate"]');
    if (commentForm) {
        commentForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(commentForm);

            fetch('../comment/commentCreate.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        const newComment = document.createElement('div');
                        newComment.classList.add('comment');
                        newComment.innerHTML = `
                        <div class='comment__view'>
                            <div class='avata'>
                                <img src='../coding/assets/uploads/default.png' alt=''>
                            </div>
                            <div class='info'>
                                <div class='author'>${data.youID}</div>
                                <div class='text'>${data.commentText}</div>
                            </div>
                            <div class='controls'>
                                <span class='date'>${data.regTime}</span>
                                <a href='#' class='update' data-commentID="${data.commentID}">[수정]</a>
                                <a href='#' class='delete' data-commentID="${data.commentID}">[삭제]</a>
                            </div>
                        </div>
                    `;
                    const commentsContainer = document.querySelector('.blog__comments');
                    const commentCreate = document.querySelector('.comment__Create');
                    commentsContainer.insertBefore(newComment, commentCreate);
                    commentForm.reset();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    }

    // 삭제버튼 처리
    document.querySelectorAll('.comment__view .delete').forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            if (confirm('정말 삭제하시겠습니까?')) {
                let commentID = this.getAttribute('data-commentID');
                let formData = new FormData();
                formData.append('commentID', commentID);

                let xhr = new XMLHttpRequest();
                xhr.open('POST', '../comment/commentDelete.php', true);
                xhr.onload = function () {
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
    document.querySelectorAll('.comment__view .update').forEach(function (button) {
        button.addEventListener("click", function (e) {
            e.preventDefault();

            let commentID = this.getAttribute('data-commentID');
            let commentDiv = this.closest('.comment__view');
            let commentText = commentDiv.querySelector('.text');
            let originalText = commentText.textContent.trim();

            commentText.innerHTML = `<input type="text" class="edit" value="${originalText}" required><button class="save">저장</button><button class="cancel">취소</button></input>`

            commentDiv.querySelector(".save").addEventListener('click', function () {
                let updateText = commentDiv.querySelector(".edit").value.trim();

                if (updateText) {
                    let formData = new FormData();
                    formData.append('commentID', commentID);
                    formData.append('commentText', updateText);

                    let xhr = new XMLHttpRequest();
                    xhr.open('POST', '../comment/commentUpdate.php', true);
                    xhr.onload = function () {
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
                                alert('로그인을 하셔야 합니다.', e.message);
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
            commentDiv.querySelector(".cancel").addEventListener('click', function () {
                commentText.innerHTML = originalText;
            });
        })
    });

    //좋아요 버튼
    const likeButton = document.querySelector('#likeButton');

    likeButton.addEventListener('click', function (e) {
        e.preventDefault();

        const imgID = document.querySelector("input[name='imgID']").value;
        let formData = new FormData();
        formData.append('imgID', imgID);

        let xhr = new XMLHttpRequest();
        xhr.open('POST', '../comment/imgLike.php', true);
        xhr.onload = function () {
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
}

function initImageInteractions() {
    const items = document.querySelectorAll('.column__item');
    items.forEach(item => {
        const imgWrap = item.querySelector('.column__item-imgwrap');

        // 마우스 진입 시 확대 애니메이션
        item.addEventListener('mouseenter', function () {
            gsap.to(imgWrap, {
                scale: 1.2,
                duration: 0.5,
                ease: 'power1.out'
            });
        });

        // 마우스 이탈 시 축소 애니메이션
        item.addEventListener('mouseleave', function () {
            gsap.to(imgWrap, {
                scale: 1,
                duration: 0.5,
                ease: 'power1.out'
            });
        });
    });
}

// 스크롤 이벤트
let scrollInstance = null;

function initScroll() {
    if (scrollInstance) {
        scrollInstance.destroy(); // 기존 인스턴스를 파괴
    }

    scrollInstance = new LocomotiveScroll({
        el: document.querySelector('[data-scroll-container]'),
        smooth: true,
        lerp: 0.1,
        smartphone: {
            smooth: true
        },
        tablet: {
            smooth: true
        }
    });

    scrollInstance.on('scroll', (obj) => {
        const oddColumns = document.querySelectorAll('.column-wrap--height .column');
        oddColumns.forEach(column => {
            column.style.transform = `translateY(${obj.scroll.y}px)`;
        });
    });
}

// JSON 파일이 변경될 때 스크롤 위치 초기화
const resetScroll = () => {
    if (scrollInstance) {
        scrollInstance.scrollTo(0, { duration: 0, disableLerp: true }); // 스크롤 위치를 0으로 초기화
    }
};


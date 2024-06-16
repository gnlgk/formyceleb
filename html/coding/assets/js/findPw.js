$(document).ready(function () {
    $(".find-up-htm").submit(function (event) {
        event.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            type: "POST",
            url: "../signup/findPwResult.php",
            data: formData,
            dataType: "json",
            success: function (response) {
                console.log(response); // 서버 응답 확인
                if (response.status == "success") {
                    alert(response.message);
                } else {
                    alert(response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX 요청 중 오류 발생:", status, error);
                console.error(xhr.responseText); // 서버 응답 내용 확인
            }
        });
    });
});
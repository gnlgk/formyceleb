$(document).ready(function () {
    $(".sign-in-htm").submit(function (event) {
        event.preventDefault();
        var email = $("#find-email").val();

        $.ajax({
            type: "POST",
            url: "../find/findIDResult.php",
            data: { youEmail: email },
            dataType: "json",
            success: function (response) {
                if (response.status == "success") {
                    alert("아이디는: " + response.username);
                } else {
                    alert(response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX 요청 중 오류 발생:", status, error);
                alert("서버와 통신 중 오류가 발생했습니다.");
            }
        });
    });
});
document.addEventListener('DOMContentLoaded', function () {
    const userIdInput = document.getElementById('register-user');
    if (userIdInput) {
        userIdInput.addEventListener('input', checkUserId);
    } else {
        console.error('Register user input not found');
    }

    const userEmailInput = document.getElementById('register-email');
    if (userEmailInput) {
        userEmailInput.addEventListener('input', checkUserEmail);
    } else {
        console.error('Register email input not found');
    }
});

function checkUserId() {
    const userId = document.getElementById('register-user').value;
    if (userId.length > 0) {
        fetch('../signup/checkUserId.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'register-user=' + encodeURIComponent(userId)
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(data => {
                document.getElementById('userIdResult').innerHTML = data;
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('userIdResult').innerHTML = "오류가 발생했습니다.";
            });
    } else {
        document.getElementById('userIdResult').innerHTML = "아이디를 입력하세요.";
    }
}

function checkUserEmail() {
    const userEmail = document.getElementById('register-email').value;
    if (userEmail.length > 0) {
        fetch('../signup/checkUserEmail.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'register-email=' + encodeURIComponent(userEmail)
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(data => {
                document.getElementById('userEmailResult').innerHTML = data;
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('userEmailResult').innerHTML = "오류가 발생했습니다.";
            });
    } else {
        document.getElementById('userEmailResult').innerHTML = "이메일을 입력하세요.";
    }
}
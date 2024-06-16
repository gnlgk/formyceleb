document.addEventListener('DOMContentLoaded', function () {
    // 모달 관련 변수
    const idModal = document.getElementById('idModal');
    const emailModal = document.getElementById('emailModal');
    const deleteModal = document.getElementById('deleteModal');
    const openIdModal = document.getElementById('openIdModal');
    const openEmailModal = document.getElementById('openEmailModal');
    const openDeleteModal = document.getElementById('openDeleteModal');
    const closeIdModal = document.getElementById('closeIdModal');
    const closeEmailModal = document.getElementById('closeEmailModal');
    const closeDeleteModal = document.getElementById('closeDeleteModal');

    // 모달 열기
    openIdModal.onclick = function () {
        idModal.style.display = 'block';
    }
    openEmailModal.onclick = function () {
        emailModal.style.display = 'block';
    }
    openDeleteModal.onclick = function () {
        deleteModal.style.display = 'block';
    }

    // 모달 닫기
    // closeIdModal.onclick = function () {
    //     idModal.style.display = 'none';
    // }
    // closeEmailModal.onclick = function () {
    //     emailModal.style.display = 'none';
    // }
    // closeDeleteModal.onclick = function () {
    //     deleteModal.style.display = 'none';
    // }

    // window.onclick = function (event) {
    //     if (event.target == idModal) {
    //         idModal.style.display = 'none';
    //     }
    //     if (event.target == emailModal) {
    //         emailModal.style.display = 'none';
    //     }
    //     if (event.target == deleteModal) {
    //         deleteModal.style.display = 'none';
    //     }
    // }

    window.addEventListener('click', (event) => {
        if (event.target == idModal) {
            idModal.style.display = "none";
        }
    });
    window.addEventListener('click', (event) => {
        if (event.target == emailModal) {
            emailModal.style.display = "none";
        }
    });
    window.addEventListener('click', (event) => {
        if (event.target == deleteModal) {
            deleteModal.style.display = "none";
        }
    });

    // 아이디 변경 폼 제출
    document.getElementById('idForm').addEventListener('submit', async function (event) {
        event.preventDefault();
        const newId = document.getElementById('newId').value;
        const password = document.getElementById('password').value;

        const response = await fetch('../Account/idChange.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `newId=${newId}&password=${password}`
        });
        const result = await response.json();
        if (result.status === 'success') {
            alert('아이디가 변경되었습니다.');
            location.reload();
        } else {
            alert(result.message);
        }
    });

    // 이메일 변경 폼 제출
    document.getElementById('emailForm').addEventListener('submit', async function (event) {
        event.preventDefault();
        const newEmail = document.getElementById('newEmail').value;
        const password = document.getElementById('passwordEmail').value;

        const response = await fetch('../Account/EmailChange.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `newEmail=${newEmail}&password=${password}`
        });
        const result = await response.json();
        if (result.status === 'success') {
            alert('이메일이 변경되었습니다.');
            location.reload();
        } else {
            alert(result.message);
        }
    });

    // 계정 삭제 폼 제출
    document.getElementById('deleteForm').addEventListener('submit', async function (event) {
        event.preventDefault();
        const password = document.getElementById('passwordDelete').value;

        const response = await fetch('../Account/AccountDelete.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `password=${password}`
        });
        const result = await response.json();
        if (result.status === 'success') {
            alert('계정이 삭제되었습니다.');
            window.location.href = '../index.php';
        } else {
            alert(result.message);
        }
    });
});
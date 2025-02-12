$(document).ready(function () {
    $('#admin-login-form').submit(function (e) {
        e.preventDefault();

        const fullname = $('#fullname').val();
        const password = $('#password').val();

        if (!fullname || !password) {
            $('#message').html('<p style="color: red;">Both fields are required.</p>');
            return;
        }

        $.ajax({
            url: '../../controller/adminController.php',
            type: 'POST',
            data: {
                action: 'admin_login',
                fullname: fullname,
                password: password,
            },
            success: function (response) {
                const res = JSON.parse(response);
                if (res.status === 'success') {
                    $('#message').html('<p style="color: green;">' + res.message + '</p>');
                    setTimeout(() => {
                        window.location.href = '/novelnest/index.php';
                    }, 1000);
                } else {
                    $('#message').html('<p style="color: red;">' + res.message + '</p>');
                }
            },
            error: function () {
                $('#message').html('<p style="color: red;">An error occurred. Please try again.</p>');
            },
        });
    });
});
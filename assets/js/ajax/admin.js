$(document).ready(function () {
    $('#admin-login-form').submit(function (e) {
        e.preventDefault();

        // Ensure fullname and password fields exist
        let fullname = $('#fullname').val().trim();
        let password = $('#password').val().trim();

        if (!fullname || !password) {
            $('#message').html('<p style="color: red;">Both fields are required.</p>');
            return;
        }

        console.log("Fullname:", fullname);  // Debugging
        console.log("Password:", password);  // Debugging
        console.log("name:", fullname); 

        $.ajax({
            url: '../../controller/adminController.php',
            type: 'POST',
            data: {
                action: 'login',
                fullname: fullname,
                password: password,
            },
            success: function (response) {
                console.log("Raw Response:", response); // Debug response
                try {
                    const res = JSON.parse(response);
                    if (res.status === 'success') {
                        $('#message').html('<p style="color: green;">Sign-in successful. Redirecting...</p>');
                        setTimeout(() => {
                            window.location.href = res.redirect;
                        }, 1000);
                    } else {
                        $('#message').html('<p style="color: red;">' + res.message + '</p>');
                    }
                } catch (e) {
                    console.error("Invalid JSON:", e);
                    $('#message').html('<p style="color: red;">Server Error: Invalid JSON Response</p>');
                }
            },
            error: function () {
                $('#message').html('<p style="color: red;">An error occurred. Please try again.</p>');
            },
        });
    });
});

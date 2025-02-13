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

        $.ajax({
            url: '../../controller/adminController.php',
            method: 'POST',
            data: {
                action: 'login',
                fullname: $('#fullname').val(),
                password: $('#password').val()
            },
            success: function(response) {
                console.log("Response from server:", response);  // Log the response to debug
                if (response.status === 'success') {
                    window.location.href = response.redirect; // Redirect if success
                } else {
                    $('#message').html('<p style="color: red;">' + response.message + '</p>'); // Show error message if failure
                }
            },
            error: function(xhr, status, error) {
                alert('An error occurred. Please try again.');
            }
        });

    });
});

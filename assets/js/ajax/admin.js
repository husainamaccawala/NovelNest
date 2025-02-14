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
                fullname: fullname,  // Passing trimmed value
                password: password   // Passing trimmed value
            },
            success: function(response) {
                try {
                    var data = JSON.parse(response); // Parse the JSON response
                    if (data.status === 'success') {
                        window.location.href = data.redirect; // Redirect if success
                    } else {
                        $('#message').html('<p style="color: red;">' + data.message + '</p>'); // Show error message if failure
                    }
                } catch (e) {
                    console.error("Error parsing JSON response:", e);
                    $('#message').html('<p style="color: red;">An error occurred while processing your request.</p>');
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX request failed:", status, error);
                $('#message').html('<p style="color: red;">An error occurred. Please try again.</p>');
            }
        });

    });
});
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
            url: "/novelnest/controller/adminController.php",
            type: "POST",
            data: { fullname: $("#fullname").val(), password: $("#password").val(), action: "login" },
            dataType: "json", // Expect JSON response
            success: function(response) {
                if (response.status === "success") {
                    window.location.href = response.redirect;
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.log("AJAX Error:", xhr.responseText);
                alert("Something went wrong!");
            }
        });
        

    });
});
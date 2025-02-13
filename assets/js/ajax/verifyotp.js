$('#reset-password-form').click(function (e) {
    e.preventDefault();
    var otp = $('#otp').val().trim();
    if (!otp) {
        $('#message').html('<p style="color: red;">Please enter the OTP.</p>');
        return;
    }

    $.ajax({
        url: 'verifyController.php',
        type: 'POST',
        data: { otp: otp },
        success: function (response) {
            try {
                const res = JSON.parse(response);
                if (res.status === 'success') {
                    $('#message').html('<p style="color: green;">OTP verified successfully. Redirecting...</p>');
                    window.location.href = res.redirect;
                } else {
                    $('#message').html('<p style="color: red;">' + res.message + '</p>');
                }
            } catch (e) {
                $('#message').html('<p style="color: red;">Error in OTP verification. Please try again.</p>');
            }
        },
        error: function () {
            $('#message').html('<p style="color: red;">An error occurred. Please try again.</p>');
        },
    });
});

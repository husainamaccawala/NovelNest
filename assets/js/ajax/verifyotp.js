$(document).ready(function () {
    $('#reset-password-form').submit(function (e) {
        e.preventDefault();

        let otp = $('#otp').val().trim();
        let $message = $('#message');
        let $button = $('#verify_otp');

        if (!otp) {
            $message.html('<p style="color: red;">OTP is required.</p>');
            return;
        }

        // Disable button to prevent multiple submissions
        $button.prop('disabled', true).html('Verifying...');

        $.ajax({
            url: '../../controller/verifyOtpController.php',
            method: 'POST',
            data: { otp: otp },
            success: function (response) {
                try {
                    var data = JSON.parse(response);
                    if (data.status === 'success') {
                        window.location.href = data.redirect;
                    } else {
                        $message.html('<p style="color: red;">' + data.message + '</p>');
                    }
                } catch (e) {
                    console.error("Error parsing JSON response:", e);
                    $message.html('<p style="color: red;">An error occurred while processing your request.</p>');
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX request failed:", status, error);
                $message.html('<p style="color: red;">An error occurred. Please try again.</p>');
            },
            complete: function () {
                // Re-enable button after request completes
                $button.prop('disabled', false).html('Verify OTP');
            }
        });
    });

    // Optional: Resend OTP feature
    $('#resend-otp').click(function () {
        $.ajax({
            url: '../../controller/resendOtpController.php',
            method: 'POST',
            success: function (response) {
                try {
                    var data = JSON.parse(response);
                    if (data.status === 'success') {
                        $('#message').html('<p style="color: green;">' + data.message + '</p>');
                    } else {
                        $('#message').html('<p style="color: red;">' + data.message + '</p>');
                    }
                } catch (e) {
                    console.error("Error parsing JSON response:", e);
                    $('#message').html('<p style="color: red;">Failed to resend OTP.</p>');
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX request failed:", status, error);
                $('#message').html('<p style="color: red;">An error occurred. Please try again.</p>');
            }
        });
    });
});

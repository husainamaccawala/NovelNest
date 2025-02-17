$(document).ready(function () {
    const baseUrl = '/NovelNest';

    $("form").on("submit", function (event) {
        event.preventDefault(); // Prevent form submission initially

        const usrInput = document.getElementById("submit").value;
        const message = document.getElementById("key");

        if (usrInput === captchaText) {
            // If CAPTCHA is correct
            message.style.color = "green";
            message.innerHTML = "Captcha Matched!";

            let formData = new FormData(this);
            formData.append("action", "signup");

            $.ajax({
                url: baseUrl + "/controller/SignupController.php",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    let res = JSON.parse(response);
                    alert(res.message);

                    if (res.status === "success") {
                        // Successful response, redirect to the login page
                        window.location.href = res.redirect;
                    }
                },
                error: function (xhr, status, error) {
                    alert("An error occurred: " + error);
                }
            });
        } else {
            // If CAPTCHA is incorrect
            message.style.color = "red";
            message.innerHTML = "Captcha Not Matched!";
            alert("Captcha is incorrect! Please try again.");
            generate(); // Generate new CAPTCHA on failure
        }
    });
});

let captchaText;

function generate() {
    document.getElementById("submit").value = "";
    let captcha = document.getElementById("image");
    let uniquechar = "";
    const randomchar = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (let i = 0; i < 5; i++) {
        uniquechar += randomchar.charAt(Math.floor(Math.random() * randomchar.length));
    }

    captcha.innerHTML = uniquechar;
    captchaText = uniquechar; // Store the generated CAPTCHA
}

// Generate CAPTCHA on page load
window.onload = function () {
    generate();
};

$(document).ready(function() {

    const baseUrl = '/NovelNest';

    $("form").on("submit", function(event) {
        event.preventDefault();

        let formData = new FormData(this);
        formData.append("action", "signup");

        $.ajax({
            url: baseUrl + "/controller/SignupController.php",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                let res = JSON.parse(response);
                alert(res.message);

                if (res.status === "success") {
                    window.location.href = res.redirect;
                }
            },
            error: function(xhr, status, error) {
                alert("An error occurred: " + error);
            }
        });
    });
});


let captcha;

function generate() {

    // Clear old input
    document.getElementById("submit").value = "";

    // Access the element to store
    // the generated captcha
    captcha = document.getElementById("image");
    let uniquechar = "";

    const randomchar =
        "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    // Generate captcha for length of
    // 5 with random character
    for (let i = 1; i < 5; i++) {
        uniquechar += randomchar.charAt(
            Math.random() * randomchar.length)
    }

    // Store generated input
    captcha.innerHTML = uniquechar;
}

function printmsg() {
    const usr_input = document
        .getElementById("submit").value;

    // Check whether the input is equal
    // to generated captcha or not
    if (usr_input == captcha.innerHTML) {
        let s = document.getElementById("key")
            .innerHTML = "Matched";
        generate();
    } else {
        let s = document.getElementById("key")
            .innerHTML = "not Matched";
        generate();
    }
}
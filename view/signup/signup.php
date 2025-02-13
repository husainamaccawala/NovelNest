<?php
$baseUrl = '/NovelNest';
?>


<!doctype html>
<html lang="en" data-bs-theme="light" class="theme-fs-sm" dir="ltr">


<!-- Mirrored from templates.iqonic.design/booksto-dist/html/auth/sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 10 Dec 2024 11:53:11 GMT -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="description"
        content="Booksto is a revolutionary Bootstrap Admin Dashboard Template and UI Components Library. The Admin Dashboard Template and UI Component features 8 modules.">
    <meta name="keywords"
        content="premium, admin, dashboard, template, bootstrap 5, clean ui, Booksto, admin dashboard,responsive dashboard, optimized dashboard, simple auth">
    <meta name="author" content="Iqonic Design">
    <meta name="DC.title" content="Booksto Simple | Clinic And Patient Management Dashboard">
    <!-- Config Options -->
    <meta name="setting_options" content='{&quot;saveLocal&quot;:&quot;sessionStorage&quot;,&quot;storeKey&quot;:&quot;booksto&quot;,&quot;setting&quot;:{&quot;app_name&quot;:{&quot;value&quot;:&quot;Booksto&quot;},&quot;theme_scheme_direction&quot;:{&quot;value&quot;:&quot;ltr&quot;},&quot;theme_scheme&quot;:{&quot;value&quot;:&quot;light&quot;},&quot;theme_style_appearance&quot;:{&quot;value&quot;:[&quot;theme-default&quot;]},&quot;theme_color&quot;:{&quot;value&quot;:&quot;default&quot;},&quot;theme_transition&quot;:{&quot;value&quot;:&quot;theme-with-animation&quot;},&quot;theme_font_size&quot;:{&quot;value&quot;:&quot;theme-fs-md&quot;},&quot;page_layout&quot;:{&quot;value&quot;:&quot;container-fluid&quot;},&quot;header_navbar&quot;:{&quot;value&quot;:&quot;default&quot;},&quot;header_banner&quot;:{&quot;value&quot;:&quot;default&quot;},&quot;sidebar_color&quot;:{&quot;value&quot;:&quot;sidebar-white&quot;},&quot;card_color&quot;:{&quot;value&quot;:&quot;card-default&quot;},&quot;sidebar_type&quot;:{&quot;value&quot;:[]},&quot;sidebar_menu_style&quot;:{&quot;value&quot;:&quot;text-hover&quot;},&quot;footer&quot;:{&quot;value&quot;:&quot;default&quot;},&quot;body_font_family&quot;:{&quot;value&quot;:null},&quot;heading_font_family&quot;:{&quot;value&quot;:null}}}'>
    <!-- Google Font Api KEY-->
    <meta name="google_font_api" content="AIzaSyBG58yNdAjc20_8jAvLNSVi9E4Xhwjau_k">
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= $baseUrl ?>/assets/images/logo-mini.png" />

    <!-- Library / Plugin Css Build -->
    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/css/core/libs.min.css" />

    <!-- flaticon css -->
    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/vendor/flaticon/css/flaticon.css" />

    <!-- font-awesome css -->
    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/vendor/font-awesome/css/font-awesome.min.css" />


    <!-- booksto Design System Css -->
    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/css/booksto.min5438.css?v=1.2.0" />

    <!-- Custom Css -->
    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/css/custom.min5438.css?v=1.2.0" />

    <!-- RTL Css -->
    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/css/rtl.min5438.css?v=1.2.0" />

    <!-- Customizer Css -->
    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/css/customizer.min5438.css?v=1.2.0" />

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>


    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200;300;400;500;600;700;800&amp;display=swap"
        rel="stylesheet">


    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/vendor/remixicon/fonts/remixicon.css" />

    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/vendor/dripicons/webfont/webfont.css" />

    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/vendor/ionicons/css/ionicons.min.css" />

    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/vendor/line-awesome/css/line-awesome.min.css" />

    <!-- Phosphor icons  -->
    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/vendor/phosphor-icons/Fonts/regular/style.css">
    </link>
    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/vendor/phosphor-icons/Fonts/duotone/style.css">
    </link>
    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/vendor/phosphor-icons/Fonts/fill/style.css">
    </link>
    <!--  <script src="/NovelNest/assets/js/ajax/admin.js"></script>  -->
    <script src="../../assets/js/ajax/admin.js"></script>
    <script>
        (function() {
            const savedTheme = sessionStorage.getItem('booksto');

            if (savedTheme) {
                const settings = JSON.parse(savedTheme);
                const themeScheme = settings.setting.theme_scheme.value;
                document.documentElement.setAttribute('data-bs-theme', themeScheme);
            }
        })();
    </script>
</head>

<body class=" ">

    <!-- <div id="loading">
    <div class="loader simple-loader">
      <div class="loader-body">
        <img src="/assets/images/loader.gif" alt="loader" class="light-loader img-fluid " width="200">
      </div>
    </div>
  </div> -->

    <div class="wrapper">

        <div class="login-content" >
            <div class="container">
                <div class="row d-flex align-items-center justify-content-center vh-100 w-100 m-0">
                    <div class="col-lg-5 col-md-12 align-self-center bg-primary py-3">
                        <div class="card p-0 mb-0">
                            <div class="card-body auth-card">
                                <div class="logo-img">
                                    <div class="logo-img">
                                        <a href="../index-2.html" class="navbar-brand d-flex align-items-center mb-2 justify-content-center">
                                            <!--Logo start-->
                                            <div class="logo-main auth-logo">

                                                <img class="logo-normal  "
                                                    src="<?= $baseUrl ?>/assets/images/logo.png" height="30" alt="logo">

                                            </div>
                                            <!--logo End-->
                                        </a>
                                    </div>
                                    <h1 class="text-primary reset-pw fw-900 d-flex ms-3 justify-content-center">Sign Up</h1>
                                    <form method="POST" action="" enctype="multipart/form-data">
                                        <div>
                                            <label>Profile Photo: <span>*</span></label>
                                            <input type="file" name="photo" accept="image/*" required>
                                        </div>
                                        <div class="custom-form-field">
                                            <label>Your Full Name: <span>*</span></label>
                                            <input type="text" name="user-name" class="form-control mb-3 mt-2" required>
                                        </div>
                                        <div class="custom-form-field">
                                            <label>Email Address: <span>*</span></label>
                                            <input type="email" name="email" class="form-control mb-3 mt-2" required>
                                        </div>
                                        <div class="custom-form-field">
                                            <label>Contact Number: <span>*</span></label>
                                            <input type="tel" name="contact" class="form-control mb-3 mt-2" required>
                                        </div>
                                        <div class="custom-form-field">
                                            <label>Gender: <span>*</span></label>
                                            <div>
                                                <input type="radio" name="gender" value="male" required> Male
                                                <input type="radio" name="gender" value="female" required> Female
                                                <input type="radio" name="gender" value="other" required> Prefer not to say
                                            </div>
                                        </div>
                                        <div class="custom-form-field">
                                            <label>Password: <span>*</span></label>
                                            <input type="password" name="password" class="form-control mb-3 mt-2" required>
                                        </div>
                                        <div class="custom-form-field">
                                            <label>Confirm Password: <span>*</span></label>
                                            <input type="password" name="confirm-password" class="form-control mb-3 mt-2" required>
                                        </div>
                                        <div class="custom-form-field mb-3">
                                            <input type="checkbox" name="terms" required>
                                            <label>I accept <a href="../extra-pages/terms-of-service.html">terms and conditions.</a></label>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100">
                                            <span class="btn-inner d-flex align-items-center justify-content-center gap-2">
                                                <span class="text-center d-inline-block align-middle width-full">Sign Up</span>
                                                <i class="ph ph-plus custom-ph-icons"></i>
                                            </span>
                                        </button>
                                    </form>

                                    <div class="d-flex align-items-center mt-5 justify-content-center auth-signup">
                                        <p class="text-center mb-0">If you already have account!!<a href="<?= $baseUrl ?>/view/admin/adminSigninForm.php"
                                                class="ms-2">Sign In</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    </div>

    <script>
$(document).ready(function() {
    $("form").on("submit", function(event) {
        event.preventDefault();

        let formData = new FormData(this);
        formData.append("action", "signup");

        $.ajax({
            url: "<?= $baseUrl ?>/controller/SignupController.php",
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
</script>
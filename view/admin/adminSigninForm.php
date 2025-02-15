<?php
$baseUrl = '/NovelNest';
?>


<!doctype html>
<html lang="en" data-bs-theme="light" class="theme-fs-sm" dir="ltr">


<!-- Mirrored from templates.iqonic.design/booksto-dist/html/auth/sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 10 Dec 2024 11:53:11 GMT -->

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login</title>
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

    <div class="bg"></div>
    <div class="bg bg2"></div>
    <div class="bg bg3"></div>

    <div class="login-content">
      <div class="container">
        <div class="row d-flex align-items-center justify-content-center vh-100 w-100 m-0">
          <div class="col-lg-5 col-md-12 align-self-center bg-primary py-3">
            <div class="card p-0 mb-0">
              <div class="card-body auth-card">
                <div class="logo-img">
                  <a href="../index-2.html" class="navbar-brand d-flex align-items-center mb-2 justify-content-center">
                    <!--Logo start-->
                    <div class="logo-main auth-logo">

                      <img class="logo-normal  "
                        src="<?= $baseUrl ?>/assets/images/logo.png" height="30" alt="logo">
                      <img class="logo-color  "
                        src="<?= $baseUrl ?>/assets/images/logo-white.png" height="30" alt="logo">
                      <img class="logo-mini "
                        src="<?= $baseUrl ?>/assets/images/logo_mini.png" alt="logo">
                      <img class="logo-mini-white "
                        src="<?= $baseUrl ?>/assets/images/logo_mini_white.png" alt="logo">

                    </div>
                    <!--logo End-->
                  </a>
                </div>
                <h1 class="text-primary reset-pw fw-900 d-flex ms-1 justify-content-center">Sign In</h1>
                <p class="text-center mb-4 auth-desc">Enter your email address and password for access.</p>
                <div id="message"></div>
                <form id="admin-login-form">
                  <div class="mb-3">
                    <label for="fullname" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="fullname" name="fullname" required>
                  </div>
                  <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                  </div>
                  <div class="d-flex align-items-center justify-content-between mb-5">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="remember" required="required">
                      <label class="form-check-label" for="remember">
                        Remember Me
                      </label>
                    </div>
                    <a href="recoverpw.php" class="forgot-pwd">Forgot Password?</a>
                  </div>
                  <button type="submit" class="btn btn-primary w-100">Sign In</button>
                  <div id="error-message" class="text-danger mt-3"></div>
                  <div id="success-message" class="text-success mt-3"></div>


                </form>

                <div class="d-flex align-items-center mt-5 justify-content-center auth-signup">
                  <p class="text-center mb-0">If you don't have account!!<a href="<?= $baseUrl ?>/view/signup/signup.php"
                      class="ms-2">Sign Up</a></p>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  </div>

  <style>
    html {
      height: 100%;
    }

    body {
      margin: 0;
    }

    .bg {
      animation: slide 3s ease-in-out infinite alternate;
      background-image: linear-gradient(-60deg, #6c3 50%, #09f 50%);
      bottom: 0;
      left: -50%;
      opacity: .5;
      position: fixed;
      right: -50%;
      top: 0;
      z-index: -1;
    }

    .bg2 {
      animation-direction: alternate-reverse;
      animation-duration: 4s;
    }

    .bg3 {
      animation-duration: 5s;
    }

    .content {
      background-color: rgba(255, 255, 255, .8);
      border-radius: .25em;
      box-shadow: 0 0 .25em rgba(0, 0, 0, .25);
      box-sizing: border-box;
      left: 50%;
      padding: 10vmin;
      position: fixed;
      text-align: center;
      top: 50%;
      transform: translate(-50%, -50%);
    }

    h1 {
      font-family: monospace;
    }

    @keyframes slide {
      0% {
        transform: translateX(-25%);
      }

      100% {
        transform: translateX(25%);
      }
    }
  </style>
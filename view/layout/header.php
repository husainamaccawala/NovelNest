<?php
$baseUrl = '/NovelNest';
?>
<!doctype html>
<html lang="en" class="theme-fs-sm" data-bs-theme-color="default" dir="ltr">


<!-- Mirrored from templates.iqonic.design/booksto-dist/html/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 10 Dec 2024 11:46:07 GMT -->
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Handle admin name and profile image
$adminName = $_SESSION['admin_name'];
$adminProfileImage = $_SESSION['admin_profile_image'] ?? 'assets/images/default-avatar.jpg';

?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>NovelNest: Online Reading Platform</title>
    <meta name="description" content="NovelNest is the ultimate online reading platform where book lovers can explore, read, and discover thousands of free and premium novels, stories, and books from various genres. Join now!">
    <meta name="keywords" content="NovelNest, online novels, free books, read books online, e-books, best novels, premium novels, digital library, book reading platform">
    <meta name="author" content="NovelNest Team">
    <meta name="DC.title" content="NovelNest - Online Reading Platform">
    <meta name="robots" content="index, follow">
    <meta name="language" content="en">
    <meta name="distribution" content="global">
    <meta property="og:title" content="NovelNest: Read & Discover Books Online">
    <meta property="og:description" content="Discover thousands of novels and books on NovelNest, the ultimate reading platform for book lovers.">
    <meta property="og:url" content="https://www.novelnest.com">
    <meta property="og:type" content="website">
    <meta property="og:image" content="https://www.novelnest.com/images/novelnest-preview.jpg">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="NovelNest: Online Reading Platform">
    <meta name="twitter:description" content="Read and discover the best novels online. Thousands of free and premium books available at NovelNest.">
    <meta name="twitter:image" content="https://www.novelnest.com/images/novelnest-preview.jpg">

    <script>
        (function() {
            const savedTheme = sessionStorage.getItem('novelnest');

            if (savedTheme) {
                const settings = JSON.parse(savedTheme);
                const themeScheme = settings.setting.theme_scheme.value;
                document.documentElement.setAttribute('data-bs-theme', themeScheme);
            }
        })();
    </script>


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



    <!-- SwiperSlider css -->
    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/vendor/swiperSlider/swiper.min.css">


    <!-- Favicon -->
    <link rel="icon" href="<?= $baseUrl ?>/assets/images/monogram.png" type="image/x-icon">


    <!-- Flatpickr css -->
    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/vendor/flatpickr/dist/flatpickr.min.css" />

    <!-- Sweetlaert2 css -->
    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/vendor/sweetalert2/dist/sweetalert2.min.css">


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

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />

    <!-- <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" /> -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />


</head>

<body class="  ">
    <!-- loader Start -->

    <div id="loading">
        <div class="loader simple-loader">
            <div class="loader-body">
                <img src="<?= $baseUrl ?>/assets\images\pageload.gif" alt="loader" class="light-loader img-fluid " width="300">
            </div>
        </div>
    </div>

    <!-- loader END -->
    <aside class="sidebar sidebar-base " id="first-tour" data-toggle="main-sidebar"
        data-sidebar="responsive">
        <div class="sidebar-header d-flex align-items-center justify-content-start position-relative">
            <a href="<?= $baseUrl ?>/index.php" class="navbar-brand">
                <!--Logo start-->
                <div class="logo-main ">

                    <img class="logo-normal img-fluid "
                        src="<?= $baseUrl ?>/assets/images/logo.png" height="30" alt="logo" style="width: 200px; height: auto;">
                    <img class="logo-color img-fluid "

                        src="<?= $baseUrl ?>/assets/images/logo-white.png" height="30" alt="logo">

                </div>
                <!--logo End-->
            </a>
            <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
                <i class="icon">
                    <svg class="icon-20 icon-arrow" width="20" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.5 19L8.5 12L15.5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                    </svg>
                </i>
            </div>
        </div>
        <div class="sidebar-body pt-0 pb-3 data-scrollbar">
            <div class="sidebar-list">
                <!-- Sidebar Menu Start -->
                <ul class="navbar-nav iq-main-menu" id="sidebar-menu">

                    <li class="nav-item static-item">
                        <a class="nav-link static-item disabled" href="#">
                            <span class="default-icon">Admin Panel</span>
                            <i class="sidenav-mini-icon">-</i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                            aria-current="page"
                            href="<?= $baseUrl ?>/index.php">
                            <i class="icon" data-bs-toggle="tooltip" title="Dashboard"
                                data-bs-placement="right">
                                <i class="ph-duotone ph-gauge"></i>
                            </i>
                            <i class="sidenav-mini-icon" data-bs-toggle="tooltip"
                                title="Dashboard" data-bs-placement="right">Db</i>
                            <span class="item-name">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                            aria-current="page"
                            href="<?= $baseUrl ?>/view/genre/genre-list.php">
                            <i class="icon" data-bs-toggle="tooltip" title="Genres"
                                data-bs-placement="right">
                                <i class="ph-duotone ph-squares-four"></i>
                            </i>
                            <i class="sidenav-mini-icon" data-bs-toggle="tooltip"
                                title="Genres" data-bs-placement="right">Gen</i>
                            <span class="item-name">Genres</span>
                        </a>
                    </li>
                    <li class="nav-item iq-drop">
                        <a class="nav-link" data-bs-toggle="collapse" href="#user" role="button"
                            aria-expanded="false">
                            <i class="icon" data-bs-toggle="tooltip" title="Books"
                                data-bs-placement="right">
                                <i class="ph-duotone ph-book-bookmark"></i>
                            </i>
                            <span class="item-name">Books</span>
                            <i class="right-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18"
                                    class="icon-18" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </i>
                        </a>
                        <ul class="sub-nav collapse" id="user" data-bs-parent="#sidebar-menu">
                            <li class="nav-item">
                                <a
                                    class="nav-link "
                                    aria-current="page"
                                    href="<?= $baseUrl ?>/view/books/books-list.php">
                                    <i class="icon" data-bs-toggle="tooltip" title="Book List"

                                        data-bs-placement="right">
                                        <i class="ph-duotone ph-rows"></i>
                                    </i>

                                    <i class="sidenav-mini-icon" data-bs-toggle="tooltip"
                                        title="Book List"
                                        data-bs-placement="right">Bl</i>
                                    <span class="item-name">Book List</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a
                                    class="nav-link "
                                    aria-current="page"
                                    href="<?= $baseUrl ?>/view/pdfs/pdfs-list.php">


                                    <i class="icon" data-bs-toggle="tooltip" title="Book PDF"
                                        data-bs-placement="right">
                                        <i class="ph-duotone ph-file-pdf"></i>
                                    </i>
                                    <i class="sidenav-mini-icon" data-bs-toggle="tooltip"
                                        title="E-Books"
                                        data-bs-placement="right">eb</i>
                                    <span class="item-name">E-Books</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a
                                    class="nav-link "
                                    aria-current="page"
                                    href="<?= $baseUrl ?>/view/audiobook/audiobook-list.php">

                                    <i class="icon" data-bs-toggle="tooltip" title="Audiobooks"
                                        data-bs-placement="right">
                                        <i class="fa fa-file-audio-o"></i>
                                    </i>
                                    <i class="sidenav-mini-icon" data-bs-toggle="tooltip"
                                        title="Audiobooks"
                                        data-bs-placement="right">ab</i>
                                    <span class="item-name">Audiobooks</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                            aria-current="page"
                            href="<?= $baseUrl ?>/view/user/user-list.php">
                            <i class="icon" data-bs-toggle="tooltip" title="User"
                                data-bs-placement="right">
                                <i class="ph-duotone ph-identification-badge"></i>
                            </i>
                            <i class="sidenav-mini-icon" data-bs-toggle="tooltip"
                                title="Users" data-bs-placement="right">U</i>
                            <span class="item-name">Users</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                            aria-current="page"
                            href="/novelnest/view/subscription/subscription.php">
                            <i class="icon" data-bs-toggle="tooltip" title="Subscription"
                                data-bs-placement="right">
                                <i class="ph-duotone ph-tag"></i>
                            </i>
                            <i class="sidenav-mini-icon" data-bs-toggle="tooltip"
                                title="Subscription" data-bs-placement="right">Sub</i>
                            <span class="item-name">Subscription</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                            aria-current="page"
                            href="/novelnest/view/invoice/invoice.php">
                            <i class="icon" data-bs-toggle="tooltip" title="Invoices"
                                data-bs-placement="right">
                                <i class="ph-duotone ph-chat-centered"></i>
                            </i>
                            <i class="sidenav-mini-icon" data-bs-toggle="tooltip"
                                title="Invoices" data-bs-placement="right">Inv</i>
                            <span class="item-name">Invoices</span>
                        </a>
                    </li>
                    <!-- Sidebar Menu End -->
            </div>
        </div>
    </aside>

    <main class="main-content">
        <div class="position-sticky top-0 z-3">
            <!--Nav Start-->
            <nav class="nav navbar navbar-expand-xl navbar-light iq-navbar border-bottom">
                <div class="container-fluid navbar-inner justify-content-between">
                    <a href="index-2.html" class="navbar-brand">
                        <!--Logo start-->
                        <div class="logo-main ">

                            <img class="logo-normal  "
                                src="<?= $baseUrl ?>/assets/images/logo.png" height="30" alt="logo">
                            <img class="logo-color  "
                                src="<?= $baseUrl ?>/assets/images/logo-white.png" height="30" alt="logo">
                            <img class="logo-mini "
                                src="<?= $baseUrl ?>/assets/images/logo-mini.png" alt="logo">
                            <img class="logo-mini-white "
                                src="<?= $baseUrl ?>/assets/images/logo-mini-white.png" alt="logo">

                        </div>
                        <!--logo End-->
                    </a>
                    <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
                        <i class="icon d-flex">
                            <svg class="icon-20" width="20" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z" />
                            </svg>
                        </i>
                    </div>

                    <div class="d-flex align-items-center d-block d-lg-none">
                        <button id="navbar-toggle" class="navbar-toggler px-0" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                            aria-label="Toggle navigation">
                            <span class="navbar-toggler-btn">
                                <span class="navbar-toggler-icon"></span>
                            </span>
                        </button>
                    </div>
                    <div class="w-25 d-none d-xl-block">
                        <div class="form-group input-group mb-0 search-input w-100">
                            <span class="input-group-text ps-3 pe-0 border-0">
                                <i class="ph-duotone ph-magnifying-glass"></i>
                            </span>
                            <input type="text" class="form-control border-0" placeholder="Search...">

                        </div>
                    </div>
                    <div class="collapse flex-grow-0 navbar-collapse" id="navbarSupportedContent">
                        <ul class="mb-2 navbar-nav align-items-center navbar-list mb-lg-0">

                            <li class="nav-item dropdown iq-responsive-menu d-block d-xl-none">
                                <div class="btn btn-sm px-0 border-0" id="navbarDropdown-search-11" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="input-group-text ps-3 pe-0 border-0 bg-transparent">
                                        <svg class="icon-20" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="11.7669" cy="11.7666" r="8.98856" stroke="currentColor" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round"></circle>
                                            <path d="M18.0186 18.4851L21.5426 22" stroke="currentColor" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </span>
                                </div>
                                <ul class="dropdown-menu  dropdown-menu-end" aria-labelledby="navbarDropdown-search-11"
                                    style="width: 25rem;">
                                    <li class="px-3 py-0">
                                        <div class="form-group input-group mb-0 search-input w-100 shadow">
                                            <span class="input-group-text ps-3 pe-0 border-0">
                                                <svg class="icon-20" width="20" height="20" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="11.7669" cy="11.7666" r="8.98856" stroke="currentColor" stroke-width="1.5"
                                                        stroke-linecap="round" stroke-linejoin="round"></circle>
                                                    <path d="M18.0186 18.4851L21.5426 22" stroke="currentColor" stroke-width="1.5"
                                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                            </span>
                                            <input type="text" class="form-control border-0" placeholder="Search...">

                                        </div>
                                    </li>
                                </ul>
                            </li>


                            <li class="nav-item dropdown" id="itemdropdown1">
                                <a class="py-0 nav-link d-flex gap-3 justity-content-between align-items-center" href="#"
                                    id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="icon-50">
                                        <span class="btn-inner d-inline-block position-relative">

                                            <img src="<?php echo $baseUrl . '/' . $adminProfileImage; ?>" alt="Admin Profile" class="img-fluid rounded-circle object-fit-cover avatar-50">
                                            <span class="bg-success p-1 rounded-circle position-absolute end-0 bottom-0 border border-3 border-white"></span>
                                        </span>
                                    </div>
                                    <div class="d-none d-lg-block">
                                        <h6 class="mb-0 line-height"><?php echo htmlspecialchars($adminName); ?></h6>
                                    </div>

                                </a>
                                <div class="p-0 sub-drop dropdown-menu dropdown-menu-end" aria-labelledby="notification-cart">
                                    <div class="m-0 card-shadow card">
                                        <div class="py-3 card-header rounded-top-3 bg-primary mb-0">
                                            <div class="header-title">
                                                <h5 class="mb-0 text-white"><?php echo htmlspecialchars($adminName); ?></h5>
                                                <span class="text-white ">Available</span>
                                            </div>
                                        </div>

                                        <!-- <div class="p-0 card-body ">
                                            <a class="iq-sub-card" href="user/user-profile.html">
                                                <div class="d-flex align-items-center">
                                                    <div
                                                        class="avatar-40 rounded-pill bg-primary-subtle text-primary  d-flex align-items-center justify-content-center ">
                                                        <i class="ph ph-user-circle"></i>
                                                    </div>
                                                    <div class="ms-4 flex-grow-1 text-start">
                                                        <h6 class="mb-0 ">My Profile</h6>
                                                        <p class="mb-0 font-size-12">View personal profile details.</p>
                                                    </div>

                                                </div>
                                            </a>
                                            <a class="iq-sub-card" href="user/user-edit.html">
                                                <div class="d-flex align-items-center">
                                                    <div
                                                        class="avatar-40 rounded-pill bg-primary-subtle text-primary  d-flex align-items-center justify-content-center">
                                                        <i class="ph ph-identification-card"></i>
                                                    </div>
                                                    <div class="ms-4 flex-grow-1 text-start">
                                                        <h6 class="mb-0 ">Edit Profile</h6>
                                                        <p class="mb-0 font-size-12">Modify your personal details.</p>
                                                    </div>

                                                </div>
                                            </a>
                                            <a class="iq-sub-card" href="user/user-account-setting.html">
                                                <div class="d-flex align-items-center">
                                                    <div
                                                        class="avatar-40 rounded-pill bg-primary-subtle text-primary  d-flex align-items-center justify-content-center ">
                                                        <i class="ph ph-user-square"></i>
                                                    </div>
                                                    <div class="ms-4 flex-grow-1 text-start">
                                                        <h6 class="mb-0 ">Account Settings</h6>
                                                        <p class="mb-0 font-size-12">Manage your account parameters.</p>
                                                    </div>

                                                </div>
                                            </a>
                                            <a class="iq-sub-card" href="user/user-privacy-setting.html">
                                                <div class="d-flex align-items-center">
                                                    <div
                                                        class="avatar-40 rounded-pill bg-primary-subtle text-primary  d-flex align-items-center justify-content-center">
                                                        <i class="ph ph-lock-key"></i>
                                                    </div>
                                                    <div class="ms-4 flex-grow-1 text-start">
                                                        <h6 class="mb-0 ">Privacy Settings</h6>
                                                        <p class="mb-0 font-size-12">Control your privacy parameters.</p>
                                                    </div>
                                                </div>
                                            </a> -->
                                        <div class=" p-3 d-flex justify-content-center align-items-center">
                                            <a class="btn btn-primary d-flex align-items-center gap-1" href="/novelnest/logout.php"
                                                role="button">Sign out <i class="ph ph-sign-out"></i></a>
                                        </div>
                                    </div>
                                </div>
                    </div>
                    </li>
                    </ul>
                </div>
        </div>
        </nav> <!--Nav End-->
        </div>

        <!-- <header>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="logout.php">Logout</a>
    </nav>
</header> -->
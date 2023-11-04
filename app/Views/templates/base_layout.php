<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Car rental service | Hello Shuttle</title>
    <meta name="description" content="High-quality car rental service in California United States. Call us at 9498005678 for best deal">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Place favicon.png in the root directory -->
    <link rel="shortcut icon" href="<?= base_url('static/images/logo/favicons/32x36.png') ?>" type="image/x-icon" />
    <!-- Font Icons css -->
    <link rel="stylesheet" href="<?= base_url('static/css/theme/font-icons.css') ?>">
    <!-- plugins css -->
    <link rel="stylesheet" href="<?= base_url('static/css/theme/plugins.css') ?>">
    <link rel="stylesheet" href="<?= base_url('static/css/vendors/bootstrap.min.css') ?>">
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="<?= base_url('static/css/theme/style.css') ?>">
    <!-- Responsive css -->
    <link rel="stylesheet" href="<?= base_url('static/css/theme/responsive.css') ?>">

    <link rel="stylesheet" href="<?= base_url('static/css/vendors/bootstrap-vue.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('static/css/vendors/bootstrap-vue-icons.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('static/css/theme-custom.css?v=' . now()) ?>">
    <link rel="stylesheet" href="<?= base_url('static/css/theme-custom-responsive.css?v=' . now()) ?>">

    <?= $this->renderSection("page-custom-style") ?>
</head>

<body>
    <!--[if lte IE 9]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
    <![endif]-->

    <!-- Add your site or application content here -->

<!-- Body main wrapper start -->
<div class="body-wrapper">

    <!-- HEADER AREA START (header-4) -->
    <header class="ltn__header-area ltn__header-4 ltn__header-6 ltn__header-transparent">
        <!-- ltn__header-top-area start -->
        <div class="ltn__header-top-area top-area-color-white">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="top-bar-right text-right">
                            <div class="ltn__top-bar-menu">
                                <ul>
                                    <li>
                                        <!-- ltn__social-media -->
                                        <div class="ltn__social-media">
                                            <ul>
                                                <li><a href="javascript:void(0)" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                                                <li><a href="javascript:void(0)" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                                                <li><a href="javascript:void(0)" title="Instagram"><i class="fab fa-instagram"></i></a></li>
                                                <li><a href="javascript:void(0)" title="Dribbble"><i class="fab fa-dribbble"></i></a></li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ltn__header-top-area end -->
        <!-- ltn__header-middle-area start -->
        <div class="ltn__header-middle-area ltn__header-sticky ltn__sticky-bg-black">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <a href="<?= base_url('/') ?>">
                            <img src="<?= base_url('static/images/logo/hello-shuttle-gold-hand-white-text.png') ?>" alt="hello-shuttle-logo" style="max-height: 100px;">
                        </a>
                    </div>
                    <div class="col-12 col-lg-4 mt-3 mt-lg-0">
                        <div class="get-support get-support-color-white">
                            <div class="get-support-icon">
                                <i class="icon-call"></i>
                            </div>
                            <div class="get-support-info">
                                <h4><a href="tel:9498005678" target="_blank">(949) 800-5678</a></h4>
                            </div>
                        </div>
                        <div class="get-support get-support-color-white">
                            <div class="get-support-icon">
                                <i class="icon-mail"></i>
                            </div>
                            <div class="get-support-info">
                                <h4 style="font-size: 1.7rem;"><a href="mailto:info@helloshuttle.com" target="_blank">info@helloshuttle.com</a></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-2 mt-3 mt-lg-0 text-center">
                        <a
                            class="align-items-center btn btn-primary d-inline-flex"
                            href="<?= $dashboardUrl ?>"
                            target="blank">
                            Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- ltn__header-middle-area end -->
    </header>
    <!-- HEADER AREA END -->

    <div class="ltn__utilize-overlay"></div>

    <!-- CAR DEALER FORM AREA START -->
    <?= $this->renderSection("main-content") ?>
    <!-- CAR DEALER FORM AREA END -->

    <!-- FOOTER AREA START (ltn__footer-2 ltn__footer-color-1) -->
    <footer class="ltn__footer-area ltn__footer-2 ltn__footer-color-1">
        <div class="footer-top-area footer-top-extra-padding  section-bg-2 bg-image">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="footer-widget footer-about-widget clearfix">
                            <h4 class="footer-title">About Us.</h4>
                            <p>
                                Our Shuttle services provide a reliable, comfortable, and cost-effective transportation solution for various occasions. 
                                Whether you need transportation for a business trip, family vacation, or special event, 
                                shuttle services offer a convenient and stress-free way to reach your destination.
                            </p>
                            <div class="ltn__social-media-4">
                                <ul>
                                    <li><a href="javascript:void(0)" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="javascript:void(0)" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="javascript:void(0)" title="Behance"><i class="fab fa-behance"></i></a></li>
                                    <li><a href="javascript:void(0)" title="Youtube"><i class="fab fa-youtube"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ltn__copyright-area ltn__copyright-2">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="row">
                            <div class="col-12 col-lg-4">
                                <div class="site-logo">
                                    <a href="<?= base_url('/') ?>">
                                        <img src="<?= base_url('static/images/logo/hello-shuttle-gold-hand-white-text-01.png') ?>" alt="hello-shuttle-logo">
                                    </a>
                                </div>
                            </div>
                            <div class="col-12 col-lg-8 mt-4 mt-lg-0">
                                <div class="get-support ltn__copyright-design">
                                    <div class="get-support-info">
                                        <h6 class="text-white">&copy; <?= date('Y') ?> HelloShuttle. All Rights Reserved.</h6>
                                        <h4 class="font-weight-normal">
                                            Designed by <a href="https://www.dannythedesigner.com" target="_blank">DannyTheDesigner</a>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12 align-self-center">
                        <div class="ltn__copyright-menu text-right">
                            <ul>
                                <li><a href="javascript:void(0)">Terms & Conditions</a></li>
                                <li><a href="javascript:void(0)">Claim</a></li>
                                <li><a href="<?= base_url('policy') ?>">Privacy & Policy</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- FOOTER AREA END -->

</div>
<!-- Body main wrapper end -->

<!-- preloader area start -->
<div class="preloader d-none" id="preloader">
    <div class="preloader-inner">
        <div class="spinner">
            <div class="dot1"></div>
            <div class="dot2"></div>
        </div>
    </div>
</div>
<!-- preloader area end -->

<!-- All JS Plugins -->
<script src="<?= base_url('static/js/theme/plugins.js') ?>"></script>
<!-- Main JS -->
<script src="<?= base_url('static/js/theme/main.js') ?>"></script>

<?= $this->renderSection("page-scripts") ?>
</body>
</html>
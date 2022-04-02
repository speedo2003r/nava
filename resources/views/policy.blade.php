<!DOCTYPE html>
<html lang="ar">


<head>
    <!-- Basic Page Needs -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="description" content="{{settings('meta_desc')}}">
    <meta name="keyword" content="{{settings('meta_keyword')}}">


    <!-- Page Title -->
    <title> {{settings('sitename')}}</title>

    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="landing-nafa/img/nafalogo.png">
    <link rel="stylesheet" href="{{asset('admin/toastr/toastr.min.css')}}">


    <!--
        Google Font
        ================================================== -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">

    <!--
        CSS Files
        ================================================== -->

    <!-- Plugins -->
    <link rel="stylesheet" href="landing-nafa\css\plugins.css">
    <!-- Bootstrap RTL -->
    <link rel="stylesheet" href="landing-nafa\css\bootstrap-rtl.min.css">
    <!-- Main Style -->
    <link rel="stylesheet" href="landing-nafa\css\style.css">
    <link rel="stylesheet" href="landing-nafa\css\style_rtl.css">
    <link rel="stylesheet" href="landing-nafa\css\colors\theme-color.css" class="color-scheme">

    <!-- Modernizer Script for old Browsers -->
    <script src='landing-nafa\js\modernizr-2.6.2.min.js'></script>
</head>

<body>

<header id="home02" class="home02 bg-image">
    <div class="overlay">

        <div class="container">
            <div class="row">
                <!-- Start Text Header -->
                <div class="col-md-7 col-sm-12">
                    <div class="header-inner">
                        <div class="header-content">

                            <h1 class="home-title wow fadeInUp" data-wow-delay="0.4s" data-wow-duration="1s">
                                {{awtTrans('مرحبا بك في نافا')}}
                            </h1>
                            <h4 class="wow fadeInUp" data-wow-delay="0.6s" data-wow-duration="1s">
                                {{awtTrans(' كم مكالمة ودك تسوي لين ما توصل لعامل يكون مرة بارع و محترف ؟ كثيرة صح ؟
                                الحين .. وليش لتصبر ؟! تطبيق نافا يوفر لك الخدمات اللي تبي تنفذها بسرعة و بدقة و دون زهق
                                فقط تحمل التطبيق من')}}

                            </h4>
                            <div class="bttn-head">
                                <a href="{{settings('googleStore')}}" class="bttn-appnova-gradient wow fadeInUp"
                                   data-wow-delay="0.6s" data-wow-duration="1s">
                                    <i class="fa fa-android"></i>
                                    <span>{{awtTrans('جوجل')}}</span>
                                </a>
                                <a style="margin-right: 30px;" href="{{settings('appleStore')}}" class="bttn-appnova-gradient wow fadeInUp"
                                   data-wow-delay="0.8s" data-wow-duration="1s">
                                    <i class="fa fa-apple"></i>
                                    <span> {{awtTrans('أبل')}} </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Text Header -->
                <!-- Start Photo Here -->
                <div class="col-md-5 col-sm-12 hidden-sm hidden-xs">
                    <div class="photo-header">
                        <img src="landing-nafa\img\header-device.png" alt="Appnova Screen" class="img-responsive wow fadeInRight"
                             data-wow-delay=".4s" data-wow-duration="1s">
                        <img src="landing-nafa\img\header-device.png" alt="Appnova Screen" class="img-responsive wow fadeInRight"
                             data-wow-delay=".6s" data-wow-duration="1s">
                    </div>
                </div>
                <!-- End Photo Here -->
            </div>
        </div>
        <!-- End Container -->
    </div>
    <!-- End Overlay -->
</header>
<!--
    End Color Switcher
    ==================================== -->

<!--
    Start Header
    ==================================== -->

<section class="text-center">
    <div class="container">
        <h3>{{$page['title']}}</h3>
        <p>
            {{$page['desc']}}
        </p>
    </div>
</section>


<footer id="footer02" class="footer02">
    <div class="container">
        <!-- Start Copyright & Social Links -->
        <div class="row secRowFooter">
            <!-- Start Copyright -->
            <div class="col-md-8 col-sm-6 wow fadeInUp" data-wow-duration="1s">
                <div class="copyright-design">
                    <p><span>  </span> ©{{\Carbon\Carbon::now()->format('Y')}}{{awtTrans(' جميع الحقوق محفوظة')}}</p>
                </div>
            </div>
            <!-- End Copyright -->
            <!-- Start Social Links -->
            <div class="col-md-4 col-sm-6 wow fadeInUp" data-wow-duration="1s">
                <div class="footer-links text-center">
                    <a class="social-gradient" href="{{socials('facebook')}}"><i class='fa fa-facebook'></i></a>
                    <a class="social-gradient" href="{{awtTrans('twitter')}}"><i class='fa fa-twitter'></i></a>
                </div>
            </div>
            <!-- End Social Links -->
        </div>
        <!-- End Copyright & Social Links -->
    </div><!-- end container -->
</footer><!-- end footer02 -->

<div id="loading-mask">
    <div class="loader">
        <div class="loader-inner"></div>
        <div class="loader-inner"></div>
        <div class="loader-inner"></div>
        <div class="loader-inner"></div>
        <div class="loader-inner"></div>
        <div class="loader-inner"></div>
        <div class="loader-inner"></div>
        <div class="loader-inner"></div>
    </div>
</div>

<!--
    End Preloader
    ==================================== -->

<!--
    JS Files
    ==================================== -->

<!-- Plugins -->
<script src="landing-nafa/js/plugins.js"></script>
<script src="{{dashboard_url('js/map.js')}}"></script>
<!-- Google Map js -->
<script src="https://maps.googleapis.com/maps/api/js?key={{settings('map_key')}}"></script>

<!-- Custom JS -->
<script src="landing-nafa/js/custom_rtl.js"></script>
<script src="{{dashboard_url('admin/toastr/toastr.min.js')}}"></script>

@include('admin.partial.alert')
@include('admin.partial.confirm_delete')
</body>
</html>

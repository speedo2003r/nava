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

<!--
    End Color Switcher
    ==================================== -->

<!--
    Start Header
    ==================================== -->

<header id="home02" class="home02 bg-image">
    <div class="overlay">

        <!-- Start Navigation Bar -->

        <nav class="navbar navbar-default nav-sec navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="custom-logo" href="" title="nava"><img src="landing-nafa\img\nafalogo.png"
                                                                     alt="nafa Logo"></a>
                </div>
                <!-- / navbar-header -->
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-left">
                        <li class="active"><a href="#home02"><span>{{awtTrans('الرئيسية')}}</span></a></li>
                        <li class="active"><a href="#about02"><span>{{awtTrans('كيف يعمل')}}</span></a></li>
                        <li><a href="#features02"><span>{{awtTrans('خدماتنا')}}</span></a></li>
                        <li><a href="#random-feat02"><span>{{awtTrans('عن التطبيق')}}</span></a></li>
                        <li><a href="#contact02"><span>{{awtTrans('إتصل بنا')}}</span></a></li>
                        @if(app()->getLocale() == 'ar')
                            <li><a href="{{route('change.language','en')}}">
                                 <span>En</span>
                                </a></li>
                        @else
                            <li><a href="{{route('change.language','ar')}}">
                                 <span>Ar</span>
                                </a></li>
                        @endif
                    </ul>
                </div>
                <!-- end nav-collapse -->
            </div>
            <!-- end container -->
        </nav>

        <!-- End Navigation Bar -->

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
<!-- End Header -->

<!--
    End Header
    ==================================== -->

<!--
    Start About Section
    ==================================== -->

<section id="about02" class="about02 pdd100">
    <div class="container">
        <!-- Start Section Title -->
        <div class="row">
            <div class="col-md-12">
                <div class="section-title02">
                    <h4 class="wow fadeInUp" data-wow-delay=".2s" data-wow-duration="1s">{{awtTrans('كيف يعمل')}}</h4>
                    <div class="section-title02-icon wow fadeInUp" data-wow-delay=".4s" data-wow-duration="1s">
                        <i class="ion-android-star"></i>
                        <i class="ion-android-star"></i>
                        <i class="ion-android-star"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Section Title -->
        <div class="row">
            <!-- Start Left Side -->
            <div class="col-md-4">
                <div class="left-aboutApp">
                    <!-- Start Single Feature -->
                    <div class="single-feat02 mg60btt flrItem wow fadeInLeft" data-wow-duration="1s">
                        <div class="icon-feat active-service" data-owl-item="0">
                            <i class="fa fa-eye"></i>
                        </div>
                        <div class="text-feat">
                            <h4>{{awtTrans('نظرة عامة')}}</h4>
                            <p>
                                {{awtTrans('اضغط على زر تسجيل وسيظهر لك صفحة جديدة قم بملئ البيانات المطلوبة واخيرا اضغط على زر
                                تفعيل')}}
                            </p>
                        </div>
                    </div>
                    <!-- End Single Feature -->
                    <!-- Start Single Feature -->
                    <div class="single-feat02 flrItem wow fadeInLeft" data-wow-duration="1s">
                        <div class="icon-feat" data-owl-item="1">
                            <i class="fa fa-location-arrow"></i>
                        </div>
                        <div class="text-feat">
                            <h4>{{awtTrans('العنوان')}}</h4>
                            <p> {{awtTrans('يمكنك تحديد المكان من خلال خرائط جوجل')}} </p>
                        </div>
                    </div>
                    <!-- End Single Feature -->
                </div>
            </div>
            <!-- End Left Side -->
            <!-- Start Center -->
            <div class="col-md-4">
                <div class="feat02-slider owl-carousel owl-theme wow fadeInUp" data-wow-duration="1s">
                    <div class="item">
                        <a href="javascript:void(0)">
                            <img src="landing-nafa\img\about\01.png" class="img-responsive screen-popup1" alt="appnova">
                        </a>
                    </div>
                    <div class="item">
                        <a href="javascript:void(0)">
                            <img src="landing-nafa\img\about\02.png" class="img-responsive screen-popup2" alt="appnova">
                        </a>
                    </div>
                    <div class="item">
                        <a href="javascript:void(0)">
                            <img src="landing-nafa\img\about\03.png" class="img-responsive screen-popup" alt="appnova">
                        </a>
                    </div>
                    <div class="item">
                        <a href="javascript:void(0)">
                            <img src="landing-nafa\img\about\04.png" class="img-responsive screen-popup" alt="appnova">
                        </a>
                    </div>
                </div>
            </div>
            <!-- End Center -->
            <!-- Start Right Side -->
            <div class="col-md-4">
                <div class="right-aboutApp">
                    <!-- Start Single Feature -->
                    <div class="single-feat02 mg60btt fllItem wow fadeInRight" data-wow-duration="1s">
                        <div class="icon-feat" data-owl-item="2">
                            <i class="fa fa-cubes"></i>
                        </div>
                        <div class="text-feat">
                            <h4>{{awtTrans('الخدمات')}}</h4>
                            <p> {{awtTrans('يمكنك اختيار الخدمة المراد تنفيذها')}} </p>

                        </div>
                    </div>
                    <!-- End Single Feature -->
                    <!-- Start Single Feature -->
                    <div class="single-feat02 fllItem wow fadeInRight" data-wow-duration="1s">
                        <div class="icon-feat" data-owl-item="3">
                            <i class="fa fa-list-ol"></i>
                        </div>
                        <div class="text-feat">
                            <h4>{{awtTrans('الفاتورة')}}</h4>
                            <p> {{awtTrans('معرفة تفاصيل الفاتورة الخاصة بك')}} </p>
                        </div>
                    </div>
                    <!-- End Single Feature -->
                </div>
            </div>
            <!-- End Right Side -->

        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end about02 -->

<!--
    End About Section
    ==================================== -->

<!--
    Start Features Section
    ==================================== -->

<section id="features02" class="features02">
    <div class="overlay pdd100">
        <!-- CONTAINER -->
        <div class="container" data-appear-top-offset="-200" data-animated="fadeInUp">

            <!-- CASTOM TAB -->
            <div id="myTabContent" class="tab-content wow fadeInUp" data-wow-duration="1s">
                <!-- Start Single Item -->
                <div class="tab-pane fade in active clearfix" id="tab1">
                    <p class="title">كهرباء</p>
                    <span> صيانة وحدات الكهرباء
                                تركيب وحدات الإضاءة
                                 شد السلوك بالقوة المطلوبة
                                توزيع اماكن تواجد الكهرباء
                                تركيب وحدات الكهرباء
                                اصلاح الاعطال
                                معاينة مفاتيح الكهرباء
                                الصيانة الدورية للكهرباء
                                </span>
                </div>
                <!-- End Single Item -->
                <!-- Start Single Item -->
                <div class="tab-pane fade clearfix" id="tab2">
                    <p class="title">سباكة</p>
                    <span> صيانة مواسير الماء والصرف الصحي
                                صيانة الأدوات الصحية
                                صيانة قاعدة الحمام والدش و الكابينة
                                صيانة مواتير المياه والفلاتر
                                </span>
                </div>
                <!-- End Single Item -->
                <!-- Start Single Item -->
                <div class="tab-pane fade clearfix" id="tab3">
                    <p class="title">تكييف</p>
                    <span>تنظيف فلتر الماء
                                 صيانة المكيفات بالكامل
                                 صيانة الأعطال
                                 فحص المكيفات الدورية
                                 شراء مكيفات جديد</span>
                </div>
                <!-- End Single Item -->
                <!-- Start Single Item -->
                <div class="tab-pane fade clearfix" id="tab4">
                    <p class="title">نظافة</p>
                    <span>- تنظيف البيت بنظام الساعة
                                 جلي الرخام
                                 تنظيف الأثاث
                                 تنظيف السجاد والموكيت
                                 تنظيف المطابخ والحمامات
                                 تنظيف الارضيات والاسقف
                                </span>
                </div>
                <!-- End Single Item -->
            </div>
            <!-- Start Tab Link -->
            <ul id="myTab" class="nav nav-tabs wow fadeInUp" data-wow-duration="1s">
                <li class="active">
                    <a class="i1" href="#tab1" data-toggle="tab">
                        <img src="landing-nafa/img/svg/light-bulb.svg" width="30px" alt="" srcset=""> <span> كهرباء</span>
                    </a>
                </li>
                <li>
                    <a class="i2" href="#tab2" data-toggle="tab">
                        <img src="landing-nafa/img/svg/sink.svg" width="30px" alt="" srcset=""></i> <span> سباكة</span>
                    </a>
                </li>
                <li>
                    <a class="i3" href="#tab3" data-toggle="tab">
                        <img src="landing-nafa/img/svg/minisplit.svg" width="30px" alt="" srcset=""> <span>تكييف </span>
                    </a>
                </li>
                <li>
                    <a class="i4" href="#tab4" data-toggle="tab">
                        <img src="landing-nafa/img/svg/maid.svg" width="30px" alt="" srcset=""> <span>نظافة</span>
                    </a>
                </li>

            </ul>
            <!-- End Tab Link -->
            <!-- CASTOM TAB -->
        </div>
        <!-- //CONTAINER -->
    </div><!-- end overlay -->
</section><!-- end features02 -->

<!--
    End Features Section
    ==================================== -->

<!--
    Start Random Features
    ==================================== -->

<section id="random-feat02" class="random-feat02 pdd100">
    <div class="container">
        <div class="row">
            <!-- Start Single Item -->
            <div class="col-md-12">
                <div class="single-work02 mgbtt100">
                    <div class="row">
                        <!-- Start Photo -->
                        <div class="col-md-6 wow fadeInRight" data-wow-duration="1s">
                            <div class="work02-photo">
                                <img src="landing-nafa/img\timeline\02.png" alt="appnova" class="img-responsive">
                            </div>
                        </div>
                        <!-- End Photo -->
                        <!-- Start Text -->
                        <div class="col-md-6 wow fadeInLeft" data-wow-duration="1s">
                            <div class="work02-text">
                                <h4>{{awtTrans('تحديد موقعك وتأكيد الطلب')}}</h4>
                                <p>{{awtTrans(' من خلال زر الموقع، يمكنك فتح الـ GPS، أو ادخال الموقع يدويا، وستتمكن من')}} </p>
                                <div class="work02-text-points">
                                    <p><i class="fa fa-check"></i> {{awtTrans('تتبع الطلب')}}  </p>
                                    <p><i class="fa fa-check"></i> {{awtTrans('رؤية الخريطة بالكامل')}}  </p>
                                    <p> <i class="fa fa-check"></i> {{awtTrans('الحصول على الاتجاه')}}  </p>
                                </div>
                                <div class="work02-butt">

                                </div>
                            </div>
                        </div>
                        <!-- End Text -->
                    </div>
                </div>
            </div>
            <!-- End Single Item -->
            <!-- Start Single Item -->
            <div class="col-md-12">
                <div class="single-work02">
                    <div class="row">
                        <!-- Start Photo -->
                        <div class="col-md-6 col-md-push-6 wow fadeInRight" data-wow-duration="1s">
                            <div class="work02-photo">
                                <img src="landing-nafa/img\timeline\01.png" alt="appnova" class="img-responsive">
                            </div>
                        </div>
                        <!-- End Photo -->
                        <!-- Start Text -->
                        <div class="col-md-6 col-md-pull-6 wow fadeInLeft" data-wow-duration="1s">
                            <div class="work02-text">
                                <h4>{{awtTrans('ادخل طريقة الدفع التي تبيها عن طريق الابلكيشن ( نقدي و فيزا)')}}</h4>
                                <p> {{awtTrans('سياسة التعامل في حالة النقدي')}} </p>
                                <div class="work02-text-points">
                                    <p><i class="fa fa-check"></i>{{awtTrans(' ستظهر لك ثمن الخدمة بعد تصليح العطل علي الابلكيشن')}} </p>
                                    <p><i class="fa fa-check"></i> {{awtTrans('يتم الدفع للعامل وأخذ المتبقي')}}</p>
                                    <p><i class="fa fa-check"></i>{{awtTrans(' يرجى العلم ان في حالة تكرار العطل في خلال 48 ساعة
                                        يتم إرسال العامل مرة أخرى وتكون تكلفة مجانية 100%')}} </p>
                                </div>
                                <div class="work02-butt">

                                </div>
                            </div>
                        </div>
                        <!-- End Text -->
                    </div>
                </div>
            </div>
            <!-- End Single Item -->
        </div><!-- end row -->
    </div><!-- end container -->
</section><!-- end random-feat02 -->

<!--
    End Random Features
    ==================================== -->



<!--
    Start Video Section
    ==================================== -->

<section id="video-app02" class="video-app02">
    <div class="overlay pdd100">
        <div class="container">
            <div class="row">
                <!-- Start Video Place -->
                <div class="col-md-5" id="video-top">
                    <div class="videoApp-text wow fadeInLeft" data-wow-duration="1s">
                        <h4>{{awtTrans('شاهد الفيديو')}}</h4>
                        <p>{{awtTrans('ابقي على اطلاع على آخر أخبار نافا وشاهد الفيديو. ')}}</p>
                    </div>
                    <div class="videoApp-button">

                    </div>
                </div>
                <div class="col-md-7">
                    <div class="videoApp-place wow fadeInRight" data-wow-duration="1s">
                        <div class="videoApp-overlay">
                            <!-- Add Video Link Here -->
                            <a href="{{settings('into_video')}}" data-lity=""><i
                                    class="fa fa-play"></i></a>
                        </div>
                    </div>
                    <div class="bg-videoApp"></div>
                </div>
                <!-- End Video Place -->
                <!-- Start Video Text -->
                <div class="col-md-5" id="video-bottom">
                    <div class="videoApp-text wow fadeInLeft" data-wow-duration="1s">
                        <h4>{{awtTrans('شاهد الفيديو')}}</h4>
                        <p>{{awtTrans('ابقي على اطلاع على آخر أخبار نافا وشاهد الفيديو. ')}}</p>
                    </div>
                    <div class="videoApp-button">

                    </div>
                </div>
                <!-- End Video Text -->
            </div><!-- end row -->
        </div><!-- end container -->
    </div><!-- end overlay -->
</section><!-- end video-app02 -->

<!--
    End Video Section
    ==================================== -->
<!--
    Start Screenshots Section
    ==================================== -->

<section id="screenshots02" class="screenshots02 pdd100">
    <div class="container">
        <!-- Start Section Title -->
        <div class="row">
            <div class="col-md-12">
                <div class="section-title02">
                    <h4 class="wow fadeInUp" data-wow-delay=".2s" data-wow-duration="1s">{{awtTrans('لقطات')}}</h4>
                    <div class="section-title02-icon wow fadeInUp" data-wow-delay=".4s" data-wow-duration="1s">
                        <i class="ion-android-star"></i>
                        <i class="ion-android-star"></i>
                        <i class="ion-android-star"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Section Title -->
        <!-- Start Screenshots Content -->
        <div class="main_drag">
            <!-- Start Mobile Mockup -->
            <div class="mockup-mobile-slider">
                <img src="landing-nafa/img\mobile-slider.png" alt="appnova">
            </div>
            <!-- End Mobile Mockup -->
            <!-- Start Mobile Slider Content -->
            <div class="swiper-screenshots02 wow fadeInUp" data-wow-duration="1s">
                <div class="swiper-wrapper">
                    <!-- Start Single Photo -->
                    <div class="swiper-slide" data-swiper-autoplay="3000">
                        <img alt="appnova" src="landing-nafa/img\about\01.png" class="img-responsive">
                    </div>
                    <!-- End Single Photo -->
                    <!-- Start Single Photo -->
                    <div class="swiper-slide" data-swiper-autoplay="3000">
                        <img alt="appnova" src="landing-nafa/img\about\02.png" class="img-responsive">
                    </div>
                    <!-- End Single Photo -->
                    <!-- Start Single Photo -->
                    <div class="swiper-slide" data-swiper-autoplay="3000">
                        <img alt="appnova" src="landing-nafa/img\about\03.png" class="img-responsive">
                    </div>
                    <!-- End Single Photo -->
                    <!-- Start Single Photo -->
                    <div class="swiper-slide" data-swiper-autoplay="3000">
                        <img alt="appnova" src="landing-nafa/img\about\04.png" class="img-responsive">
                    </div>
                    <!-- End Single Photo -->
                    <!-- Start Single Photo -->
                    <div class="swiper-slide" data-swiper-autoplay="3000">
                        <img alt="appnova" src="landing-nafa/img\about\05.png" class="img-responsive">
                    </div>
                    <!-- End Single Photo -->
                    <!-- Start Single Photo -->
                    <div class="swiper-slide" data-swiper-autoplay="3000">
                        <img alt="appnova" src="landing-nafa/img\about\03.png" class="img-responsive">
                    </div>
                    <!-- End Single Photo -->
                </div>
            </div>
            <!-- End Mobile Slider Content -->
        </div>
        <!-- End Screenshots Content -->
    </div><!-- end container -->
</section><!-- end screenshots02 -->

<!--
    End Screenshots Section
    ==================================== -->








<!--
    Start Contact Section
    ==================================== -->

<section id="contact02" class="contact02">
    <div class="overlay pdd100">
        <div class="container">
            <!-- Start Section Title -->
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title02">
                        <h4 class="wow fadeInUp" data-wow-delay=".2s" data-wow-duration="1s">{{awtTrans('إتصل بنا')}}</h4>
                        <div class="section-title02-icon wow fadeInUp" data-wow-delay=".4s" data-wow-duration="1s">
                            <i class="ion-android-star"></i>
                            <i class="ion-android-star"></i>
                            <i class="ion-android-star"></i>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Section Title -->
            <!-- Start Form Place -->
            <div class="form-place">
                <div class="row">
                    <!-- Start Info -->
                    <div class="col-md-4">
                        <!-- Start Single Item -->
                        <div class="single-contact02 ffl50 wow fadeInUp" data-wow-duration="1s">
                            <div class="contact02-icon">
                                <i class="ion-ios-location"></i>
                            </div>
                            <div class="contact02-text">
                                <h4>{{awtTrans('العنوان')}}</h4>
                                <p>{{settings('address')}}</p>
                            </div>
                        </div>
                        <!-- End Single Item -->
                        <!-- Start Single Item -->
                        <div class="single-contact02 ffr50 wow fadeInUp" data-wow-duration="1s">
                            <div class="contact02-icon">
                                <i class="ion-ios-email"></i>
                            </div>
                            <div class="contact02-text">
                                <h4>{{awtTrans('البريد الالكتروني')}}</h4>
                                <p><a href="mailto: {{settings('email')}}">{{settings('email')}}</a></p>
                            </div>
                        </div>
                        <!-- End Single Item -->
                        <!-- Start Single Item -->
                        <div class="single-contact02 ffl50 wow fadeInUp" data-wow-duration="1s">
                            <div class="contact02-icon">
                                <i class="ion-ios-telephone"></i>
                            </div>
                            <div class="contact02-text">
                                <h4>{{awtTrans('الهاتف')}}</h4>
                                <p> <a class="text-white" href="tel:{{settings('phone')}}">{{settings('phone')}}</a></p>
                            </div>
                        </div>
                        <!-- End Single Item -->
                        <!-- Start Single Item -->
                        <div class="single-contact02 ffr50 wow fadeInUp" data-wow-duration="1s">
                            <div class="contact02-icon">
                                <i class="ion-ios-world"></i>
                            </div>
                            <div class="contact02-text">
                                <h4>{{awtTrans('الموقع')}}</h4>
                                <p><a href="https://navaservices.net/">navaservices.net</a></p>
                                <p><a href="https://navaservices.net/policy">{{awtTrans('الشروط والأحكام')}}</a></p>
                            </div>
                        </div>
                        <!-- End Single Item -->
                    </div>
                    <!-- End Info -->
                    <!-- Start Contact Form -->
                    <div class="col-md-8">
                        <div class="form-touch wow fadeInUp" data-wow-duration="1s">
                            <form action="{{route('front.contact')}}" method="post">
                                @csrf()
                                <div class="row">
                                    <!-- Start Single Input -->
                                    <div class="col-md-12">
                                        <div class="single-input">
                                            <input type="text" name="name" placeholder="{{awtTrans('الإسم بالكامل')}}" >
                                        </div>
                                    </div>
                                    <!-- End Single Input -->
                                    <!-- Start Single Input -->
                                    <div class="col-md-12">
                                        <div class="single-input">
                                            <input type="number" name="phone" placeholder="{{awtTrans('الجوال')}}" >
                                        </div>
                                    </div>
                                    <!-- End Single Input -->
                                    <!-- Start Single Input -->
                                    <div class="col-md-12">
                                        <div class="single-input">
                                            <input type="email" name="email" placeholder="{{awtTrans('البريد الألكتروني')}}" >
                                        </div>
                                    </div>
                                    <!-- End Single Input -->
                                    <!-- Start Single Textarea -->
                                    <div class="col-md-12">
                                        <div class="single-input">
                                            <textarea name="message" placeholder="{{awtTrans('محتوى الرسالة')}}" ></textarea>
                                        </div>
                                    </div>
                                    <!-- End Single Textarea -->
                                    <!-- Start Send Button -->
                                    <div class="col-md-12">
                                        <div class="button-MSG" style="text-align:left">
                                            <button type="submit" class="bttn-appnova-gradient">
                                                <i class="fa fa-paper-plane"></i>
                                                <span>{{awtTrans('إرسال')}}</span>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- End Send Button -->
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- End Contact Form -->
                </div><!-- end row -->

            </div>
            <!-- End Form Place -->
        </div><!-- end container -->
    </div><!-- end overlay -->
</section><!-- end contact02 -->

<!--
    End Contact Section
    ==================================== -->

<!--
    Start Map Section
    ==================================== -->

<section class="map-section">
    <!-- Start Google Map -->
    <div class="google-map-area">
        <div id="contacts" class="map-area">
            <div id="googleMap" style="width:100%;height:395px;"></div>
        </div>
    </div>
    <!-- End Google Map -->
    <!-- Start Map Controls -->
    <div class="button-map wow fadeInLeft" data-wow-duration="1s">
        <button class="open-map"><i class="ion-ios-location"></i></button>
        <button class="close-map"><i class="ion-android-close"></i></button>
    </div>
    <!-- End Map Controls -->
</section><!-- end map-section -->

<!--
    End Map Section
    ==================================== -->

<!--
    Start Footer Section
    ==================================== -->

<footer id="footer02" class="footer02">
    <div class="container">
        <!-- Start Copyright & Social Links -->
        <div class="row secRowFooter">
            <!-- Start Copyright -->
            <div class="col-md-8 col-sm-6 wow fadeInUp" data-wow-duration="1s">
                <div class="copyright-design">
                    <p><span>  </span> ©{{\Carbon\Carbon::now()->format('Y')}} {{awtTrans(' جميع الحقوق محفوظة لصالح شركة اعمال نافا للتشغيل والصيانة')}}</p>
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

<!--
    End Footer Section
    ==================================== -->

<!--
    Start Back To Top
    ==================================== -->

<div id="scroll-top">
    <i class="fa fa-angle-up fa-2x"></i>
</div>

<!--
    End Back To Top
    ==================================== -->

<!--
    Start Preloader
    ==================================== -->

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

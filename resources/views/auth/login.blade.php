<!DOCTYPE html>

<html lang="en" direction="rtl" dir="rtl" style="direction: rtl">
<!-- begin::Head -->

<head>
    <!--end::Base Path -->
    <meta charset="utf-8" />

    <title>{{ settings('site_name') }} | {{awtTrans('تسجيل الدخول')}}</title>
    <meta name="description" content="Login page example">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--begin::Fonts -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">
    <!--end::Fonts -->


    <!--begin::Page Custom Styles(used by this page) -->
    <link href="{{ asset('assets/css/demo1/pages/login/login-6.rtl.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Page Custom Styles -->

    <!--begin:: Global Mandatory Vendors -->
    <link href="{{ asset('assets/vendors/general/perfect-scrollbar/css/perfect-scrollbar.rtl.css') }}" rel="stylesheet"
        type="text/css" />
    <!--end:: Global Mandatory Vendors -->


    <!--begin::Global Theme Styles(used by all pages) -->

    <link href="{{ asset('assets/css/demo1/style.bundle.rtl.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles -->
    <!--begin::Layout Skins(used by all pages) -->

    <link href="{{ asset('assets/css/demo1/skins/header/base/light.rtl.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/demo1/skins/header/menu/light.rtl.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/demo1/skins/brand/dark.rtl.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/demo1/skins/aside/dark.rtl.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Layout Skins -->
    <link rel="stylesheet" href="{{asset('admin/toastr/toastr.min.css')}}">

    <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />
</head>
<!-- end::Head -->

<!-- begin::Body -->

<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">


    <!-- begin:: Page -->
    <div class="kt-grid kt-grid--ver kt-grid--root">
        <div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v6 kt-login--signin" id="kt_login">
            <div
                class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--desktop kt-grid--ver-desktop kt-grid--hor-tablet-and-mobile">
                <div
                    class="kt-grid__item  kt-grid__item--order-tablet-and-mobile-2  kt-grid kt-grid--hor kt-login__aside p-0">
                    <div class="kt-login__wrapper p-0">

                        <div class="kt-login__container">
                            <div class="kt-login__body">
                                <div class="kt-login__logo">
                                    <a href="#">
                                        <img src="{{asset('logo/logo-h.png')}}" style="width: 70px;">
                                    </a>
                                </div>



                                <div class="kt-login__signin">
                                    <div class="kt-login__head">
                                        <h3 class="kt-login__title">{{awtTrans('تسجيل الدخول')}}</h3>
                                    </div>
                                    <div class="kt-login__form">
                                        <form action="{{route('admin.login')}}" method="post" class="kt-form'">
                                        @csrf
                                            <input type="hidden" id="fcm_token" name="fcm_token">
                                            <div class="form-group">
                                                <input type="email" name="email" class="form-control p-3" placeholder="{{awtTrans('البريد الاليكتروني')}}">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="password" class="form-control form-control-last p-3" placeholder="{{awtTrans('كلمـة السر')}}">
                                            </div>
                                            <div class="kt-login__extra">
                                                <label class="kt-checkbox">
                                                    <input type="checkbox" name="remember">{{awtTrans(' تذكرنى')}}
                                                    <span></span>
                                                </label>
                                                <a href="javascript:void(0)" id="kt_login_forgot"> {{awtTrans('نسيت كلمة المرور؟')}}</a>
                                            </div>
                                            <div class="kt-login__actions">
                                                <button type="submit" class="btn btn-brand btn-pill btn-elevate" >
                                                    {{awtTrans('تسجيـل الدخول')}}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>


                                <div class="kt-login__forgot">
                                    <div class="kt-login__head">
                                        <h3 class="kt-login__title"> {{awtTrans('نسيت كلمة المرور؟')}}</h3>
                                        <div class="kt-login__desc">{{awtTrans('أدخل بريدك الإلكتروني لإعادة تعيين كلمة المرور
                                            الخاصة بك:')}}</div>
                                    </div>
                                    <div class="kt-login__form">

                                        <form method="post" class="kt-form" action="{{route('password.email')}}">
                                            @csrf
                                            <div class="form-group">
                                                <input type="email" placeholder='{{awtTrans('البريد الآلكتروني')}}' class='form-control' id='kt_email'>
                                            </div>
                                            <div class="kt-login__actions">
                                                <button type="submit"
                                                    class="btn btn-brand btn-pill btn-elevate">{{awtTrans('طلب')}}</button>
                                                <button id="kt_login_forgot_cancel"
                                                    class="btn btn-outline-brand btn-pill">{{awtTrans('إلغاء')}}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div style="padding-bottom: 0px" class="kt-footer  kt-grid__item kt-grid kt-grid--desktop kt-grid--ver-desktop" id="kt_footer">
                            <div class="kt-container  kt-container--fluid ">
                                <div class="kt-footer__copyright" style="padding-top: 10px;">
                                        {{\Carbon\Carbon::now()->format('Y')}} © {{awtTrans('جميع الحقوق محفوظه')}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="kt-grid__item kt-grid__item--fluid kt-grid__item--center kt-grid kt-grid--ver kt-login__content d-none d-lg-block"
                    style="background-image: url({{ asset('/images/587.jpg') }}); background-size: 100% 100%;">
                    <div class="kt-login__section">
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- end:: Page -->


    <!-- begin::Global Config(global config for global JS sciprts) -->
    <script>
        var KTAppOptions = {
            "colors": {
                "state": {
                    "brand": "#5d78ff",
                    "dark": "#282a3c",
                    "light": "#ffffff",
                    "primary": "#5867dd",
                    "success": "#34bfa3",
                    "info": "#36a3f7",
                    "warning": "#ffb822",
                    "danger": "#fd3995"
                },
                "base": {
                    "label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
                    "shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
                }
            }
        };
    </script>
    <!-- end::Global Config -->

    <!--begin:: Global Mandatory Vendors -->
    <script src="{{ asset('assets/vendors/general/jquery/dist/jquery.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/popper.js/dist/umd/popper.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/bootstrap/dist/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/js-cookie/src/js.cookie.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/moment/min/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/tooltip.js/dist/umd/tooltip.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/perfect-scrollbar/dist/perfect-scrollbar.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/sticky-js/dist/sticky.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/wnumb/wNumb.js') }}" type="text/javascript"></script>
    <!--end:: Global Mandatory Vendors -->

    <script src="https://www.gstatic.com/firebasejs/8.4.3/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.4.3/firebase-messaging.js"></script>
    <script src="{{dashboard_url('firebase/notification/getToken.js')}}"></script>
    <script src="{{asset('admin/toastr/toastr.min.js')}}"></script>

    @include('admin.partial.alert')
    @include('admin.partial.confirm_delete')
    <!--begin:: Global Optional Vendors -->
    <!-- <script src="./assets/vendors/general/jquery-form/dist/jquery.form.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/block-ui/jquery.blockUI.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"
        type="text/javascript"></script>
    <script src="./assets/vendors/custom/js/vendors/bootstrap-datepicker.init.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/bootstrap-datetime-picker/js/bootstrap-datetimepicker.min.js"
        type="text/javascript"></script>
    <script src="./assets/vendors/general/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript">
    </script>
    <script src="./assets/vendors/custom/js/vendors/bootstrap-timepicker.init.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js"
        type="text/javascript"></script>
    <script src="./assets/vendors/general/bootstrap-maxlength/src/bootstrap-maxlength.js" type="text/javascript">
    </script>
    <script src="./assets/vendors/custom/vendors/bootstrap-multiselectsplitter/bootstrap-multiselectsplitter.min.js"
        type="text/javascript"></script>
    <script src="./assets/vendors/general/bootstrap-select/dist/js/bootstrap-select.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/bootstrap-switch/dist/js/bootstrap-switch.js" type="text/javascript"></script>
    <script src="./assets/vendors/custom/js/vendors/bootstrap-switch.init.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/select2/dist/js/select2.full.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/ion-rangeslider/js/ion.rangeSlider.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/typeahead.js/dist/typeahead.bundle.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/handlebars/dist/handlebars.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/inputmask/dist/jquery.inputmask.bundle.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/inputmask/dist/inputmask/inputmask.date.extensions.js" type="text/javascript">
    </script>
    <script src="./assets/vendors/general/inputmask/dist/inputmask/inputmask.numeric.extensions.js"
        type="text/javascript"></script>
    <script src="./assets/vendors/general/nouislider/distribute/nouislider.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/owl.carousel/dist/owl.carousel.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/autosize/dist/autosize.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/clipboard/dist/clipboard.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/dropzone/dist/dropzone.js" type="text/javascript"></script>
    <script src="./assets/vendors/custom/js/vendors/dropzone.init.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/quill/dist/quill.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/@yaireo/tagify/dist/tagify.polyfills.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/@yaireo/tagify/dist/tagify.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/summernote/dist/summernote.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/markdown/lib/markdown.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/bootstrap-markdown/js/bootstrap-markdown.js" type="text/javascript"></script>
    <script src="./assets/vendors/custom/js/vendors/bootstrap-markdown.init.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/bootstrap-notify/bootstrap-notify.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/custom/js/vendors/bootstrap-notify.init.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/jquery-validation/dist/jquery.validate.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/jquery-validation/dist/additional-methods.js" type="text/javascript"></script>
    <script src="./assets/vendors/custom/js/vendors/jquery-validation.init.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/toastr/build/toastr.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/dual-listbox/dist/dual-listbox.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/raphael/raphael.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/morris.js/morris.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/chart.js/dist/Chart.bundle.js" type="text/javascript"></script>
    <script src="./assets/vendors/custom/vendors/bootstrap-session-timeout/dist/bootstrap-session-timeout.min.js"
        type="text/javascript"></script>
    <script src="./assets/vendors/custom/vendors/jquery-idletimer/idle-timer.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/waypoints/lib/jquery.waypoints.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/counterup/jquery.counterup.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/es6-promise-polyfill/promise.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/sweetalert2/dist/sweetalert2.min.js" type="text/javascript"></script>
    <script src="./assets/vendors/custom/js/vendors/sweetalert2.init.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/jquery.repeater/src/lib.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/jquery.repeater/src/jquery.input.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/jquery.repeater/src/repeater.js" type="text/javascript"></script>
    <script src="./assets/vendors/general/dompurify/dist/purify.js" type="text/javascript"></script> -->
    <!--end:: Global Optional Vendors -->

    <!--begin::Global Theme Bundle(used by all pages) -->

    <script src="{{ asset('assets/js/demo1/scripts.bundle.js') }}" type="text/javascript"></script>
    <!--end::Global Theme Bundle -->


    <!--begin::Page Scripts(used by this page) -->
    <script src="{{ asset('assets/js/demo1/pages/login/login-general.js') }}" type="text/javascript"></script>
    <!--end::Page Scripts -->
</body>
<!-- end::Body -->

</html>

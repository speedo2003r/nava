<!DOCTYPE html>
<html lang="en" direction="rtl" dir="rtl" style="direction: rtl">
<!-- begin::Head -->

<head>
    <meta charset="utf-8" />
    <title>{{ settings('site_name') }} | @yield('title','لوحة التحكم')</title>
    <meta name="description" content="Datatable HTML table">
    @if(auth()->check())
        <meta name="user_id" content="{{auth()->id()}}">
    @endif
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--begin::Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">
    <!--end::Fonts -->

    <link rel="stylesheet" href="{{dashboard_url('admin/datatables-bs4/css/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{dashboard_url('admin/datatables-responsive/css/responsive.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{dashboard_url('admin/datatables-buttons/css/buttons.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{dashboard_url('admin/datatables-select/css/select.bootstrap4.css')}}">
    <link href="{{asset('assets/css/demo1/button.css')}}" rel="stylesheet" type="text/css" />
    <!--begin:: Global Mandatory Vendors -->
    <link href="{{asset('assets/vendors/general/perfect-scrollbar/css/perfect-scrollbar.rtl.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/vendors/general/morris.js/morris.css')}}" rel="stylesheet" type="text/css" />
    <!--end:: Global Mandatory Vendors -->
    <!--begin::Global Theme Styles(used by all pages) -->
    <link href="{{asset('assets/css/demo1/style.bundle.rtl.css')}}" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles -->
    <!--begin::Layout Skins(used by all pages) -->
    <link href="{{asset('assets/css/demo1/skins/header/base/light.rtl.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/demo1/skins/header/menu/light.rtl.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/demo1/skins/brand/dark.rtl.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/demo1/skins/aside/dark.rtl.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/vendors/custom/vendors/line-awesome/css/line-awesome.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/vendors/general/@fortawesome/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/vendors/general/morris.js/morris.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/vendors/custom/vendors/flaticon2/flaticon.css')}}" rel="stylesheet" type="text/css" />
    <!--end::Layout Skins -->
<!-- <link rel="shortcut icon" href="{{asset('assets/media/logos/favicon.ico')}}" /> -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <link rel="stylesheet" href="{{asset('admin/toastr/toastr.min.css')}}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{dashboard_url('custom.css')}}">
    <link rel="stylesheet" href="{{dashboard_url('custom_ar.css')}}">
</head>
<!-- end::Head -->
<style>
    .kt-menulink-badge{
        margin-top:10px;
    }
    .dt-buttons{
        float: left;
    }
    .position-relative{
        position: relative;
    }
    .span-menu{
        position: absolute;
        left: 25px;
        margin-top: 8px;
    }
    div.dataTables_wrapper div.dataTables_filter{
        text-align: right;
    }
    .form-group input[type="submit"]{
        margin-right:auto;
        display:block;

    }
    .alert {

        margin-top:15px;
    }
    .pagination{
        justify-content:flex-end;
        margin-top:15px;
    }
    .margin-15{
        margin:15px 0;
    }
    .dataTables_wrapper .dataTables_scroll{
        margin:0 !important;
    }
    .modal-danger {
        width: -webkit-fill-available !important
    }

    table td {
        font-size: 12px;
        text-align: center
    }

    table th {
        font-size: 15px;
        text-align: center
    }

    .dataTables_scrollBody {
        max-height: 150vh !important;

    }

    #id {
        width: 15px;
    }

    .file-upload {
        margin-bottom: 15px
    }


    .kt-portlet--height-fluid .kt-widget14__header {
        padding: 20px;
        border-bottom: 1px solid #ebedf2;
    }

    .kt-portlet--height-fluid .kt-widget14__header .kt-widget14__title {
        font-size: 1.3rem;
        font-weight: 500;
        margin-bottom: 0;
        color: #595d6e;
    }
    .today-date {
        font-size: 13px;
    }
    .info-box {
        box-shadow: 0 0 1px rgb(0 0 0 / 13%), 0 1px 3px rgb(0 0 0 / 20%);
        border-radius: 0.25rem;
        background: #ffffff;
        display: -ms-flexbox;
        display: flex;
        margin-bottom: 1rem;
        min-height: 80px;
        padding: .5rem;
        position: relative;
        width: 100%;
    }
    .info-box span i{
        color:#fff;
    }
    .info-box .info-box-icon {
        border-radius: 0.25rem;
        -ms-flex-align: center;
        align-items: center;
        display: -ms-flexbox;
        display: flex;
        font-size: 1.875rem;
        -ms-flex-pack: center;
        justify-content: center;
        text-align: center;
        width: 70px;
    }
    .notify-count,.messages-count{
        position: absolute;
        top: 0;
        right: 5px;
        background: #e70000;
        border-radius: 50%;
        width: 15px;
        height: 15px;
        color: #fff;
        text-align: center;
        line-height: 15px;
    }
    .info-box .info-box-content {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-direction: column;
        flex-direction: column;
        -ms-flex-pack: center;
        justify-content: center;
        line-height: 120%;
        -ms-flex: 1;
        flex: 1;
        padding: 0 10px;
    }
    .info-box .progress-description, .info-box .info-box-text {
        display: block;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .info-box .info-box-number {
        display: block;
        margin-top: .25rem;
        font-weight: 700;
    }
    .today-date #day-history{
        font-size: 12px;
        margin: 0 10px;
        color: #3D9AE2;
        font-weight: 600;
    }

    #iconSear{
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translatey(-50%);
        font-size: 16px;
    }
</style>
<!-- begin::Body -->

<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">
<!-- begin:: Page -->
<!-- begin:: Header Mobile -->
<div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
    <div class="kt-header-mobile__logo">
        <a href="{{url('/')}}">
            <img alt="Logo" src="{{asset('/images/nafalogo1.png')}}" style="width: 110px;height: 45px;" />
        </a>
    </div>
    <div class="kt-header-mobile__toolbar">
        <button class="kt-header-mobile__toggler kt-header-mobile__toggler--left" id="kt_aside_mobile_toggler"><span></span></button>
        <!-- <button class="kt-header-mobile__toggler" id="kt_header_mobile_toggler"><span></span></button> -->
        <button class="kt-header-mobile__topbar-toggler" id="kt_header_mobile_topbar_toggler">
            <span> <i class="fa fa-angle-double-down" style="font-size: 30px;margin-top: 15px;"></i> </span>
        </button>
    </div>
</div>
<!-- end:: Header Mobile -->
<div class="kt-grid kt-grid--hor kt-grid--root">
    <div id="admin" class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
        <!-- begin:: Aside -->
        <!-- Uncomment this to display the close button of the panel
    <button class="kt-aside-close " id="kt_aside_close_btn"><i class="la la-close"></i></button>
            -->
        <div class="kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop" id="kt_aside">
            <!-- begin:: Aside -->
            <div class="kt-aside__brand kt-grid__item " id="kt_aside_brand" style=" height:90px; background:#1e1e2d ">
                <div class="kt-aside__brand-logo" style="width:100%">
                    <a href="/admin" style="margin:auto; display:block">
                        <img alt="Logo" src="{{$logo}}" style="width: 130px; height: 68px;" />
                    </a>
                </div>
                <!-- <div class="kt-aside__brand-tools">
                        <button class="kt-aside__brand-aside-toggler" id="kt_aside_toggler">
                            <i style="color: white" class="fa fa-angle-left"></i>

                        </button>

                <button class="kt-aside__brand-aside-toggler kt-aside__brand-aside-toggler--left" id="kt_aside_toggler"><span></span></button>

                    </div> -->
            </div>
            <!-- end:: Aside -->
            <!-- begin:: Aside Menu -->
            @include('admin.partial.sidebar')

            <!-- end:: Aside Menu -->
        </div>
        <!-- end:: Aside -->
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">
            <!-- begin:: Header -->
            <div id="kt_header" class="kt-header kt-grid__item  kt-header--fixed ">
                <!-- begin:: Header Menu -->
                <!-- Uncomment this to display the close button of the panel
                            <button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
                    -->
                <div class="kt-header-menu-wrapper" id="kt_header_menu_wrapper" style="opacity: 1;">
                    <div id="kt_header_menu" class="kt-header-menu kt-header-menu-mobile  kt-header-menu--layout-default ">
                        <ul class="kt-menu__nav ">
                            <li class="d-flex align-items-center today-date" data-ktmenu-submenu-toggle="click" aria-haspopup="true">
                                {{awtTrans('تاريخ اليوم')}} :<span id="day-history" style="direction: ltr"> {{ date('d M - Y') }} </span>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- end:: Header Menu -->
                @include('admin.partial.navbar')
            </div>
            <div class="kt-subheader   kt-grid__item" id="kt_subheader">
                <div class="kt-container  kt-container--fluid ">
                    <div class="kt-subheader__main">
                        <h3 class="kt-subheader__title">
                        </h3>
                        <span class="kt-subheader__separator kt-hidden"></span>
                        <div class="kt-subheader__breadcrumbs">
                            <a href="{{ route('admin.dashboard') }}" class="kt-subheader__breadcrumbs-home"><i class="flaticon2-shelter"></i></a>
                            <span class="kt-subheader__breadcrumbs-separator"></span>
                            <a href="{{ route('admin.dashboard') }}" class="kt-subheader__breadcrumbs-link">
                                {{ awtTrans('نافا') }}</a>
                            -
                            @yield('breadcrumb')
                        </div>
                    </div>
                </div>
            </div>
        @yield('content')
        <!-- begin:: Footer -->
            <div class="kt-footer h-80 kt-grid__item kt-grid kt-grid--desktop kt-grid--ver-desktop" id="kt_footer">
                <div class="kt-container  kt-container--fluid ">
                    <div class="kt-footer__copyright" style="padding-top: 10px">
                        {{\Carbon\Carbon::now()->format('Y')}} © {{awtTrans('جميع الحقوق محفوظه')}}
                    </div>
                </div>
            </div>
            <!-- end:: Footer -->
        </div>
    </div>
</div>
<!-- begin::Scrolltop -->
<div id="kt_scrolltop" class="kt-scrolltop">
    <i class="fa fa-arrow-up"></i>
</div>

<audio id="notify-alert-sound" style="display: none" muted="muted">
    <source src="{{ dashboard_url('sound/message-ringtone-magic.mp3') }}" />
</audio>
<audio id="chat-alert-sound" style="display: none" muted="muted">
    <source src="{{ dashboard_url('sound/facebook_chat.mp3') }}" />
</audio>
<!--begin:: Global Mandatory Vendors -->
<script src="{{dashboard_url('admin/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/vendors/general/popper.js/dist/umd/popper.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/vendors/general/bootstrap/dist/js/bootstrap.min.j')}}s" type="text/javascript">
</script>
<script src="{{asset('assets/vendors/general/js-cookie/src/js.cookie.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/vendors/general/moment/min/moment.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/vendors/general/tooltip.js/dist/umd/tooltip.min.js')}}" type="text/javascript">
</script>
<script src="{{asset('assets/vendors/general/perfect-scrollbar/dist/perfect-scrollbar.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/vendors/general/sticky-js/dist/sticky.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/vendors/general/wnumb/wNumb.js')}}" type="text/javascript"></script>
<!--end:: Global Mandatory Vendors -->
<!--begin:: Global Optional Vendors -->
<script src="{{asset('assets/js/demo1/scripts.bundle.js')}}" type="text/javascript"></script>

<script src="{{dashboard_url('admin/datatables/jquery.dataTables.js')}}"></script>
<script src="{{dashboard_url('admin/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{dashboard_url('admin/datatables-responsive/js/dataTables.responsive.js')}}"></script>
<script src="{{dashboard_url('admin/datatables-responsive/js/responsive.bootstrap4.js')}}"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="{{dashboard_url('admin/datatables-buttons/js/buttons.bootstrap4.js')}}"></script>
<script src="{{dashboard_url('admin/datatables-buttons/js/buttons.colVis.js')}}"></script>
<script src="{{dashboard_url('admin/datatables-buttons/js/buttons.flash.js')}}"></script>
<script src="{{dashboard_url('admin/datatables-buttons/js/buttons.html5.js')}}"></script>
<script src="{{dashboard_url('admin/datatables-buttons/js/buttons.print.js')}}"></script>
<script src="{{dashboard_url('admin/datatables-keytable/js/dataTables.keyTable.js')}}"></script>
<script src="{{dashboard_url('admin/datatables-keytable/js/keyTable.bootstrap4.js')}}"></script>
<script src="{{dashboard_url('admin/datatables-select/js/dataTables.select.js')}}"></script>
<script src="{{dashboard_url('admin/datatables-select/js/select.bootstrap4.js')}}"></script>
<script src="{{dashboard_url('admin/pdfmake/pdfmake.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="{{dashboard_url('admin/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{dashboard_url('admin/toastr/toastr.min.js')}}"></script>
<script src="{{dashboard_url('admin/moment.min.js')}}"></script>
<script src="{{dashboard_url('js/jschart/chart.js')}}"></script>
<script src="https://www.gstatic.com/firebasejs/8.4.3/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.4.3/firebase-messaging.js"></script>
<script src="{{dashboard_url('firebase/notification/showNotification.js')}}"></script>
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<script src="{{dashboard_url('custom.js')}}"></script>
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.1.1/socket.io.js"></script>--}}
{{--<script>--}}
{{--    var socket = io.connect('https://navaservices.net:4321',{--}}
{{--        query: "id= " + `{{auth()->id()}}`--}}
{{--    });--}}
{{--</script>--}}
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

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('.image-upload-wrap').hide();
                $('.file-upload-image').attr('src', e.target.result);
                $('.file-upload-content').show();
                $('.image-title').html(input.files[0].name);
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            removeUpload();
        }
    }

    function removeUpload() {
        $('.file-upload-input').replaceWith($('.file-upload-input').clone());
        $('.file-upload-content').hide();
        $('.image-upload-wrap').show();
    }
    $('.image-upload-wrap').bind('dragover', function() {
        $('.image-upload-wrap').addClass('image-dropping');
    });
    $('.image-upload-wrap').bind('dragleave', function() {
        $('.image-upload-wrap').removeClass('image-dropping');
    });

</script>
{{--<script src="{{asset('js/admin.js')}}"></script>--}}



<script type="text/javascript">
    $(function () {
        'use strict'
        $('input[type="password"]').val('');
        var a = $("#datatable-table").DataTable({
            dom: 'Blfrtip',
            pageLength: 10,
            lengthMenu :[
                [10,25,50,100,-1],[10,25,50,100,'عرض الكل']
            ],
            buttons: [
                {
                    extend: 'excel',
                    text: 'ملف Excel',
                    className: "btn btn-success"

                },
                {
                    extend: 'copy',
                    text: 'نسخ',
                    className: "btn btn-inverse"
                },
                {
                    extend: 'print',
                    text: 'طباعه',
                    className: "btn btn-success"
                },
            ],

            "language": {
                "sEmptyTable": `{{awtTrans("ليست هناك بيانات متاحة في الجدول")}}`,
                "sLoadingRecords": `{{awtTrans("جارٍ التحميل...")}}`,
                "sProcessing": `{{awtTrans("جارٍ التحميل...")}}`,
                "sLengthMenu": `{{awtTrans("أظهر _MENU_ مدخلات")}}`,
                "sZeroRecords": `{{awtTrans("لم يعثر على أية سجلات")}}`,
                "sInfo": `{{awtTrans("إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل")}}`,
                "sInfoEmpty": `{{awtTrans("يعرض 0 إلى 0 من أصل 0 سجل")}}`,
                "sInfoFiltered": `{{awtTrans("(منتقاة من مجموع _MAX_ مُدخل)")}}`,
                "sInfoPostFix": "",
                "sSearch": `{{awtTrans("ابحث:")}}`,
                "sUrl": "",
                "oPaginate": {
                    "sFirst": `{{awtTrans("الأول")}}`,
                    "sPrevious": `{{awtTrans("السابق")}}`,
                    "sNext": `{{awtTrans("التالي")}}`,
                    "sLast": `{{awtTrans("الأخير")}}`
                },
                "oAria": {
                    "sSortAscending": `{{awtTrans(": تفعيل لترتيب العمود تصاعدياً")}}`,
                    "sSortDescending": `{{awtTrans(": تفعيل لترتيب العمود تنازلياً")}}`
                }
            }
        });
        a.buttons().container().appendTo("#datatable-table_wrapper .col-md-6:eq() ")


    });

    function confirmDelete(url){
        $('#confirm-delete-form').attr('action',url);
    }
    function deleteAllData(type,url){
        $('#delete_type').val(type);
        $('#delete-all').attr('action',url);
    }

    function sendNotify(type , id) {
        $('#type').val(type);
        $('#notify_id').val(id);
        $("#notifyMessage").val('');
        $('#notifyMessage').html('');
    }
    function sendToWallet( id) {
        $('#user_id').val(id);
    }

    function changeUserStatus(id) {
        var tokenv  = "{{csrf_token()}}";
        var status = 1;
        $.ajax({
            type     : 'POST',
            url      : "{{route('admin.changeStatus')}}" ,
            datatype : 'json' ,
            data     : {
                'id'         :  id ,
                'status'     :  status ,
                '_token'     :  tokenv
            }, success   : function(res){
                //
            }
        });
    }
    function changeUserNotify(id) {
        var tokenv  = "{{csrf_token()}}";
        var notify = 1;
        $.ajax({
            type     : 'POST',
            url      : "{{route('admin.changeNotify')}}" ,
            datatype : 'json' ,
            data     : {
                'id'         :  id ,
                'notify'     :  notify ,
                '_token'     :  tokenv
            }, success   : function(res){
                //
            }
        });
    }
    function changeServiceActive(id) {
        var tokenv  = "{{csrf_token()}}";
        var active = 1;
        $.ajax({
            type     : 'POST',
            url      : "{{route('admin.services.changeStatus')}}" ,
            datatype : 'json' ,
            data     : {
                'id'         :  id ,
                'active'     :  active ,
                '_token'     :  tokenv
            }, success   : function(res){
                //
            }
        });
    }
    function changeCategoryAppear(id) {
        var tokenv  = "{{csrf_token()}}";
        var appear = 1;
        $.ajax({
            type     : 'POST',
            url      : "{{route('admin.categories.changeCategoryAppear')}}" ,
            datatype : 'json' ,
            data     : {
                'id'         :  id ,
                'appear'     :  appear ,
                '_token'     :  tokenv
            }, success   : function(res){
                //
            }
        });
    }
    function getCities(country_id,type = '',placeholder = 'اختر'){
        var html = '';
        var city_id = '';
        $('[name=city_id]').empty();
        if(country_id){
            $.ajax({
                url: `{{route('admin.ajax.getCities')}}`,
                type: 'post',
                dataType: 'json',
                data:{id: country_id},
                success: function (res) {
                    if(type != ''){
                        city_id = type;
                    }
                    html += `<option value="" hidden selected>${placeholder}</option>`;
                    $.each(res.data,function (index,value) {
                        html += `<option value="${value.id}" ${city_id == value.id ? 'selected':'' }>${value.title.ar}</option>`;
                    });
                    $('[name=city_id]').append(html);
                }
            });
        }
    }
    function getTechs(order_id,category_id,type = '',placeholder = 'اختر'){
        var html = '';
        var technician_id = '';
        $('[name=technician_id]').empty();
        if(order_id){
            $.ajax({
                url: `{{route('admin.ajax.getTechs')}}`,
                type: 'post',
                dataType: 'json',
                data:{id: order_id,category_id: category_id},
                success: function (res) {
                    if(type != ''){
                        technician_id = type;
                    }
                    html += `<option value="" hidden selected>${placeholder}</option>`;
                    $.each(res.data,function (index,value) {
                        html += `<option value="${value.id}" ${technician_id == value.id ? 'selected':'' }>${value.name}</option>`;
                    });
                    $('[name=technician_id]').append(html);
                }
            });
        }
    }
    function getRegionsCheckBox(city_id,placeholder = 'اختر'){
        var html = '';
        if(city_id){
            $('.regions').empty();
            $.ajax({
                url: `{{route('admin.ajax.getRegions')}}`,
                type: 'post',
                dataType: 'json',
                data:{id: city_id},
                success: function (res) {
                    if(res.data.length > 0){
                        $('.region-dis').show();
                    }else{
                        $('.region-dis').hide();
                    }
                    html += `<ul class="list-group">`;
                    $.each(res.data,function (index,value) {
                        html += `<li class="list-inline-item">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" value="${value.id}" name="regions[]">
                                            ${value.title.ar}
                                        </label>
                                    </div>
                                </li>`;
                    });
                    html += `</ul>`;
                    $('.regions').append(html);
                }
            });
        }
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script>

    $(function () {
        'use strict'
        $('.table thead tr:first th:first').html(`
        <label class="custom-control material-checkbox" style="margin: auto">
            <input type="checkbox" class="material-control-input" id="checkedAll">
            <span class="material-control-indicator"></span>
        </label>`);
    });
</script>

<script src="{{ asset('js/app.js') }}"></script>
@include('admin.partial.alert')
@include('admin.partial.confirm_delete')
@stack('css')
@stack('js')

<script>
    console.log(Echo.private('rooms.10'));
    Echo.private('rooms.10')
        .listen('MessageSent', (e) => {
            console.log(e);
            // $("#messages").animate({ scrollTop: $(document).height() }, "slow");
        });
    Echo.private('users.{{auth()->id()}}')
        .listen('.update.notifications', (e) => {
            $.ajax({
                url: `{{route('admin.ajax.getNotificationCount')}}`,
                type: 'post',
                dataType: 'json',
                success: function (res) {
                    $('.notify-count').html(res);
                    notifyPlay();
                }
            });
        })
        .listen('.update.messages.notifications', (e) => {
            $.ajax({
                url: `{{route('admin.ajax.getMessagesNotificationCount')}}`,
                type: 'post',
                dataType: 'json',
                success: function (res) {
                    $('.messages-count').html(res);
                    play();
                }
            });
        });

    let alert_sound = document.getElementById("chat-alert-sound");
    function play(){
        alert_sound.muted = true;
        alert_sound.play();
        alert_sound.muted = false;
        alert_sound.play();
    }
    let notify_sound = document.getElementById("notify-alert-sound");
    function notifyPlay(){
        notify_sound.muted = true;
        notify_sound.play();
        notify_sound.muted = false;
        notify_sound.play();
    }
</script>
</body>

</html>

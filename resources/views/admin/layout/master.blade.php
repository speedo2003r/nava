<!DOCTYPE html>
<html>
<head>
    <title>{{\Request::route()->getAction()['title']}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{dashboard_url('admin/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{dashboard_url('admin/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{dashboard_url('admin/datatables-bs4/css/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{dashboard_url('admin/datatables-responsive/css/responsive.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{dashboard_url('admin/datatables-buttons/css/buttons.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{dashboard_url('admin/datatables-select/css/select.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{dashboard_url('admin/select2/css/select2.css')}}">
    <link rel="stylesheet" href="{{dashboard_url('admin/toastr/toastr.min.css')}}">
    <link rel="stylesheet" href="{{dashboard_url('admin/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{dashboard_url('dashboard/css/filepond.min.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />


    <!-- bootstrap rtl -->
   <link rel="stylesheet" href="{{dashboard_url('dashboard/css/bootstrap-rtl.min.css')}}">
    <link rel="stylesheet" href="{{dashboard_url('dashboard/css/custom.css')}}">

    @if(\App::getLocale() == 'ar')
        <link rel="stylesheet" href="{{dashboard_url('dashboard/css/rtl.css')}}">
    @endif
    <script src="{{dashboard_url('dashboard/js/sweetalert2.all.min.js')}}"></script>
    <style>
        .pac-container ,.select2-container{ z-index: 100000 !important; }
    </style>
    @stack('css')
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed text-sm">
    @if(Route::currentRouteName() != 'admin.show.login' && auth()->check())
        @include('admin.partial.navbar')
        @include('admin.partial.sidebar')
    @endif

    <div class="content-wrapper">

        @yield('content')
    </div>
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>

    <script src="{{dashboard_url('admin/jquery/jquery.min.js')}}"></script>
    <script src="{{dashboard_url('admin/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
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
    <script src="{{dashboard_url('admin/select2/js/select2.js')}}"></script>
    <script src="{{dashboard_url('admin/toastr/toastr.min.js')}}"></script>
    <script src="{{dashboard_url('admin/adminlte.js')}}"></script>
    <script src="{{dashboard_url('admin/moment.min.js')}}"></script>
    <script src="{{dashboard_url('dashboard/js/filepond.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    <script src="{{dashboard_url('dashboard/js/custom.js')}}"></script>

    <script src="https://cdn.tiny.cloud/1/78imoeeyottf14cv9qec8ag9ccx5b3ho9k7svtru1w9pmwd3/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>


    @include('admin.partial.alert')
    @include('admin.partial.confirm_delete')

    <script>

        tinymce.init({
            selector: '.mytextarea',
            rtl_ui:true,
            directionality :"rtl",
            body_class: 'my_class',
            height: '80%',
            width: '100%',
            resize: false,
            convert_urls: false,
            statusbar: false,
            setup: function (editor) {
                editor.ui.registry.addButton('CustomFileAttachment', {
                    icon: 'insert-time',
                    tooltip: 'FILE attachment',
                    disabled: false,
                    onAction: function () {
                        editor.insertContent("attachment clicked");
                    }
                });
            },
            menubar: false,
            plugins: 'autolink directionality visualblocks visualchars fullscreen codesample table charmap hr pagebreak nonbreaking anchor toc advlist lists imagetools textpattern code',
            toolbar: 'bold italic underline strikethrough superscript subscript forecolor backcolor fontselect fontsizeselect link image media table alignleft aligncenter alignright alignjustify numlist bullist outdent indent removeformat code CustomFileAttachment rtl ltr ',
            fontsize_formats: '7px 8px 9px 10px 11px 12px 13px 14px 16px 18px 20px 24px 30px 36px 48px 60px',
            content_css: [
                '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                '//www.tiny.cloud/css/codepen.min.css'
            ],
            branding: false,
            /*link_list: [
              { title: 'My page 1', value: 'http://www.tinymce.com' },
              { title: 'My page 2', value: 'http://www.moxiecode.com' }
            ],
            image_list: [
              { title: 'My page 1', value: 'http://www.tinymce.com' },
              { title: 'My page 2', value: 'http://www.moxiecode.com' }
            ],
            image_class_list: [
              { title: 'None', value: '' },
              { title: 'Some class', value: 'class-name' }
            ],*/
            importcss_append: false,
            height: 400,
            file_picker_types: 'image',
            file_picker_callback: function (callback, value, meta) {
                /* Provide file and text for the link dialog */
                /*
                if (meta.filetype === 'file') {
                  callback('https://www.google.com/logos/google.jpg', { text: 'My text' });
                }
                */

                /* Provide image and alt text for the image dialog */
                if (meta.filetype == 'image') {
                    var input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');
                    input.onchange = function () {
                        var file = this.files[0];
                        var reader = new FileReader();
                        reader.onloadend = function () {
                            callback(reader.result, { title: file.name });
                        };
                        reader.readAsDataURL(file);
                    };
                    input.click();
                }

                /* Provide alternative source and posted for the media dialog */
                /*
                if (meta.filetype === 'media') {
                  callback('movie.mp4', { source2: 'alt.ogg', poster: 'https://www.google.com/logos/google.jpg' });
                }
                */
            },
            images_upload_url: 'dummypostAcceptor.php',

            /* we override default upload handler to simulate successful upload*/
            images_upload_handler: function (blobInfo, success, failure) {    			success('data:image/'+blobInfo.filename().toString().split('.').pop()+';base64,'+blobInfo.base64().toString());
            },
            images_dataimg_filter: function(img) {
                //return img.hasAttribute('internal-blob');
                console.log(img);
            },
            image_caption: true,
            content_style: '.mce-annotation { background: #fff0b7; } .tc-active-annotation {background: #ffe168; color: black; }'
        });
        $(function () {
            'use strict'
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
                    "sEmptyTable": "ليست هناك بيانات متاحة في الجدول",
                    "sLoadingRecords": "جارٍ التحميل...",
                    "sProcessing": "جارٍ التحميل...",
                    "sLengthMenu": "أظهر _MENU_ مدخلات",
                    "sZeroRecords": "لم يعثر على أية سجلات",
                    "sInfo": "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
                    "sInfoEmpty": "يعرض 0 إلى 0 من أصل 0 سجل",
                    "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
                    "sInfoPostFix": "",
                    "sSearch": "ابحث:",
                    "sUrl": "",
                    "oPaginate": {
                        "sFirst": "الأول",
                        "sPrevious": "السابق",
                        "sNext": "التالي",
                        "sLast": "الأخير"
                    },
                    "oAria": {
                        "sSortAscending": ": تفعيل لترتيب العمود تصاعدياً",
                        "sSortDescending": ": تفعيل لترتيب العمود تنازلياً"
                    }
                }
            });
            a.buttons().container().appendTo("#datatable-table_wrapper .col-md-6:eq() ")


        });

        function sendToWallet( id) {
            $('#user_id').val(id);
        }
        function confirmDelete(url){
            $('#confirm-delete-form').attr('action',url);
        }
        function deleteAllData(type,url){
            $('#delete_type').val(type);
            $('#delete-all').attr('action',url);
        }

        function sendNotify(type , id) {
            $('#notify_type').val(type);
            $('#notify_id').val(id);
            $("#notifyMessage").val('');
            $('#notifyMessage').html('');
        }

        function changeUserAccepted(id) {
            var tokenv  = "{{csrf_token()}}";
            var accepted = 1;
            $.ajax({
                type     : 'POST',
                url      : "{{route('ajax.changeAccepted')}}" ,
                datatype : 'json' ,
                data     : {
                    'id'         :  id ,
                    'accepted'     :  accepted ,
                    '_token'     :  tokenv
                }, success   : function(res){
                    // if ($('#customSwitch'+id).attr('checked')) {
                    //     $('#customSwitch'+id).prop('checked',false)
                    // }else{
                    //     $('#customSwitch'+id).prop('checked',true)
                    // }
                }
            });
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        function changeAdActive(id) {
            var tokenv  = "{{csrf_token()}}";
            var active = 1;
            $.ajax({
                type     : 'POST',
                url      : "{{route('admin.ads.changeActive')}}" ,
                datatype : 'json' ,
                data     : {
                    'id'         :  id ,
                    'active'     :  active ,
                    '_token'     :  tokenv
                }, success   : function(res){
                }
            });
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
        function changeItemStatus(id) {
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
        function changeCategoryPledge(id) {
            var tokenv  = "{{csrf_token()}}";
            var pledge = 1;
            $.ajax({
                type     : 'POST',
                url      : "{{route('admin.categories.changeCategoryPledge')}}" ,
                datatype : 'json' ,
                data     : {
                    'id'         :  id ,
                    'pledge'     :  pledge ,
                    '_token'     :  tokenv
                }, success   : function(res){
                    //
                }
            });
        }
    </script>
    <script>
        function footerBtn(url){
            $('tfoot').empty();
            var length = $('.table thead tr th').length;
            var html = `<tr>
                <td colspan="${length}">
                    <button class="btn btn-danger confirmDel" disabled onclick="deleteAllData('more','${url}')" data-toggle="modal" data-target="#confirm-all-del">
                        <i class="fas fa-trash"></i>
                        حذف المحدد
                    </button>
                </td>
            </tr>`;
            $('tfoot').append(html);
        }
    </script>
    @stack('js')
    <script>
        @if(\Illuminate\Support\Facades\Route::current()->uri != 'admin/items/create' && \Illuminate\Support\Facades\Route::currentRouteName() != 'admin.items.edit')
        $(function () {
            'use strict'
            $('.table thead tr:first th:first').html(`
                            <label class="custom-control material-checkbox" style="margin: auto">
                                <input type="checkbox" class="material-control-input" id="checkedAll">
                                <span class="material-control-indicator"></span>
                            </label>`);
        });
        @endif
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
                        html += `<option value="">${placeholder}</option>`;
                        $.each(res.data,function (index,value) {
                            html += `<option value="${value.id}" ${city_id == value.id ? 'selected':'' }>${value.title.ar}</option>`;
                        });
                        $('[name=city_id]').append(html);
                    }
                });
            }
        }
    </script>
</body>
</html>

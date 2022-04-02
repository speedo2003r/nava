@extends('admin.layout.master')
@section('title',awtTrans('الخدمات'))
@section('breadcrumb')
    <a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName()) }}" class="kt-subheader__breadcrumbs-link">
        {{ awtTrans('الخدمات') }}</a>
@endsection
@section('content')


    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <div class="kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__body kt-portlet__body--fit">

                    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

                        <div class="kt-portlet__head kt-portlet__head--lg p-0">
                            <div class="kt-portlet__head-label">
                            <span class="kt-portlet__head-icon">
                            <img style="width: 25px" alt="icon" src="{{asset('assets/media/menuicon/document.svg')}}" />
                            </span>
                                <h3 class="kt-portlet__head-title">
                                    {{awtTrans('الخدمات')}}
                                </h3>
                            </div>
                        </div>

                        <div class="kt-portlet__head-label mt-3">
                            <button type="button" data-toggle="modal" data-target="#editModel" class="btn btn-brand btn-elevate btn-icon-sm add-user">
                                <i class="la la-plus"></i>
                                {{awtTrans('اضافه')}}
                            </button>

{{--                            <button class="btn btn-brand btn-elevate btn-icon-sm confirmDel" disabled onclick="deleteAllData('more','{{route('admin.services.destroy',0)}}')" data-toggle="modal" data-target="#confirm-all-del">--}}
{{--                                <i class="la la-trash"></i>--}}
{{--                                {{awtTrans('حذف')}}--}}
{{--                            </button>--}}
                        </div>


                        <div class="kt-portlet__body kt-portlet__body--fit  margin-15 ">
                            <div class="table-responsive">
                                <table id="table"  class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                    <thead>
                                    <tr>

                                        <th> {{__('ID')}} </th>
                                        <th> القسم </th>
                                        <th> اسم الخدمه </th>
                                        <th> السعر </th>
                                        <th> النوع </th>
                                        <th>   الحاله   </th>
                                        <th>   التحكم   </th>



                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <!-- end:: Content -->
    </div>
    <!-- edit model -->
    <div class="modal fade" id="editModel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header"><h4 class="modal-title">{{awtTrans('تعديل الخدمه')}}</h4></div>
                <form action=""  id="editForm" method="post" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                    @include('components.lang_taps')
                    <!--begin::Portlet-->
                        <div class="kt-portlet" style="padding-top:15px">

                            <div>
                                <label class = "mb-0">الصوره</label>
                                <div class = "text-center">
                                    <div class = "images-upload-block single-image">
                                        <label class = "upload-img">
                                            <input type="file" name="image" id = "image" accept = "image/*" class = "image-uploader" >
                                            <i class="fas fa-cloud-upload-alt"></i>
                                        </label>
                                        <div class = "upload-area" id="upload_area_img"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="nav-tabs-custom nav-tabs-lang-inputs">
                                <div class="tab-content">
                                    @foreach(\App\Entities\Lang::all() as $key => $locale)
                                        <div class="tab-pane @if(\App\Entities\Lang::first() == $locale)  fade show active @endif" id="locale-tab-{{$locale['lang']}}">
                                            <div class="form-group">
                                                <input type="text" value="{{old('title_'.$locale['lang'])}}" name="title_{{$locale['lang']}}" id="title_{{$locale['lang']}}" class="form-control" placeholder="{{__('enter')}} ..." >
                                            </div>
                                            <div class="form-group">
                                                <textarea rows="6" name="description_{{$locale['lang']}}" id="description_{{$locale['lang']}}" class="form-control" placeholder="{{awtTrans('الوصف')}} ..." >{{old('description_'.$locale['lang'])}}</textarea>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{awtTrans('السعر')}}</label>
                                        <input type="number" value="{{old('price')}}" class="form-control" name="price" id="price">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{awtTrans('القسم')}}</label>
                                        <select name="category_id" id="category_id" class="form-control">
                                            <option value="" hidden selected>{{awtTrans('اختر')}}</option>
                                            @foreach($categories as $category)
                                                <option value="{{$category['id']}}">{{$category['title']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{awtTrans('النوع')}}</label>
                                        <select name="type" id="type" class="form-control">
                                            <option value="" hidden selected>{{awtTrans('اختر')}}</option>
                                            <option value="fixed">{{awtTrans('ثابت')}}</option>
                                            <option value="pricing">{{awtTrans('تقديري')}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-primary">{{__('save')}}</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{__('close')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end edit model -->
@endsection
@push('js')
    <script>
        $('.add-user').on('click',function () {
            $('#editModel .modal-title').text(`{{awtTrans('اضافة خدمه')}}`);
            $('#editForm :input:not([type=checkbox],[type=radio],[type=hidden])').val('');
            $( '#upload_area_img' ).empty();
            $('#editForm')      .attr("action","{{route('admin.services.store')}}");
        });

        function edit(ob){
            $('#editModel .modal-title').text(`{{awtTrans('تعديل خدمه')}}`);
            $('#editForm')      .attr("action","{{route('admin.services.update','obId')}}".replace('obId',ob.id));
            @foreach(\App\Entities\Lang::all() as $key => $locale)
            $('#title_{{$locale['lang']}}')    .val(ob.title.{{$locale['lang']}});
            $('#description_{{$locale['lang']}}')    .val(ob.description.{{$locale['lang']}});
            @endforeach
            $('#price').val(ob.price);
            $('#category_id').val(ob.category_id);
            $('#type').val(ob.type).change;
            let image = $( '#upload_area_img' );
            image.empty();
            image.append( '<div class="uploaded-block" data-count-order="1"><img src="' + ob.image + '"><button class="close">&times;</button></div>' );
        }
        var oTable;
        $(function () {
            'use strict'
            var status_id = '';
            $('body').on('change','#status_id', function() {
                status_id = $(this).val();
                oTable.draw();
            });
            $('.table').dataTable().fnDestroy();
            oTable = $('.table').DataTable({
                dom: 'Blfrtip',
                pageLength: 10,
                processing: true,
                serverSide: true,
                ordering: false,
                ajax: {
                    url: `{{route('admin.services.getFilterData')}}`,
                    data: function (d) {
                        d.status_id = status_id;
                    }
                },
                columns: [
                    {data: 'id', name: 'id',orderable: false},
                    {data: 'cat_title', name: 'cat_title'},
                    {data: 'services_title', name:'services_title'},
                    {data: 'price', name:'price'},
                    {data: 'type', name:'type'},
                    {data: 'active', name:'active'},
                    {data: 'control', name: 'control'},
                ],
                lengthMenu :[
                    [10,25,50,100],[10,25,50,100]
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


            $(document).on('change','#checkedAll',function(){
                if(this.checked){
                    $(".checkSingle").each(function(){
                        this.checked=true;
                        $('.confirmStatus').prop('disabled',false);
                        $('.confirmOrderPdf').prop('disabled',false);
                    });
                }else{
                    $(".checkSingle").each(function(){
                        this.checked=false;
                        $('.confirmStatus').prop('disabled',true);
                        $('.confirmOrderPdf').prop('disabled',true);
                    });
                }
                checkIds();
            });

            $(document).on('click',".checkSingle",function () {
                if ($(this).is(":checked")){
                    $('.confirmStatus').prop('disabled',false);
                    $('.confirmOrderPdf').prop('disabled',false);
                    var isAllChecked = 0;
                    $(".checkSingle").each(function(){
                        if(!this.checked)
                            isAllChecked = 1;
                    })
                    if(isAllChecked == 0){ $("#checkedAll").prop("checked", true); }
                }else {
                    if($(".checkSingle:checked").length == 0){
                        $('.confirmStatus').prop('disabled',true);
                        $('.confirmOrderPdf').prop('disabled',true);
                    }
                    $("#checkedAll").prop("checked", false);
                }
                checkIds();
            });

        });
    </script>
@endpush

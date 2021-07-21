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

                            <button class="btn btn-brand btn-elevate btn-icon-sm confirmDel" disabled onclick="deleteAllData('more','{{route('admin.regions.destroy',0)}}')" data-toggle="modal" data-target="#confirm-all-del">
                                <i class="la la-trash"></i>
                                {{awtTrans('حذف')}}
                            </button>
                        </div>


                        <div class="kt-portlet__body kt-portlet__body--fit  margin-15 ">
                            <div class="table-responsive">
                                <table id="table"  class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                    <thead>
                                    <tr>

                                        <th>  </th>
                                        <th> الحاله </th>

                                        <th>   التاريخ   </th>
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
@endsection
@push('js')
    <script>

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
                    {data: 'status', name: 'status',orderable: true},
                    {data: 'created_at', name: 'created_at',orderable: true},
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

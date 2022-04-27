@extends('admin.layout.master')
@section('title',awtTrans('التقنيين'))
@section('breadcrumb')
    <a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName()) }}" class="kt-subheader__breadcrumbs-link">
        {{ awtTrans('التقنيين') }}</a>
@endsection
@section('content')
@push('css')
    <style>
        :root {
            --star-size: 15px;
            --star-color: #ccc;
            --star-background: #333;
        }
        .Stars {
            --percent: calc(var(--rating) / 5 * 100%);
            display: inline-block;
            font-size: var(--star-size);
            font-family: Times;
            line-height: 1;
        }
        .Stars::before {
            content: "★★★★★";
            letter-spacing: 3px;
            background: linear-gradient(90deg, var(--star-background) var(--percent), var(--star-color) var(--percent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
@endpush
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
                                    {{awtTrans('التقنيين')}}
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__head-label mt-3">
                            <button type="button" data-toggle="modal" data-target="#editModel" class="btn btn-brand btn-elevate btn-icon-sm add-user">
                                <i class="la la-plus"></i>
                                {{awtTrans('اضافه')}}
                            </button>

{{--                            <button class="btn btn-brand btn-elevate btn-icon-sm confirmDel" disabled onclick="deleteAllData('more','{{route('admin.technicians.delete',0)}}')" data-toggle="modal" data-target="#confirm-all-del">--}}
{{--                                <i class="la la-trash"></i>--}}
{{--                                {{awtTrans('حذف')}}--}}
{{--                            </button>--}}
                            <button class="btn btn-warning btn-wide waves-effect waves-light all" onclick="sendNotify('all' , '0')" data-toggle="modal" data-target="#send-noti">
                                <i class="fas fa-paper-plane"></i>{{awtTrans('ارسال اشعارات للجميع')}}
                            </button>
                        </div>
                        <div class="kt-portlet__body kt-portlet__body--fit  margin-15 ">
                            <div class="table-responsive">
                                {!! $dataTable->table([
                                 'class' => "table table-striped table-bordered dt-responsive nowrap",
                                 'id' => "techniciandatatable-table",
                                 ],true) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- send-noti modal-->
    <div class="modal fade" id="send-noti"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{awtTrans('إرسال أشعار')}}</h5>
                </div>
                <div class="modal-body">
                    <form action="" id="sendnotifyuserForm" method="POST">
                        @csrf
                        <input type="hidden" name="type" id="notify_type" value="technician">
                        <input type="hidden" name="id" id="notify_id">
                        <div class="form-group">
                            <label for="">
                                {{awtTrans('الرسالة')}}
                            </label>
                            <textarea name="message" id="notifyMessage" cols="30" rows="4" class="form-control"
                                      placeholder="{{awtTrans('اكتب رسالتك')}} ..."></textarea>
                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="submit" class="btn btn-sm btn-success save" onclick="sendnotifyuser()">إرسال</button>
                            <button type="button" class="btn btn-default" id="notifyClose" data-dismiss="modal">اغلاق</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end send-noti modal-->
    <!-- send-noti modal-->
    <div class="modal fade" id="send-wallet"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{awtTrans('إرسال للمحفظه')}}</h5>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.addToWallet')}}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="user_id">
                        <div class="form-group">
                            <label for="">
                                {{awtTrans('القيمه')}}
                            </label>
                            <input type="number" min="0" value="0" name="wallet" class="form-control">
                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="submit" class="btn btn-sm btn-success">{{awtTrans('إرسال')}}</button>
                            <button type="button" class="btn btn-default" id="notifyClose" data-dismiss="modal">{{awtTrans('اغلاق')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end send-noti modal-->

    <!-- send-noti modal-->
    <div class="modal fade" id="deductions"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{awtTrans('خصم')}}</h5>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.technicians.decreaseVal')}}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="dis_user_id">
                        <div class="form-group">
                            <label for="">
                                {{awtTrans('القيمه')}}
                            </label>
                            <input type="number" min="0" value="0" name="deduction" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">
                                {{awtTrans('السبب')}}
                            </label>
                            <textarea name="notes" rows="5" class="form-control"></textarea>
                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="submit" class="btn btn-sm btn-success">{{awtTrans('إرسال')}}</button>
                            <button type="button" class="btn btn-default" id="notifyClose" data-dismiss="modal">{{awtTrans('اغلاق')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end send-noti modal-->


    <!-- send-noti modal-->
    <div class="modal fade" id="categories-modal"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{awtTrans('التخصصات')}}</h5>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.technicians.selectCategories')}}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" id="user_id_perms" value="">
                        <div class="form-group">
                            <div class="children-groups">

                            </div>
                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="submit" class="btn btn-sm btn-success save">إرسال</button>
                            <button type="button" class="btn btn-default" id="notifyClose" data-dismiss="modal">اغلاق</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- edit model -->
    <div class="modal fade" id="editModel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header"><h4 class="modal-title">تعديل التقني</h4></div>
                <form action=""  id="editForm" method="post" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">

                            <div class = "col-sm-12 text-center">
                                <label class = "mb-0">{{__('avatar')}}</label>
                                <div class = "text-center">
                                    <div class = "images-upload-block single-image">
                                        <label class = "upload-img">
                                            <input type = "file" name = "image" id = "image" accept = "image/*" class = "image-uploader" >
                                            <i class="fas fa-cloud-upload-alt"></i>
                                        </label>
                                        <div class = "upload-area" id="upload_area_img"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>{{__('name')}}</label>
                                    <input type="text" name="name" id="name" class="form-control">
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>{{__('phone')}}</label>
                                    <input type="number" name="phone" id="phone" class="form-control">
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>{{__('email')}}</label>
                                    <input type="email" name="email" id="email" class="form-control">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>{{__('password')}}</label>
                                    <input type="password" name="password" class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>اعادة كلمة المرور</label>
                                    <input type="password" name="password_confirmation" class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>الدوله</label>
                                    <select name="country_id" id="country_id" class="form-control">
                                        <option value="" hidden selected>اختر</option>
                                        @foreach($countries as $country)
                                            <option value="{{$country['id']}}">{{$country->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>المدينه</label>
                                    <select name="city_id" id="city" class="form-control">
                                        <option value="" hidden selected>اختر</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 subcat">
                                <div class="form-group" style="display: none">
                                    <label>الفروع</label>
                                    <div class="form-group branches"></div>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-3">
                                <div class="form-group">
                                    <label>العنوان</label>
                                    <input type="hidden" name="lat" id="lat" value="24.7135517">
                                    <input type="hidden" name="lng" id="lng" value="46.67529569999999">
                                    <input type="text" name="address" id="address" class="form-control" placeholder="{{awtTrans('قم بادخال ...')}}">
                                </div>
                                <div id="map" style="height: 300px"></div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>رقم البطاقه</label>
                                    <input type="number" name="id_number" id="id_number" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>رقم الحساب البنكي</label>
                                    <input type="number" name="bank_acc_id" id="bank_acc_id" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>العموله بالنسبه</label>
                                    <input type="number" min="0" max="100" value="0" name="commission" id="commission" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>الحد الأقصي للمديونيه</label>
                                    <input type="number" min="0" value="0" name="max_dept" id="max_dept" class="form-control">
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
    {!! $dataTable->scripts() !!}
    <script src="{{dashboard_url('js/map.js')}}"></script>
    <script
            src="https://maps.googleapis.com/maps/api/js?key={{settings('map_key')}}&libraries=places&callback=initMap"
            async defer></script>
    <script>
        $(function () {
            'use strict'

            $('body').on('change', '#country_id', function () {
                var country = $(this).val();
                getCities(country)
            })
            $('body').on('change', '#city_id', function () {
                var tokenv = "{{csrf_token()}}";
                var city = $(this).val();
                getBranches(city, tokenv)
            });
            $('.add-user').on('click', function () {
                $('#editModel .modal-title').text(`{{awtTrans('اضافة تقني')}}`);
                $('#editForm :input:not([type=checkbox],[type=radio],[type=hidden])').val('');
                $('#upload_area_img').empty();
                $('#editForm').attr("action", "{{route('admin.technicians.store')}}");
                $('.subcat').css({display: 'none'});
            });
        });
        function getBranches(city,tokenv,branches = []){
            $('.branches').empty();
            $.ajax({
                type        : 'POST',
                url         : '{{ route('admin.ajax.getBranches') }}' ,
                datatype    : 'json' ,
                data        : {city: city,'_token':tokenv},
                success     : function(data){
                    if(data.value == 0){
                        $('.branches').parent().css({'display':'none'});
                    }else{
                        var html = ``;
                        if(data.data.length > 0){
                            $('.branches').parent().css({'display':'block'});
                        }else{
                            $('.branches').parent().css({'display':'none'});
                        }
                        $.each(data.data,(index,value)=>{
                            html += `<label class="control-label mx-2">
                                        <input type="checkbox" name="branches[]" class="subs" value="${value.id}">
                                        ${value.title.ar}
                                    </label>`;
                        });
                        $('.branches').append(html);
                        if(branches.length > 0){
                            $(".subs").prop("checked", false);
                            branches.forEach(function(value) {
                                $('.subs:checkbox[value="' + value.id + '"]').prop('checked', true);
                            });
                        }
                    }
                }
            });
        }
        function edit(ob){
            $('#password')         .val('');
            $('#editForm')      .attr("action","{{route('admin.technicians.update','obId')}}".replace('obId',ob.id));
            $('#name')    .val(ob.name);
            $('#phone')         .val(ob.phone);
            $('#email')         .val(ob.email);
            $('#address')         .val(ob.address);
            $('#lat')         .val(ob.lat);
            $('#lng')         .val(ob.lng);
            $('#commission')         .val(ob.commission);
            $('#max_dept')         .val(ob.max_dept);
            $('#id_number')         .val(ob.technician.id_number);
            $('#bank_acc_id')         .val(ob.technician.bank_acc_id);
            $('#country_id')         .val(ob.country_id).change;
            getCities(ob.country_id,ob.city_id);

            var tokenv  = "{{csrf_token()}}";
            getBranches(ob.city_id,tokenv,ob.branches);
            initMap();

            let image = $( '#upload_area_img' );
            image.empty();
            image.append( '<div class="uploaded-block" data-count-order="1"><a href="' + ob.avatar + '"  data-fancybox data-caption="' + ob.avatar + '" ><img src="' + ob.avatar + '"></a><button class="close">&times;</button></div>' );
        }

        function sendnotifyuser() {
            event.preventDefault();
            $.ajax({
                type        : 'POST',
                url         : '{{ route('admin.sendnotifyuser') }}' ,
                datatype    : 'json' ,
                async       : false,
                processData : false,
                contentType : false,
                data        : new FormData($("#sendnotifyuserForm")[0]),
                success     : function(msg){
                    if(msg.value == '0'){
                        toastr.error(msg.msg);
                    }else{
                        $('#notifyClose').trigger('click');
                        $('#notifyMessage').html('');
                        toastr.success(msg.msg);
                    }
                }
            });
        }

        $(function () {
            'use strict'
            $('body').on('click','.subs',function () {
                var user = $(this).data('user_id');
                var perms = $(this).data('perms');
                $('#user_id_perms').val(user);
                var subperms = {!! json_encode($categories) !!};
                $('.children-groups').empty();
                var html = '';
                var subcat = '';
                $.each(subperms,(indexperm,value)=>{
                    $.each(perms,(index,catvalue)=>{
                        if(value.id == catvalue.id){
                            subcat = value.id;
                        }
                    });
                    html += `
                    <table class="table">
                        <tr>
                            <th>
                                ${value.title.ar}
                            </th>
                            <td>
                                <input type="checkbox" name="perms[]" ${subcat == value.id ? 'checked' : ''} value="${value.id}">
                            </td>
                        </tr>
                    </table>
                    `;
                });

                $('.children-groups').append(html);
            })
        })
        $(function () {
            'use strict'
            $('body').on('click','.dis',function () {
                var user = $(this).data('user_id');
                $('#dis_user_id').val(user);
            })
        })
    </script>
@endpush

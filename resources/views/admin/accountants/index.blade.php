@extends('admin.layout.master')
@section('title',awtTrans('المحاسبين'))
@section('breadcrumb')
    <a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName()) }}" class="kt-subheader__breadcrumbs-link">
        {{ awtTrans('المحاسبين') }}</a>
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
                                    {{awtTrans('المحاسبين')}}
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__head-label mt-3">
                            <button type="button" data-toggle="modal" data-target="#editModel" class="btn btn-brand btn-elevate btn-icon-sm add-user">
                                <i class="la la-plus"></i>
                                {{awtTrans('اضافه')}}
                            </button>

                            <button class="btn btn-brand btn-elevate btn-icon-sm confirmDel" disabled onclick="deleteAllData('more','{{route('admin.accountants.delete',0)}}')" data-toggle="modal" data-target="#confirm-all-del">
                                <i class="la la-trash"></i>
                                {{awtTrans('حذف')}}
                            </button>
                            <button class="btn btn-warning btn-wide waves-effect waves-light all" onclick="sendNotify('all' , '0')" data-toggle="modal" data-target="#send-noti">
                                <i class="fas fa-paper-plane"></i>{{awtTrans('ارسال اشعارات للجميع')}}
                            </button>
                        </div>
                        <div class="kt-portlet__body kt-portlet__body--fit  margin-15 ">
                            <div class="table-responsive">
                                {!! $dataTable->table([
                                 'class' => "table table-striped table-bordered dt-responsive nowrap",
                                 'id' => "accountingdatatable-table",
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
                        <input type="hidden" name="type" id="notify_type" value="accountant">
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
    <!-- edit model -->
    <div class="modal fade" id="editModel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header"><h4 class="modal-title">{{awtTrans('تعديل عميل')}}</h4></div>
                <form action=""  id="editForm" method="post" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">

                            <div class = "col-sm-12 text-center">
                                <label class = "mb-0">{{__('avatar')}}</label>
                                <div class = "text-center">
                                    <div class = "images-upload-block single-image">
                                        <label class = "upload-img">
                                            <input type = "file" name = "image" id = "image" accept = "image/*" class = "image-uploader">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                        </label>
                                        <div class = "upload-area" id="upload_area_img"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>{{__('name')}}</label>
                                    <input type="text" name="name" id="name" class="form-control">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>{{__('phone')}}</label>
                                    <input type="number" name="phone" class="form-control" id="phone">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>{{__('email')}}</label>
                                    <input type="email" name="email" class="form-control" id="email">
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
                                    <label>{{awtTrans('اعادة كلمة المرور')}}</label>
                                    <input type="password" name="password_confirmation" class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-sm-12 mb-3">
                                <div class="form-group">
                                    <label>{{awtTrans('العنوان')}}</label>
                                    <input type="hidden" name="lat" id="lat" value="24.7135517">
                                    <input type="hidden" name="lng" id="lng" value="46.67529569999999">
                                    <input type="text" name="address" id="address" class="form-control pac-target-input" value="" placeholder="{{awtTrans('قم بادخال ...')}}" autocomplete="off">
                                    <div id="map" style="height: 300px"></div>
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
            $('.table thead tr:first th:first').html(`
                            <label class="custom-control material-checkbox" style="margin: auto">
                                <input type="checkbox" class="material-control-input" id="checkedAll">
                                <span class="material-control-indicator"></span>
                            </label>`);
        });
        $('.add-user').on('click',function () {
            $('#editModel .modal-title').text(`{{awtTrans('اضافة عميل')}}`);
            $('#editForm :input:not([type=checkbox],[type=radio],[type=hidden])').val('');
            $( '#upload_area_img' ).empty();
            $('#editForm')      .attr("action","{{route('admin.accountants.store')}}");
        });
        function edit(ob){
            $('#password')         .val('');
            $('#editForm')      .attr("action","{{route('admin.accountants.update','obId')}}".replace('obId',ob.id));
            $('#name')    .val(ob.name);
            $('#phone')         .val(ob.phone);
            $('#email')         .val(ob.email);
            $('#address')         .val(ob.address);
            $('#lat')         .val(ob.lat);
            $('#lng')         .val(ob.lng);
            // $('#country_id')         .val(ob.country_id).change;
            // getCities(ob.country_id,ob.city_id);

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
    </script>
@endpush

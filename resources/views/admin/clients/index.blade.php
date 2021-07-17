@extends('admin.layout.master')
@section('content')


    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 ">
                    <div class="page-header callout-primary d-flex justify-content-between">
                        <h2>العملاء</h2>
                        <button class="btn btn-warning btn-wide waves-effect waves-light all" onclick="sendNotify('all' , '0')" data-toggle="modal" data-target="#send-noti">
                            <i class="fas fa-paper-plane"></i>ارسال اشعارات للجميع
                        </button>
                        <button type="button" data-toggle="modal" data-target="#editModel" class="btn btn-primary btn-wide waves-effect waves-light add-user">
                            <i class="fas fa-plus"></i> اضافة عميل
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card page-body">
            <div class="table-responsive">
                {!! $dataTable->table([
                 'class' => "table table-striped table-bordered dt-responsive nowrap",
                 'id' => "clientdatatable-table",
                 ],true) !!}
            </div>
        </div>
    </section>



    <!-- send-noti modal-->
    <div class="modal fade" id="send-noti"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">إرسال أشعار</h5>
                </div>
                <div class="modal-body">
                    <form action="" id="sendnotifyuserForm" method="POST">
                        @csrf
                        <input type="hidden" name="type" id="notify_type" value="client">
                        <input type="hidden" name="id" id="notify_id">
                        <div class="form-group">
                            <label for="">
                                الرسالة
                            </label>
                            <textarea name="message" id="notifyMessage" cols="30" rows="4" class="form-control"
                                      placeholder="اكتب رسالتك ..."></textarea>
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
                    <h5 class="modal-title" id="exampleModalLabel">إرسال للمحفظه</h5>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.addToWallet')}}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="user_id">
                        <div class="form-group">
                            <label for="">
                                القيمه
                            </label>
                            <input type="number" min="0" value="0" name="wallet" class="form-control">
                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="submit" class="btn btn-sm btn-success">إرسال</button>
                            <button type="button" class="btn btn-default" id="notifyClose" data-dismiss="modal">اغلاق</button>
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
                <div class="modal-header"><h4 class="modal-title">تعديل عميل</h4></div>
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
                                    <label>اعادة كلمة المرور</label>
                                    <input type="password" name="password_confirmation" class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-sm-12 mb-3">
                                <div class="form-group">
                                    <label>العنوان</label>
                                    <input type="hidden" name="lat" id="lat" value="24.7135517">
                                    <input type="hidden" name="lng" id="lng" value="46.67529569999999">
                                    <input type="text" name="address" id="address" class="form-control pac-target-input" value="" placeholder="Enter a query" autocomplete="off">
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
    <script src="{{dashboard_url('dashboard/js/map.js')}}"></script>
    <script
            src="https://maps.googleapis.com/maps/api/js?key={{settings('map_key')}}&libraries=places&callback=initMap"
            async defer></script>
    <script>
        $('.add-user').on('click',function () {
            $('#editModel .modal-title').text('اضافة عميل');
            $('#editForm :input:not([type=checkbox],[type=radio],[type=hidden])').val('');
            $( '#upload_area_img' ).empty();
            $('#editForm')      .attr("action","{{route('admin.clients.store')}}");
        });
        $(function () {
            'use strict'
            footerBtn(`{{route('admin.clients.delete',0)}}`);
        });
        function edit(ob){
            $('#password')         .val('');
            $('#editForm')      .attr("action","{{route('admin.clients.update','obId')}}".replace('obId',ob.id));
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

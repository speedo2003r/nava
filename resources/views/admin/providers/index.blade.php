@extends('admin.layout.master')
@section('content')

    @push('css')
        <style>
            .uploaded-block2{
                height: 200px;
                display: inline-flex;
            }
        </style>
    @endpush

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 ">
                    <div class="page-header callout-primary d-flex justify-content-between add-user">
                        <h2>{{awtTrans('مقدمي الخدمه')}}</h2>
                        <button class="btn btn-warning btn-wide waves-effect waves-light" onclick="sendNotify('all' , '0')" data-toggle="modal" data-target="#send-noti">
                            <i class="fas fa-paper-plane"></i>ارسال اشعارات للجميع
                        </button>
                        <button type="button" data-toggle="modal" data-target="#addModel" class="btn btn-primary btn-wide waves-effect waves-light">
                            <i class="fas fa-plus"></i> اضافة مقدم خدمه جديد
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card page-body">
            <div class="table-responsive">
                {!! $dataTable->table([
                 'class' => "table table-striped table-bordered dt-responsive nowrap",
                 'id' => "providerdatatable-table",
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
                        <input type="hidden" name="type" id="notify_type" value="supervisor">
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
                            <button type="button" class="btn btn-default" data-dismiss="modal">اغلاق</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end send-noti modal-->

 <!-- add model -->
    <div class="modal fade" id="addModel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header"><h4 class="modal-title">اضافة مقدم خدمه</h4></div>
                <form action="{{route('admin.providers.store')}}" id="editForm" method="post" role="form" enctype="multipart/form-data">
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
                            <div class = "col-sm-12 text-center">
                                <label class = "mb-0">بانر</label>
                                <div class = "text-center">
                                    <div class = "images-upload-block single-image">
                                        <label class = "upload-img">
                                            <input type = "file" name = "_banner" id = "banner" accept = "image/*" class = "image-uploader" >
                                            <i class="fas fa-cloud-upload-alt"></i>
                                        </label>
                                        <div class = "upload-area upload_area_img2" id="upload_area_img"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>{{__('name')}}</label>
                                    <input type="text" name="name" id="name" value="{{old('name')}}" class="form-control">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>{{__('phone')}}</label>
                                    <input type="number" name="phone" id="phone" value="{{old('phone')}}" class="form-control">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>اسم مقدم الخدمه التجاري بالعربي</label>
                                    <input type="text" name="store_name_ar" id="store_name_ar" value="{{old('store_name_ar')}}" class="form-control">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>اسم مقدم الخدمه التجاري بالانجليزي</label>
                                    <input type="text" name="store_name_en" id="store_name_en" value="{{old('store_name_en')}}" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>{{__('email')}}</label>
                                    <input type="email" name="email" id="email" value="{{old('email')}}" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>القسم</label>
                                    <select name="category_id" id="category_id" class="form-control">
                                        <option value="" hidden selected>اختر</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category['id']}}">{{$category['title']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 subcat">
                                <div class="form-group" style="display: none">
                                    <label>الأقسام الفرعيه</label>
                                    <div class="form-group services"></div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>وصف الخدمه بالعربي</label>
                                    <textarea name="service_desc_ar" id="service_desc_ar" class="form-control" rows="5"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>وصف الخدمه بالانجليزي</label>
                                    <textarea name="service_desc_en" id="service_desc_en" class="form-control" rows="5"></textarea>
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
                                    <input type="hidden" name="lat" id="lat">
                                    <input type="hidden" name="lng" id="lng">
                                    <input type="text" name="address" id="address" class="form-control" value="" placeholder="Enter a query" autocomplete="off">
                                    <div id="map" style="height: 300px"></div>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-3">
                                <div class="form-group">
                                    <label>وصف العوان تفصيلا</label>
                                    <input type="text" name="address_desc" id="address_desc" class="form-control" value="" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>رقم الهويه</label>
                                    <input type="number" name="id_num" id="id_num" value="{{old('commercial_num')}}" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>العموله قيمه أو نسبه</label>
                                    <div class="radio-group">
                                        <div class="row text-center">
                                            <div class="form-group col-sm-6">
                                                <label for="seller">
                                                    <input type="radio" name="commission_status" value="1" class="form-control" id="value">
                                                    قيمه
                                                </label>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="item">
                                                    <input type="radio" name="commission_status" value="2" class="form-control" id="percentage">
                                                    نسبه
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>العموله</label>
                                    <input type="number" name="commission" id="commission" value="{{old('commission')}}" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-primary">حفظ</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">اغلاق</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-- end add model -->

@endsection
@push('js')
    {!! $dataTable->scripts() !!}
    <script src="{{dashboard_url('dashboard/js/map.js')}}"></script>
    <script
            src="https://maps.googleapis.com/maps/api/js?key={{settings('map_key')}}&libraries=places&callback=initMap&language=ar"
            async defer></script>
    <script>
        $(function () {
            'use strict'
            footerBtn(`{{route('admin.providers.delete',0)}}`);
            $('body').on('change','[name=country_id]',function () {
                var id = $(this).val();
                getCities(id);
            });
        });
    </script>
    <script>
        $('.add-user').on('click',function () {
            $('#addModel .modal-title').text('اضافة مقدم خدمه');
            $('[name=city_id]').empty();
            $('#editForm :input:not([type=radio],[type=hidden])').val('');
            $( '#upload_area_img' ).empty();
            $('#editForm')      .attr("action","{{route('admin.providers.store')}}");

            $('.subcat').css({display:'none'});
            var $checkboxs = $('input:checkbox');
            var $radios = $('input:radio');
            $radios.prop('checked', false);
            $checkboxs.prop('checked', false);
        });

        function edit(ob){

            $('.subcat').css({display:'block'});
            var $radios = $('input:radio[name=commission_status]');
            $('#editForm')      .attr("action","{{route('admin.providers.update','obId')}}".replace('obId',ob.id));
            $('#name')    .val(ob.name);
            $('#phone')         .val(ob.phone);
            $('#email')         .val(ob.email);
            $('#address')         .val(ob.address);
            $('#address_desc')         .val(ob.address_desc);
            $('#service_desc_ar')         .val(ob.service_desc.ar);
            $('#service_desc_en')         .val(ob.service_desc.en);
            $('#id_num')         .val(ob.id_num);
            $('#lat')         .val(ob.lat);
            $('#lng')         .val(ob.lng);
            $('#commission')         .val(ob.commission);

            $radios.filter(`[value=${ob.commission_status}]`).prop('checked', true);
            $('#category_id')         .val(ob.category_id).change;
            if(ob.store_name != null){
                $('#store_name_ar')         .val(ob.store_name.ar);
                $('#store_name_en')         .val(ob.store_name.en);
            }
            var tokenv  = "{{csrf_token()}}";
            getCategories(ob.category_id,tokenv,ob.categories);
            initMap();
            $('#commission_status').val(ob.commission_status).prop('checked',true);

            if ( ob.banned == 1 )
                $( "#banned" ).attr( 'checked', '' );
            else
                $( "#banned" ).removeAttr( 'checked', '' );


            let file = $('.upload_area_img2');
            file.empty();
            file.append( '<div class="uploaded-block" data-count-order="1"><a href="' + ob.banner + '"  data-fancybox data-caption="' + ob.banner + '" ><img src="' + ob.banner + '"></a><button class="close">&times;</button></div>' );

            let image = $( '#upload_area_img' );
            image.empty();
            image.append( '<div class="uploaded-block" data-count-order="1"><a href="' + ob.avatar + '"  data-fancybox data-caption="' + ob.avatar + '" ><img src="' + ob.avatar + '"></a><button class="close">&times;</button></div>' );
        }


        $('body').on('change','#category_id',function () {
            var tokenv  = "{{csrf_token()}}";
            var category = $(this).val();
            getCategories(category,tokenv)
        });
        function getCategories(category,tokenv,services = []){
            $('.services').empty();
            $.ajax({
                type        : 'POST',
                url         : '{{ route('admin.ajax.getCategories') }}' ,
                datatype    : 'json' ,
                data        : {category: category,'_token':tokenv},
                success     : function(data){
                    if(data.value == 0){
                        $('.services').parent().css({'display':'none'});
                    }else{
                        var html = ``;
                        if(data.data.length > 0){
                            $('.services').parent().css({'display':'block'});
                        }else{
                            $('.services').parent().css({'display':'none'});
                        }
                        $.each(data.data,(index,value)=>{
                            html += `<label class="control-label mx-2">
                                        <input type="checkbox" name="categories[]" class="subs" value="${value.id}">
                                        ${value.title.ar}
                                    </label>`;
                        });
                        $('.services').append(html);
                        if(services.length > 0){
                            $(".subs").prop("checked", false);
                            services.forEach(function(value) {
                                $('.subs:checkbox[value="' + value.id + '"]').prop('checked', true);
                            });
                        }
                    }
                }
            });
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

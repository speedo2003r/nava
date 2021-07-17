@extends('admin.layout.master')
@section('content')


    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 ">
                    <div class="page-header callout-primary d-flex justify-content-between">
                        <h2>بنرات متحركه</h2>
                        <button type="button" data-toggle="modal" data-target="#editModel" class="btn btn-primary btn-wide waves-effect waves-light add-user">
                            <i class="fas fa-plus"></i> اضافة بنر
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card page-body">
            <div class="table-responsive">
                {!! $dataTable->table([
                 'class' => "table table-striped table-bordered dt-responsive nowrap",
                 'id' => "sliderdatatable-table",
                 ],true) !!}
            </div>
        </div>
    </section>


    <!-- add model -->
    <div class="modal fade" id="editModel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header"><h4 class="modal-title">اضافة بنر</h4></div>
                <form id="editForm" action="{{route('admin.sliders.store')}}" method="post" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
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
                            <div class="col-sm-12 my-4 radio-group">
                                <div class="row text-center">
                                    <div class="form-group col-sm-6">
                                        <label for="service">
                                            <input type="radio" name="type" value="service" class="form-control type" id="service">
                                            خدمه
                                        </label>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="item">
                                            <input type="radio" name="type" value="ad" class="form-control type" id="ad">
                                            اعلان
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>المسمي بالعربي</label>
                                    <input type="text" name="title_ar" id="title_ar" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>المسمي بالانجليزي</label>
                                    <input type="text" name="title_en" id="title_en" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6 sellers">
                                <label>المتاجر</label>
                                <select name="user_id" required id="user_id" class="form-control edit_stores">
                                    <option value="" hidden selected>اختر</option>
                                    @foreach($sellers as $seller)
                                        <option value="{{$seller['id']}}">{{$seller['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6 items" style="display: none">
                                <label>الخدمات</label>
                                <select name="service_id" id="service_id" class="form-control edit_items">
                                    <option value="" hidden selected>اختر</option>
                                </select>
                            </div>
                            <div class="col-sm-6 ads" style="display: none">
                                <label>اعلانات</label>
                                <select name="ad_id" id="ad_id" class="form-control edit_ads">
                                    <option value="" hidden selected>اختر</option>
                                </select>
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
    <!-- end add model -->


@endsection
@push('js')
    {!! $dataTable->scripts() !!}
    <script>
        $(function () {
            'use strict'
            footerBtn(`{{route('admin.sliders.destroy',0)}}`);
        });

        $('.add-user').on('click',function () {
            $('#editModel .modal-title').text('اضافة بنر');
            $('#editForm :input:not([type=checkbox],[type=radio],[type=hidden])').val('');
            $( '#upload_area_img' ).empty();
            $('#editForm')      .attr("action","{{route('admin.sliders.store')}}");

            var $radios = $('input:radio');
            $radios.prop('checked', false);
        });
        function changeActive(id) {
            $.ajax({
                type     : 'POST',
                url      : `{{route('admin.sliders.changeActive')}}`,
                datatype : 'json' ,
                data     : {
                    'id'         :  id
                }, success   : function(res){
                    //
                }
            });
        }
    </script>

    <script>

        $(function () {
            'use strict'
            $('body').on('change','#user_id',function () {
                var id = $(this).val();
                getItems(id);
                getAds(id);
            });
            $('body').on('change','input[name=type]',function () {
                var type = $(this).val();
                changeType(type);
                var user_id = $('.edit_stores').val();
                if(type == 'service'){
                    if(user_id != ''){
                        getItems(user_id);
                    }
                }
                if(type == 'ad'){
                    if(user_id != ''){
                        getAds(user_id);
                    }
                }
            });
            $('body').on('click','.add-user',function () {
                $('.sellers')   .css({'display':'none'});
                $('.items')     .css({'display':'none'});
                $('#addModel :input:not([type=checkbox],[type=radio],[type=hidden])').val('');
                $('#addModel input[type=radio]').each(function () {
                    $(this).prop('checked',false)
                });
            });
        });
        function changeType(type){
            var user_id = $('.edit_stores').val();
            if(type == 'service'){
                $('.sellers').css({display:'block'});
                $('.items').css({display:'block'});
                $('.ads').css({display:'none'});

            }
            if(type == 'ad'){
                $('.sellers').css({display:'block'});
                $('.items').css({display:'none'});
                $('.ads').css({display:'block'});
            }
            // if(type != 'provider' && type != 'service' && type != 'ad'){
            //     $('.sellers').css({display:'none'});
            //     $('.items').css({display:'none'});
            //     $('.ads').css({display:'none'});
            // }
        }
        function edit(ob){
            $('#editForm')      .attr("action","{{route('admin.sliders.update','obId')}}".replace('obId',ob.id));
            $('#title_ar')    .val(ob.title.ar);
            $('#title_en')     .val(ob.title.en);
            $('#user_id')     .val(ob.user_id).change;
            $('.type[value=' + ob.type + ']').prop('checked', true);

            changeType(ob.type);
            if(ob.type == 'service'){
                getItems(ob.user_id,ob.itemable_id);
            }
            if(ob.type == 'ad'){
                getAds(ob.user_id,ob.itemable_id);
            }

            let image = $( '#upload_area_img' );
            image.empty();
            image.append( '<div class="uploaded-block" data-count-order="1"><img src="' + ob.image + '"><button class="close">&times;</button></div>' );
        }
        function getItems(id,item_id=''){
            var html = '';
            $('.edit_items').empty();
            if(id > 0){
                $.ajax({
                    url:`{{route('admin.ajax.getItems')}}`,
                    type:'get',
                    postType:'json',
                    data: {id: id},
                    success:function (data) {
                        html += `<option value="" hidden selected>اختر</option>`;
                        $.each(data,function (index,value) {
                            html += `<option value="${value.id}" ${item_id == value.id ? 'selected' : '' }>${value.title.ar}</option>`;
                        });
                        $('.edit_items').append(html);
                        // if(item_id != ''){
                        //     $('.edit_items')     .val(item_id).change;
                        // }
                    }
                });
            }
        }
        function getAds(id,ad_id=''){
            var html = '';
            $('.edit_ads').empty();
            if(id > 0){
                $.ajax({
                    url:`{{route('admin.ajax.getAds')}}`,
                    type:'get',
                    postType:'json',
                    data: {id: id},
                    success:function (data) {
                        html += `<option value="" hidden selected>اختر</option>`;
                        $.each(data,function (index,value) {
                            html += `<option value="${value.id}">${value.title.ar}</option>`;
                        });
                        $('.edit_ads').append(html);
                        if(ad_id != ''){
                            $('.edit_ads')     .val(ad_id).change;
                        }
                    }
                });
            }
        }


        function reset(){
            $(".edit_stores").val('').change();
            $(".stores").val('').change();
            $("input[name='item_id']").val('').change();
            $("input[name='user_id']").val('');
            $("input[name='type']").removeAttr( 'checked', '' );
            $( "#status" ).removeAttr( 'checked', '' );
        }
    </script>
@endpush

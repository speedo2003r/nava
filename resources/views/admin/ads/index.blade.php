@extends('admin.layout.master')
@section('content')
@push('css')
    <style>
        .uploaded-block2{
            height: 200px;
        }
    </style>
@endpush

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 ">
                    <div class="page-header callout-primary d-flex justify-content-between">
                        <h2>الأعلانات</h2>
                        <button type="button" data-toggle="modal" data-target="#editModel" class="btn btn-primary btn-wide waves-effect waves-light add-user">
                            <i class="fas fa-plus"></i> اضافة اعلان
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card page-body">
            <div class="table-responsive">
                {!! $dataTable->table([
                 'class' => "table table-striped table-bordered dt-responsive nowrap",
                 'id' => "addatatable-table",
                 ],true) !!}
            </div>
        </div>
    </section>


 <!-- add model -->
 <div class="modal fade" id="editModel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">اضافة اعلان</h4></div>
            <form action="{{route('admin.ads.store')}}" method="post" id="editForm" role="form" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">

                        <div class = "col-sm-12 text-center">
                            <label class = "mb-0">صورة الاعلان التعريفيه</label>
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
                        <div class = "col-sm-12 text-center">
                            <label class = "mb-0">الاعلان</label>
                            <div class = "text-center">
                                <div class = "files-upload-block single-image">
                                    <label class = "upload-file">
                                        <input type = "file" name = "file" id = "file" class = "file-uploader">
                                    </label>
                                    <div class = "upload-area" id="upload_area_img2" style="margin-bottom: 30px;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>مقدمي الخدمه</label>
                                <select name="user_id" id="user_id" class="form-control">
                                    <option value="" hidden selected>اختر</option>
                                    @foreach($providers as $provider)
                                        <option value="{{$provider['id']}}">{{$provider['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>اسم الاعلان بالعربي</label>
                                <input type="text" name="title_ar" id="title_ar" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>اسم الاعلان بالانجليزي</label>
                                <input type="text" name="title_en" id="title_en" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>الجوال</label>
                                <input type="text" name="phone" id="phone" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>الواتس أب</label>
                                <input type="text" name="whatsapp" id="whatsapp" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>الوصف بالعربي</label>
                                <textarea rows="5" name="desc_ar" id="desc_ar" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>الوصف بالانجليزي</label>
                                <textarea rows="5" name="desc_en" id="desc_en" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>نهاية الاشتراك</label>
                                <input type="date" name="end_date" id="end_date" class="form-control">
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
<!-- end add model -->
@endsection
@push('js')
    {!! $dataTable->scripts() !!}
    <script>
        $('.add-user').on('click',function () {
            $('#addModel .modal-title').text('اضافة اعلان');
            $('#editForm :input:not([type=checkbox],[type=radio],[type=hidden])').val('');
            $( '#upload_area_img' ).empty();
            $( '#upload_area_img2' ).empty();
            $('#editForm')      .attr("action","{{route('admin.ads.store')}}");

            var $radios = $('input:radio');
            $radios.prop('checked', false);
        });
        function checkFileExtension(selector) {
            fileName = document.querySelector(selector).value;
            extension = fileName.substring(fileName.lastIndexOf('.') + 1);
            return extension;
        };
        //img uploader
        $( document ).on( 'change', '.file-uploader', function (event) {
            // $('.image-uploader').change(function (event) {
            for (var one = 0; one < event.target.files.length; one++) {
                // alert(1);
                if(checkFileExtension('.file-uploader') == 'mp4' || checkFileExtension('.file-uploader') == 'mov' || checkFileExtension('.file-uploader') == 'mkv' || checkFileExtension('.file-uploader') == 'ogg' || checkFileExtension('.file-uploader') == 'avi'){
                    $(this).parents('.files-upload-block').find('.upload-area').append('<div class="uploaded-block2" data-count-order="' + one + '"><button class="close" type="button">&times;</button><video class="form-control" style="height: 175px; width: 100%" controls src="' + URL.createObjectURL(event.target.files[one]) + '"  ></video></div>');
                }else{
                    $(this).parents('.files-upload-block').find('.upload-area').append('<div class="uploaded-block2" data-count-order="' + one + '"><a href="' + URL.createObjectURL(event.target.files[one]) + '"  data-fancybox data-caption="' + URL.createObjectURL(event.target.files[one]) + '" ><img style="width: 100%" src="' + URL.createObjectURL(event.target.files[one]) + '"></a><button class="close" type="button">&times;</button></div>');
                }

            }
        });

        $('body').on('click', '.files-upload-block .close',function (){
            $(this).parents('.uploaded-block2').remove();
            $('#file').val('');
        });
        function lastWord(words) {
            var n = words.split(".").pop();
            return n;
        }
        function edit(ob){
            $('#editForm')      .attr("action","{{route('admin.ads.update','obId')}}".replace('obId',ob.id));
            $('#user_id')    .val(ob.user_id).change;
            $('#title_ar')    .val(ob.title.ar);
            $('#title_en')     .val(ob.title.en);
            $('#phone')     .val(ob.phone);
            $('#whatsapp')     .val(ob.whatsapp);
            $('#desc_ar')     .val(ob.desc.ar);
            $('#desc_en')     .val(ob.desc.en);
            $('#end_date')     .val(ob.end_date);
            let file = $('#upload_area_img2');
            file.empty();
            if(lastWord(ob.file) == 'mp4' || lastWord(ob.file) == 'mov' || lastWord(ob.file) == 'mkv' || lastWord(ob.file) == 'ogg' || lastWord(ob.file) == 'avi'){
                file.append('<div class="uploaded-block2"><button class="close" type="button">&times;</button><video class="form-control" style="height: 175px; width: 100%" controls src="' + ob.file + '"  ></video></div>');
            }else{
                file.append( '<div class="uploaded-block2"><button class="close" type="button">&times;</button><a href="' + ob.file + '"  data-fancybox data-caption="' + ob.file + '" ><img src="' + ob.file + '" style="height: 100%;width: 100%;" ></a></div>' );
            }
            let image = $('#upload_area_img');
            image.empty();
            image.append( '<div class="uploaded-block" data-count-order="1"><a href="' + ob.image + '"  data-fancybox data-caption="' + ob.image + '" ><img src="' + ob.image + '"></a><button class="close">&times;</button></div>' );
        }
    </script>
@endpush

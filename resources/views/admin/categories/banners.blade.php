@extends('admin.layout.master')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 ">
                <div class="page-header callout-primary d-flex justify-content-between">
                    <h2>البنرات الثابته</h2>
                    <button type="button" data-toggle="modal" data-target="#addModel" class="btn btn-primary btn-wide waves-effect waves-light">
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
             'id' => "bannerdatatable-table",
             ],true) !!}
        </div>
    </div>
    <

    <!-- add model -->
    <div class="modal fade" id="addModel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header"><h4 class="modal-title">اضافة بنر</h4></div>
                <form action="{{route('admin.banners.store',$category['id'])}}" method="post" role="form" enctype="multipart/form-data">
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
                                        <div class = "upload-area"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>المسمي</label>
                                    <input type="text" name="title" class="form-control">
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

    <!-- edit model -->
    <div class="modal fade" id="editModel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header"><h4 class="modal-title">تعديل البنر</h4></div>
                <form action=""  id="editForm" method="post" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class = "col-sm-12 text-center">
                                <label class = "mb-0">الصوره</label>
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
                                    <label>المسمي</label>
                                    <input type="text" name="title" id="title" class="form-control">
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
        <script>
            $(function () {
                'use strict'
                footerBtn(`{{route('admin.banners.destroy',0)}}`);
            });

            function changeActive(id) {
                $.ajax({
                    type     : 'POST',
                    url      : `{{route('admin.banners.changeActive')}}`,
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
                $('body').on('change','#city_id2',function () {
                    var id = $(this).val();
                    getSellers2(id);
                });
                $('body').on('change','#city_id',function () {
                    var id = $(this).val();
                    getSellers(id);
                });
                // $('body').on('change','#branch_id',function () {
                //     var id = $(this).val();
                //     getItems(id);
                // });
                $('body').on('click','.add-user',function () {
                    $('.sellers2')   .css({'display':'none'});
                    $('.items2')     .css({'display':'none'});
                    $('.cities')     .empty();
                    $('#addModel :input:not([type=checkbox],[type=radio],[type=hidden])').val('');
                    $('#addModel input[type=radio]').each(function () {
                        $(this).prop('checked',false)
                    });
                });
            });
            function edit(ob){
                reset();
                $('#editForm')      .attr("action","{{route('admin.banners.update','obId')}}".replace('obId',ob.id));
                $('#title')    .val(ob.title);
                if ( ob.active == 1 )
                    $( "#active" ).prop( 'checked', true );
                else
                    $( "#active" ).prop( 'checked', false );


                let image = $( '#upload_area_img' );
                image.empty();
                image.append( '<div class="uploaded-block" data-count-order="1"><img src="' + ob.image + '"><button class="close">&times;</button></div>' );
            }
            function reset(){
                $(".edit_stores").val('').change();
                $(".stores").val('').change();
                $("input[name='item_id']").val('').change();
                $("input[name='provider_id']").val('');
                $("input[name='type']").removeAttr( 'checked', '' );
                $( "#status" ).removeAttr( 'checked', '' );
            }
        </script>
@endpush




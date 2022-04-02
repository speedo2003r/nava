@extends('admin.layout.master')
@section('title',awtTrans('بنرات متحركه'))
@section('breadcrumb')
    <a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName()) }}" class="kt-subheader__breadcrumbs-link">
        {{ awtTrans('بنرات متحركه') }}</a>
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
                                    {{awtTrans('بنرات متحركه')}}
                                </h3>
                            </div>
                        </div>

                        <div class="kt-portlet__head-label mt-3">
                            <button type="button" data-toggle="modal" data-target="#editModel" class="btn btn-brand btn-elevate btn-icon-sm add-user">
                                <i class="la la-plus"></i>
                                {{awtTrans('اضافه')}}
                            </button>

                            <button class="btn btn-brand btn-elevate btn-icon-sm confirmDel" disabled onclick="deleteAllData('more','{{route('admin.cities.destroy',0)}}')" data-toggle="modal" data-target="#confirm-all-del">
                                <i class="la la-trash"></i>
                                {{awtTrans('حذف')}}
                            </button>
                        </div>


                        <div class="kt-portlet__body kt-portlet__body--fit  margin-15 ">
                            <div class="table-responsive">
                                {!! $dataTable->table([
                                 'class' => "table table-striped table-bordered dt-responsive nowrap",
                                 'id' => "sliderdatatable-table",
                                 ],true) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <!-- end:: Content -->
    </div>


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
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>المسمي</label>
                                    <input type="text" name="title" id="title" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label>المدن</label>
                                <select name="city_id" id="city_id" class="form-control edit_ads">
                                    <option value="" hidden selected>كل المدن</option>
                                    @foreach($cities as $city)
                                        <option value="{{$city['id']}}">{{$city['title']}}</option>
                                    @endforeach
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
            $('body').on('click','.add-user',function () {
                $('#addModel :input:not([type=checkbox],[type=radio],[type=hidden])').val('');
            });
        });

        function edit(ob){
            $('#editForm')      .attr("action","{{route('admin.sliders.update','obId')}}".replace('obId',ob.id));
            $('#title')    .val(ob.title);
            $('#city_id')     .val(ob.city_id).change;
            $('.type[value=' + ob.type + ']').prop('checked', true);


            let image = $( '#upload_area_img' );
            image.empty();
            image.append( '<div class="uploaded-block" data-count-order="1"><img src="' + ob.image + '"><button class="close">&times;</button></div>' );
        }

    </script>
@endpush

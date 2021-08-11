@extends('admin.layout.master')
@section('title',awtTrans('قطع الغيار'))
@section('breadcrumb')
    <a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName(),$service['id']) }}" class="kt-subheader__breadcrumbs-link">
        {{ awtTrans('قطع الغيار') }}</a>
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
                                    {{awtTrans('قطع الغيار')}}
                                </h3>
                            </div>
                        </div>

                        <div class="kt-portlet__head-label mt-3">
                            <button type="button" data-toggle="modal" data-target="#editModel" class="btn btn-brand btn-elevate btn-icon-sm add-user">
                                <i class="la la-plus"></i>
                                {{awtTrans('اضافه')}}
                            </button>

                            <button class="btn btn-brand btn-elevate btn-icon-sm confirmDel" disabled onclick="deleteAllData('more','{{route('admin.parts.destroy',0)}}')" data-toggle="modal" data-target="#confirm-all-del">
                                <i class="la la-trash"></i>
                                {{awtTrans('حذف')}}
                            </button>
                        </div>


                        <div class="kt-portlet__body kt-portlet__body--fit  margin-15 ">

                            <div class="table-responsive">
                                {!! $dataTable->table([
                                 'class' => "table table-striped table-bordered dt-responsive nowrap",
                                 'id' => "partdatatable-table",
                                 ],true) !!}
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
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{awtTrans('السعر')}}</label>
                                        <input type="number" value="{{old('price')}}" class="form-control" name="price" id="price">
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
    {!! $dataTable->scripts() !!}
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
        }
    </script>
@endpush

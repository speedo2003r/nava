@extends('admin.layout.master')
@section('title',awtTrans('المناطق'))
@section('breadcrumb')
    <a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName()) }}" class="kt-subheader__breadcrumbs-link">
        {{ awtTrans('المناطق') }}</a>
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
                                    {{awtTrans('المناطق')}}
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
                            <!--begin: Datatable -->
                            <div class="table-responsive">
                                {!! $dataTable->table([
                                 'class' => "table table-striped table-bordered dt-responsive nowrap",
                                 'id' => "regionsdatatable-table",
                                 ],true) !!}
                            </div>
                            <!--end: Datatable -->
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <!-- end:: Content -->
    </div>
    <!-- end:: Footer -->
    <!-- end:: Page -->

    <!-- edit model -->
    <div class="modal fade" id="editModel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header"><h4 class="modal-title">{{awtTrans('تعديل المنطقه')}}</h4></div>
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
                                                <input type="text" value="{{old('title_'.$locale['lang'])}}" name="title_{{$locale['lang']}}" id="title_{{$locale['lang']}}" class="form-control" placeholder="{{__('enter')}} ..." required>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group">
                                <label>{{awtTrans('المدينه')}}</label>
                                <select name="city_id" id="city_id" class="form-control">
                                    <option value="" hidden selected>{{awtTrans('اختر')}}</option>
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
    <!-- end edit model -->
@endsection
@push('js')
    {!! $dataTable->scripts() !!}
    <script>
        $('.add-user').on('click',function () {
            $('#editModel .modal-title').text(`{{awtTrans('اضافة المنطقه')}}`);
            $('#editForm :input:not([type=checkbox],[type=radio],[type=hidden])').val('');
            $('#editForm')      .attr("action","{{route('admin.regions.store')}}");
        });
        function edit(ob){
            $('#editModel .modal-title').text(`{{awtTrans('تعديل المنطقه')}}`);
            $('#editForm')      .attr("action","{{route('admin.regions.update','obId')}}".replace('obId',ob.id));
            @foreach(\App\Entities\Lang::all() as $key => $locale)
            $('#title_{{$locale['lang']}}')    .val(ob.title.{{$locale['lang']}});
            @endforeach
            $('#city_id').val(ob.city_id).change;
        }

    </script>

@endpush

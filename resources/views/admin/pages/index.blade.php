@extends('admin.layout.master')
@section('title',awtTrans('الصفحات الأساسيه'))
@section('breadcrumb')
    <a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName()) }}" class="kt-subheader__breadcrumbs-link">
        {{ awtTrans('الصفحات الأساسيه') }}</a>
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
                                    {{awtTrans('الصفحات الأساسيه')}}
                                </h3>
                            </div>
                        </div>



                        <div class="kt-portlet__body kt-portlet__body--fit  margin-15 ">
                            <div class="table-responsive">
                                <table id="datatable-table" class="table table-striped table-bordered dt-responsive nowrap"  style="width:100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{__('name')}}</th>
                        <th>{{__('control')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pages as $ob)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$ob->title}}</td>
                            <td class="tAction">
                                <button onclick="edit({{$ob}})" data-toggle="modal" data-target="#editModel" data-placement="top" data-original-title="{{awtTrans('تعديل')}}"  class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                    <i class="la la-cog"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <!-- end:: Content -->
    </div>


    <!-- end add model -->

    <!-- edit model -->
    <div class="modal fade" id="editModel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header"><h4 class="modal-title">تعديل الصفحه</h4></div>
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
                                            <div class="form-group">
                                                <label>{{awtTrans('التفاصيل')}}</label>
                                                <textarea id="desc_{{$locale['lang']}}" name="desc_{{$locale['lang']}}" class="form-control" cols="30" rows="10">{{old('desc_'.$locale['lang'])}}</textarea>
                                            </div>
                                        </div>
                                    @endforeach
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
    <script>

        function edit(ob){

            $('#editForm')      .attr("action","{{route('admin.pages.update','obId')}}".replace('obId',ob.id));
            @foreach(\App\Entities\Lang::all() as $key => $locale)
            $('#title_{{$locale['lang']}}')    .val(ob.title.{{$locale['lang']}});
            $('#desc_{{$locale['lang']}}')    .val(ob.desc.{{$locale['lang']}});
            @endforeach
        }
    </script>
@endpush

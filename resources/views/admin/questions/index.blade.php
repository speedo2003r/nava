@extends('admin.layout.master')
@section('title',awtTrans('الأسئله والأجوبه'))
@section('breadcrumb')
    <a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName()) }}" class="kt-subheader__breadcrumbs-link">
        {{ awtTrans('الأسئله والأجوبه') }}</a>
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
                                    {{awtTrans('الأسئله والأجوبه')}}
                                </h3>
                            </div>
                        </div>

                        <div class="kt-portlet__head-label mt-3">
                            <button type="button" data-toggle="modal" data-target="#editModel" class="btn btn-brand btn-elevate btn-icon-sm add-user">
                                <i class="la la-plus"></i>
                                {{awtTrans('اضافه')}}
                            </button>

                            <button class="btn btn-brand btn-elevate btn-icon-sm confirmDel" disabled onclick="deleteAllData('more','{{route('admin.questions.destroy',0)}}')" data-toggle="modal" data-target="#confirm-all-del">
                                <i class="la la-trash"></i>
                                {{awtTrans('حذف')}}
                            </button>
                        </div>


                        <div class="kt-portlet__body kt-portlet__body--fit  margin-15 ">
                            <div class="table-responsive">
                                <table id="datatable-table" class="table table-striped table-bordered dt-responsive nowrap"  style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>
                                            <label class="custom-control material-checkbox" style="margin: auto">
                                                <input type="checkbox" class="material-control-input" id="checkedAll">
                                                <span class="material-control-indicator"></span>
                                            </label>
                                        </th>
                                        <th>سؤال</th>
                                        <th>{{__('control')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($questions as $ob)
                                        <tr>
                                            <td>
                                                <label class="custom-control material-checkbox" style="margin: auto">
                                                    <input type="checkbox" class="material-control-input checkSingle" id="{{$ob->id}}">
                                                    <span class="material-control-indicator"></span>
                                                </label>
                                            </td>
                                            <td>{{$ob->key}}</td>
                                            <td class="tAction">
                                                <button onclick="edit({{$ob}})" data-toggle="modal" data-target="#editModel" data-placement="top" data-original-title="{{awtTrans('تعديل')}}"  class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                                    <i class="la la-cog"></i>
                                                </button>
                                                <button type="button"  onclick="confirmDelete('{{route('admin.questions.destroy',$ob->id)}}')" data-toggle="modal" data-target="#delete-model" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="" data-placement="top" data-original-title="{{awtTrans('حذف')}}" style="cursor: pointer">
                                                    <i    class="la la-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!--end: Datatable -->
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
            <div class="modal-header"><h4 class="modal-title">تعديل دوله</h4></div>
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
                                            <input type="text" value="{{old('key_'.$locale['lang'])}}" name="key_{{$locale['lang']}}" id="key_{{$locale['lang']}}" class="form-control" placeholder="{{__('enter')}} ..." required>
                                        </div>
                                        <div class="form-group">
                                            <textarea rows="5" name="value_{{$locale['lang']}}" id="value_{{$locale['lang']}}" class="form-control" placeholder="{{__('enter')}} ..." required>{{old('value_'.$locale['lang'])}}</textarea>
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
        $('.add-user').on('click',function () {
            $('#editModel .modal-title').text(`{{awtTrans('اضافة سؤال')}}`);
            $('#editForm :input:not([type=checkbox],[type=radio],[type=hidden])').val('');
            $('#editForm')      .attr("action","{{route('admin.questions.store')}}");
        });
        function edit(ob){
            $('#editModel .modal-title').text(`{{awtTrans('تعديل سؤال')}}`);
            $('#editForm')      .attr("action","{{route('admin.questions.update','obId')}}".replace('obId',ob.id));
            @foreach(\App\Entities\Lang::all() as $key => $locale)
            $('#key_{{$locale['lang']}}')    .val(ob.key.{{$locale['lang']}});
            @endforeach
            @foreach(\App\Entities\Lang::all() as $key => $locale)
            $('#value_{{$locale['lang']}}')    .val(ob.value.{{$locale['lang']}});
            @endforeach
        }
    </script>
@endpush

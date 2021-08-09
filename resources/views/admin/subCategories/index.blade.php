@extends('admin.layout.master')
@section('title',awtTrans('الأقسام الفرعيه'))
@section('breadcrumb')
    <a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName(),$check['id']) }}" class="kt-subheader__breadcrumbs-link">
        {{ awtTrans('الأقسام الفرعيه') }}</a>
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
                                    {{awtTrans('الأقسام الفرعيه')}}
                                </h3>
                            </div>

                            <button class="btn btn-info btn-wide waves-effect waves-light" title="الاقسام" style="margin-top: 10px" onclick="back()">
                                <i class="fas fa-arrow-alt-circle-left"></i>{{awtTrans('الأقسام الرئيسيه')}}
                            </button>
                        </div>

                        <div class="kt-portlet__head-label mt-3">
                            <button type="button" data-toggle="modal" data-target="#editModel" class="btn btn-brand btn-elevate btn-icon-sm add-user">
                                <i class="la la-plus"></i>
                                {{awtTrans('اضافه')}}
                            </button>

                            <button class="btn btn-brand btn-elevate btn-icon-sm confirmDel" disabled onclick="deleteAllData('more','{{route('admin.subcategories.destroy',0)}}')" data-toggle="modal" data-target="#confirm-all-del">
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
                                        <th>{{__('name')}}</th>
                                        <th>{{__('control')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($subCategories as $ob)
                                        <tr>
                                            <td>
                                                <label class="custom-control material-checkbox" style="margin: auto">
                                                    <input type="checkbox" class="material-control-input checkSingle" id="{{$ob->id}}">
                                                    <span class="material-control-indicator"></span>
                                                </label>
                                            </td>
                                            <td>{{$ob->title}}</td>
                                            <td class="tAction">
                                                <button onclick="edit({{$ob}})" data-toggle="modal" data-target="#editModel" data-placement="top" data-original-title="{{awtTrans('تعديل')}}"  class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                                    <i class="la la-cog"></i>
                                                </button>
                                                <button type="button"  onclick="confirmDelete('{{route('admin.subcategories.destroy',$ob->id)}}')" data-toggle="modal" data-target="#delete-model" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="" data-placement="top" data-original-title="{{awtTrans('حذف')}}" style="cursor: pointer">
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
                <div class="modal-header"><h4 class="modal-title">تعديل القسم</h4></div>
                <form action=""  id="editForm" method="post" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body"> <div class="kt-portlet" style="padding-top:15px">
                            @include('components.lang_taps')
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
                            <div>
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
                            <div class="col-sm-12">
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
            $('#editModel .modal-title').text(`{{awtTrans('اضافة القسم الفرعي')}}`);
            $('#editForm :input:not([type=checkbox],[type=radio],[type=hidden])').val('');
            $( '#upload_area_img' ).empty();
            $('#editForm')      .attr("action","{{route('admin.subcategories.store',$check['id'])}}");
        });
        function edit(ob){
            $('#editModel .modal-title').text(`{{awtTrans('تعديل القسم الفرعي')}}`);
            $('#editForm')      .attr("action","{{route('admin.subcategories.update','obId')}}".replace('obId',ob.id));
            @foreach(\App\Entities\Lang::all() as $key => $locale)
            $('#title_{{$locale['lang']}}')    .val(ob.title.{{$locale['lang']}});
            @endforeach
            let image = $( '#upload_area_img' );
            image.empty();
            image.append( '<div class="uploaded-block" data-count-order="1"><img src="' + ob.icon + '"><button class="close">&times;</button></div>' );
        }
        function back() {
            window.location.assign("{{route('admin.categories.index')}}");
        }
    </script>
@endpush

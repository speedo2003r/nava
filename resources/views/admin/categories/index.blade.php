@extends('admin.layout.master')
@section('content')


    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 ">
                    <div class="page-header callout-primary d-flex justify-content-between">
                        <h2>الأقسام</h2>
                        <a href="{{route('admin.categories.view')}}" class="btn btn-warning btn-wide waves-effect waves-light">
                            <i class="fas fa-tree"></i> عرض شجري للأقسام
                        </a>
                        <button type="button" data-toggle="modal" data-target="#addModel" class="btn btn-primary btn-wide waves-effect waves-light">
                            <i class="fas fa-plus"></i> اضافة قسم
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card page-body">
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
                        <th>الأقسام الفرعيه</th>
                        <th>ظهور واخفاء من الرئيسيه</th>
                        <th>اضافة تعهد</th>
                        <th>{{__('control')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $ob)
                        <tr>
                            <td>
                                <label class="custom-control material-checkbox" style="margin: auto">
                                    <input type="checkbox" class="material-control-input checkSingle" id="{{$ob->id}}">
                                    <span class="material-control-indicator"></span>
                                </label>
                            </td>
                            <td>{{$ob->title}}</td>
                            <td><a href="{{route('admin.subcategories.index',$ob['id'])}}" class="btn btn-success">الأقسام الفرعيه ({{count($ob->children)}})</a></td>
                            <td>
                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success" style="direction: ltr">
                                    <input type="checkbox" onchange="changeCategoryAppear('{{$ob->id}}')" {{ $ob->status == 1 ? 'checked' : '' }} class="custom-control-input" id="customSwitch{{$ob->id}}">
                                    <label class="custom-control-label" id="status_label{{$ob->id}}" for="customSwitch{{$ob->id}}"></label>
                                </div>
                            </td>
                            <td>
                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success" style="direction: ltr">
                                    <input type="checkbox" onchange="changeCategoryPledge('{{$ob->id}}')" {{ $ob->pledge == 1 ? 'checked' : '' }} class="custom-control-input" id="customSwitchp{{$ob->id}}">
                                    <label class="custom-control-label" id="status_labelp{{$ob->id}}" for="customSwitchp{{$ob->id}}"></label>
                                </div>
                            </td>
                            <td>
                                <button class="btn btn-success mx-2"  onclick="edit({{$ob}})" data-toggle="modal" data-target="#editModel"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-danger" onclick="confirmDelete('{{route('admin.categories.destroy',$ob->id)}}')" data-toggle="modal" data-target="#delete-model">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    @if(count($categories) > 0)
                        <tr>
                            <td colspan="3">
                                <button class="btn btn-danger confirmDel" disabled onclick="deleteAllData('more','{{route('admin.categories.destroy',$ob->id)}}')" data-toggle="modal" data-target="#confirm-all-del">
                                    <i class="fas fa-trash"></i>
                                    حذف المحدد
                                </button>
                            </td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>
    </section>


 <!-- add model -->
 <div class="modal fade" id="addModel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">اضافة قسم</h4></div>
            <form action="{{route('admin.categories.store')}}" method="post" role="form" enctype="multipart/form-data">
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
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>الاسم بالعربي</label>
                                <input type="text" name="title_ar" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>الاسم بالانجليزي</label>
                                <input type="text" name="title_en" class="form-control">
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
<!-- end add model -->

<!-- edit model -->
<div class="modal fade" id="editModel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">تعديل القسم</h4></div>
            <form action=""  id="editForm" method="post" role="form" enctype="multipart/form-data">
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
                                <label>الاسم بالعربي</label>
                                <input type="text" name="title_ar" id="title_ar" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>الاسم بالانجليزي</label>
                                <input type="text" name="title_en" id="title_en" class="form-control">
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

        function edit(ob){
            $('#editForm')      .attr("action","{{route('admin.categories.update','obId')}}".replace('obId',ob.id));
            $('#title_ar')    .val(ob.title.ar);
            $('#title_en')     .val(ob.title.en);
            let image = $( '#upload_area_img' );
            image.empty();
            image.append( '<div class="uploaded-block" data-count-order="1"><img src="' + ob.icon + '"><button class="close">&times;</button></div>' );
        }
    </script>
@endpush

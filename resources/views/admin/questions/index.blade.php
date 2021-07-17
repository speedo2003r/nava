@extends('admin.layout.master')
@section('content')


    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 ">
                    <div class="page-header callout-primary d-flex justify-content-between">
                        <h2>أسئله وأجوبه</h2>
                        <button type="button" data-toggle="modal" data-target="#addModel" class="btn btn-primary btn-wide waves-effect waves-light">
                            <i class="fas fa-plus"></i> اضافة سؤال
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
                            <td>
                                <button class="btn btn-success mx-2"  onclick="edit({{$ob}})" data-toggle="modal" data-target="#editModel"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-danger" onclick="confirmDelete('{{route('admin.questions.destroy',$ob->id)}}')" data-toggle="modal" data-target="#delete-model">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    @if(count($questions) > 0)
                    <tr>
                        <td colspan="3">
                            <button class="btn btn-danger confirmDel" disabled onclick="deleteAllData('more','{{route('admin.questions.destroy',$ob->id)}}')" data-toggle="modal" data-target="#confirm-all-del">
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
            <div class="modal-header"><h4 class="modal-title">اضافة دوله</h4></div>
            <form action="{{route('admin.questions.store')}}" method="post" role="form" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="uuid" value="uuid">
                <div class="modal-body">
                    <div class="row">

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>سؤال عربي</label>
                                <input type="text" name="key_ar" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>سؤال انجليزي</label>
                                <input type="text" name="key_en" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>اجابه عربي</label>
                                <textarea name="value_ar" rows="7" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>اجابه انجليزي</label>
                                <textarea name="value_en" rows="7" class="form-control"></textarea>
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
            <div class="modal-header"><h4 class="modal-title">تعديل دوله</h4></div>
            <form action=""  id="editForm" method="post" role="form" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">


                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>سؤال عربي</label>
                                <input type="text" id="key_ar" name="key_ar" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>سؤال انجليزي</label>
                                <input type="text" id="key_en" name="key_en" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>اجابه عربي</label>
                                <textarea id="value_ar" rows="7" name="value_ar" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>اجابه انجليزي</label>
                                <textarea id="value_en" rows="7" name="value_en" class="form-control"></textarea>
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
            console.log(ob);
            $('#editForm')      .attr("action","{{route('admin.questions.update','obId')}}".replace('obId',ob.id));
            $('#key_ar')    .val(ob.key.ar);
            $('#key_en')    .val(ob.key.en);
            $('#value_ar')    .val(ob.value.ar);
            $('#value_en')    .val(ob.value.en);
        }
    </script>
@endpush

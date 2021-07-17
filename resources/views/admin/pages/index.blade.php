@extends('admin.layout.master')
@section('content')


    <section class="content">

        <div class="container-fluid">
            <div class="row">
                <div class="col-12 ">
                    <div class="page-header callout-primary d-flex justify-content-between">
                        <h2>الصفحات الاساسيه</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="card page-body">
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
                            <td>
                                <button class="btn btn-success mx-2"  onclick="edit({{$ob}})" data-toggle="modal" data-target="#editModel"><i class="fas fa-edit"></i></button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>


    <!-- end add model -->

    <!-- edit model -->
    <div class="modal fade" id="editModel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header"><h4 class="modal-title">تعديل الصفحه</h4></div>
                <form action=""  id="editForm" method="post" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>الاسم بالعربي</label>
                                    <input type="text" id="title_ar" name="title_ar" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>الاسم بالانجليزي</label>
                                    <input type="text" id="title_en" name="title_en" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>التفاصيل بالعربي</label>
                                    <textarea id="desc_ar" name="desc_ar" class="form-control" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>التفاصيل بالانجليزي</label>
                                    <textarea id="desc_en" name="desc_en" class="form-control" cols="30" rows="10"></textarea>
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
            $('#title_ar')    .val(ob.title.ar);
            $('#title_en')     .val(ob.title.en);
            $('#desc_ar')     .val(ob.desc.ar);
            $('#desc_en')     .val(ob.desc.en);
        }
    </script>
@endpush

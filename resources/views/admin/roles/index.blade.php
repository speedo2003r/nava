@extends('admin.layout.master')
@section('content')


    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 ">
                    <div class="page-header callout-primary d-flex justify-content-between">
                        <h2>{{__('roles')}}</h2>
                        <a href="{{route('admin.roles.create')}}" class="btn btn-primary btn-wide  waves-effect waves-light"><i class="fas fa-plus"></i> {{__('add_role')}}</a>
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
                    @foreach($roles as $ob)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$ob->name}}</td>
                            <td>
                                <a href="{{route('admin.roles.edit',$ob->id)}}" class="btn btn-success mx-2"><i class="fas fa-edit"></i></a>
                                <button class="btn btn-danger" onclick="confirmDelete('{{route('admin.roles.delete',$ob->id)}}')" data-toggle="modal" data-target="#delete-model">
                                    <i class="fas fa-trash-alt"></i>
                                </button>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    @if(count($roles) > 0)
                        <tr>
                            <td colspan="30">
                                <button class="btn btn-danger confirmDel" disabled onclick="deleteAllData('more','{{route('admin.roles.delete',$ob->id)}}')" data-toggle="modal" data-target="#confirm-all-del">
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
@endsection

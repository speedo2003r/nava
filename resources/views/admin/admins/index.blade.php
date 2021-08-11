@extends('admin.layout.master')
@section('title',awtTrans('المشرفين'))
@section('breadcrumb')
    <a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName()) }}" class="kt-subheader__breadcrumbs-link">
        {{ awtTrans('المشرفين') }}</a>
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
                                    {{awtTrans('المشرفين')}}
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__head-label mt-3">
                            <button type="button" data-toggle="modal" data-target="#editModel" class="btn btn-brand btn-elevate btn-icon-sm add-user">
                                <i class="la la-plus"></i>
                                {{awtTrans('اضافه')}}
                            </button>

                            <button class="btn btn-brand btn-elevate btn-icon-sm confirmDel" disabled onclick="deleteAllData('more','{{route('admin.admins.delete',0)}}')" data-toggle="modal" data-target="#confirm-all-del">
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
                        <th>{{__('email')}}</th>
                        <th>{{__('phone')}}</th>
                        <th>{{__('status')}}</th>
                        <th>{{__('control')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($admins as $ob)
                        <tr>
                            <td>
                                @if(\App\Models\User::where('user_type','admin')->first()['id'] != $ob['id'])
                                    <label class="custom-control material-checkbox" style="margin: auto">
                                        <input type="checkbox" class="material-control-input checkSingle" id="{{$ob->id}}">
                                        <span class="material-control-indicator"></span>
                                    </label>
                                @endif
                            </td>
                            <td>{{$ob->name}}</td>
                            <td>{{$ob->email}}</td>
                            <td>{{$ob->phone}}</td>
                            <td>
                                @if(\App\Models\User::where('user_type','admin')->first()['id'] != $ob['id'])
                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success" style="direction: ltr">
                                    <input type="checkbox" onchange="changeUserStatus('{{$ob->id}}')" {{ $ob->banned == 0 ? 'checked' : '' }} class="custom-control-input" id="customSwitch{{$ob->id}}">
                                    <label class="custom-control-label" id="status_label{{$ob->id}}" for="customSwitch{{$ob->id}}"></label>
                                </div>
                                @endif
                            </td>
                            <td class="tAction">
                                <button onclick="edit({{$ob}})" data-toggle="modal" data-target="#editModel" data-placement="top" data-original-title="{{awtTrans('تعديل')}}"  class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                    <i class="la la-cog"></i>
                                </button>
                                @if(\App\Models\User::where('user_type','admin')->first()['id'] != $ob['id'])
                                <button type="button"  onclick="confirmDelete('{{route('admin.admins.delete',$ob->id)}}')" data-toggle="modal" data-target="#delete-model" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="" data-placement="top" data-original-title="{{awtTrans('حذف')}}" style="cursor: pointer">
                                    <i    class="la la-trash"></i>
                                </button>
                                @endif
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
    </div>


<!-- end add model -->

<!-- edit model -->
<div class="modal fade" id="editModel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">{{__('edit_supervisors')}}</h4></div>
            <form action=""  id="editForm" method="post" role="form" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">

                        <div class = "col-sm-12 text-center">
                            <label class = "mb-0">{{__('avatar')}}</label>
                            <div class = "text-center">
                                <div class = "images-upload-block single-image">
                                    <label class = "upload-img">
                                        <input type = "file" name = "image" id = "image" accept = "image/*" class = "image-uploader">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                    </label>
                                    <div class = "upload-area" id="upload_area_img"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>{{__('name')}}</label>
                                <input type="text" name="name" id="name" class="form-control">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>{{__('phone')}}</label>
                                <input type="number" name="phone" class="form-control" id="phone" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>{{__('email')}}</label>
                                <input type="email" name="email" class="form-control" id="email" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>{{__('password')}}</label>
                                <input type="password" name="password" class="form-control" autocomplete="off">
                            </div>
                        </div>


                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>{{awtTrans('الاشراف الوظيفي')}}</label>
                                <select name="user_type" class="form-control" id="user_type" required>
                                    <option value="" selected hidden disabled>{{__('choose_role')}}</option>
                                    <option value="admin">{{awtTrans('مشرف عام')}}</option>
                                    <option value="operation">{{awtTrans('مشرف اداري')}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>{{__('role')}}</label>
                                <select name="role_id" class="form-control" id="role_id" required>
                                    <option value="" selected hidden disabled>{{__('choose_role')}}</option>
                                    @foreach($roles as $role)
                                        <option value="{{$role->id}}">{{$role->name_ar}}</option>
                                    @endforeach
                                </select>
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
            $('#editModel .modal-title').text('اضافة مشرف');
            $('[name=city_id]').empty();
            $('#editForm :input:not([type=hidden])').val('');
            $( '#upload_area_img' ).empty();
            $('#editForm')      .attr("action","{{route('admin.admins.store')}}");
        });
        $(document).on('change','#country_id',function (){
            var country = $(this).val();
            getCities(country);
        });
        function edit(ob){

            $('#editModel .modal-title').text('تعديل مشرف');
            $('#editForm')      .attr("action","{{route('admin.admins.update','obId')}}".replace('obId',ob.id));
            $('#name')     .val(ob.name);
            $('#phone')         .val(ob.phone);
            $('#email')         .val(ob.email);
            $('#role_id')         .val(ob.role_id).change;
            $('#user_type')         .val(ob.user_type).change;

            if ( ob.banned == 1 )
                $( "#banned" ).attr( 'checked', '' );
            else
                $( "#banned" ).removeAttr( 'checked', '' );

            $( '#role_id option' ).each( function () {
                if ( $( this ).val() == ob.role_id )
                    $( this ).attr( 'selected', '' )
            } );

            let image = $( '#upload_area_img' );
            image.empty();
            image.append( '<div class="uploaded-block" data-count-order="1"><a href="' + ob.avatar + '"  data-fancybox data-caption="' + ob.avatar + '" ><img src="' + ob.avatar + '"></a><button class="close">&times;</button></div>' );
        }
    </script>
@endpush

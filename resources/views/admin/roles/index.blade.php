@extends('admin.layout.master')
@section('title',awtTrans('قائمة الصلاحيات'))
@section('breadcrumb')
<a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName()) }}" class="kt-subheader__breadcrumbs-link">
    {{ awtTrans('قائمة الصلاحيات') }}</a>
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
                                    {{awtTrans('قائمة الصلاحيات')}}
                                </h3>
                            </div>
                        </div>

                        <div class="kt-portlet__head-label mt-3">
                            <a href="{{route('admin.roles.create')}}" class="btn btn-brand btn-elevate btn-icon-sm">
                                <i class="la la-plus"></i>
                                {{awtTrans('اضافه')}}
                            </a>

                            <button class="btn btn-brand btn-elevate btn-icon-sm confirmDel" disabled onclick="deleteAllData('more','{{route('admin.roles.delete',0)}}')" data-toggle="modal" data-target="#confirm-all-del">
                                <i class="la la-trash"></i>
                                {{awtTrans('حذف')}}
                            </button>
                        </div>


                        <div class="kt-portlet__body kt-portlet__body--fit  margin-15 ">
                            <!--begin: Datatable -->
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
                                    @foreach($roles as $ob)
                                        <tr>
                                            <td>
                                                <label class="custom-control material-checkbox" style="margin: auto">
                                                    <input type="checkbox" class="material-control-input checkSingle" id="{{$ob->id}}">
                                                    <span class="material-control-indicator"></span>
                                                </label>
                                            </td>
                                            <td>{{$ob->name}}</td>
                                            <td class="tAction">
                                                <a href="{{route('admin.roles.edit',$ob->id)}}" id="child" data-toggle="kt-tooltip" title="" data-placement="top" data-original-title="{{awtTrans('تعديل')}}"  class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                                    <i class="la la-cog"></i>
                                                </a>
                                                <button type="button"  onclick="confirmDelete('{{route('admin.roles.delete',$ob->id)}}')" data-toggle="modal" data-target="#delete-model" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="" data-placement="top" data-original-title="{{awtTrans('حذف')}}" style="cursor: pointer">
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
    <!-- end:: Footer -->
    <!-- end:: Page -->
@endsection

@extends('admin.layout.master')
@section('title',awtTrans('الفروع'))
@section('breadcrumb')
    <a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName()) }}" class="kt-subheader__breadcrumbs-link">
        {{ awtTrans('الفروع') }}</a>
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
                                    {{awtTrans('الفروع')}}
                                </h3>
                            </div>
                        </div>

                        <div class="kt-portlet__head-label mt-3">
                            <a href="{{route('admin.branches.create')}}" class="btn btn-brand btn-elevate btn-icon-sm">
                                <i class="la la-plus"></i>
                                {{awtTrans('اضافه')}}
                            </a>

                            <button class="btn btn-brand btn-elevate btn-icon-sm confirmDel" disabled onclick="deleteAllData('more','{{route('admin.cities.destroy',0)}}')" data-toggle="modal" data-target="#confirm-all-del">
                                <i class="la la-trash"></i>
                                {{awtTrans('حذف')}}
                            </button>
                        </div>


                        <div class="kt-portlet__body kt-portlet__body--fit  margin-15 ">
                            <!--begin: Datatable -->
                            <div class="table-responsive">
                                {!! $dataTable->table([
                                 'class' => "table table-striped table-bordered dt-responsive nowrap",
                                 'id' => "branchesdatatable-table",
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
@endsection
@push('js')
    {!! $dataTable->scripts() !!}
@endpush

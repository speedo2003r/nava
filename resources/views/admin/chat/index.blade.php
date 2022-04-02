@extends('admin.layout.master')
@section('title',awtTrans('سجل المحادثات'))
@section('breadcrumb')
    <a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName()) }}" class="kt-subheader__breadcrumbs-link">
        {{ awtTrans('سجل المحادثات') }}</a>
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
                                    {{awtTrans('سجل المحادثات')}}
                                </h3>
                            </div>
                        </div>



                        <div class="kt-portlet__body kt-portlet__body--fit  margin-15 ">
                            <!--begin: Datatable -->
                            <div class="table-responsive">
                                {!! $dataTable->table([
                                 'class' => "table table-striped table-bordered dt-responsive nowrap",
                                 'id' => "roomdatatable-table",
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

{{--    @push('css')--}}

{{--        <link href="{{ dashboard_url('css/font-awesome.min.css') }}" rel="stylesheet">--}}
{{--        <link href="{{ dashboard_url('css/AdminLTE.min.css') }}" rel="stylesheet">--}}
{{--        <style media="screen">--}}
{{--            .online{--}}
{{--                color: #32CD32;--}}
{{--            }--}}
{{--            #app .col-md-2 .panel-body{--}}
{{--                overflow-y: scroll;--}}
{{--                height: 400px;--}}
{{--            }--}}
{{--            .ffside {--}}
{{--                height: 100%;--}}
{{--                position: fixed;--}}
{{--                z-index: 1;--}}
{{--                top: 0;--}}
{{--                right: 0;--}}
{{--                width: 18em;--}}
{{--                overflow-x: hidden;--}}
{{--                padding-top: 50px;--}}
{{--            }--}}
{{--            .chat_box{--}}
{{--                width:260px;--}}
{{--                padding: 5px;--}}
{{--                position: fixed;--}}
{{--                bottom: 0px;--}}
{{--            }--}}
{{--            .pull-right{--}}
{{--                float:left !important;--}}
{{--            }--}}
{{--            .pull-left{--}}
{{--                float:right !important;--}}
{{--            }--}}
{{--        </style>--}}
{{--    @endpush--}}

{{--    <section class="content">--}}
{{--        <div class="container-fluid">--}}
{{--            <div class="row">--}}
{{--                <div class="col-12 ">--}}
{{--                    <div class="page-header callout-primary d-flex justify-content-between">--}}
{{--                        <h2>المحادثه</h2>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="card page-body" id="app">--}}
{{--            <public-component></public-component>--}}
{{--        </div>--}}
{{--    </section>--}}

{{--@push('js')--}}
{{--    <script src="{{ asset('js/app.js') }}" defer async></script>--}}
{{--@endpush--}}
{{--@endsection--}}

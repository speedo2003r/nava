@extends('admin.layout.master')
@section('title',awtTrans('المحادثه'))
@section('breadcrumb')
    <a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName()) }}" class="kt-subheader__breadcrumbs-link">
        {{ awtTrans('المحادثه') }}</a>
@endsection
@section('content')

    @push('css')

{{--        <link href="{{ dashboard_url('css/font-awesome.min.css') }}" rel="stylesheet">--}}
        <link href="{{ dashboard_url('css/AdminLTE.min.css') }}" rel="stylesheet">
        <style media="screen">
            .online{
                color: #32CD32;
            }
            #app .col-md-2 .panel-body{
                overflow-y: scroll;
                height: 400px;
            }
            .ffside {
                height: 100%;
                position: fixed;
                z-index: 1;
                top: 0;
                right: 0;
                width: 18em;
                overflow-x: hidden;
                padding-top: 50px;
            }
            .chat_box{
                width:260px;
                padding: 5px;
                position: fixed;
                bottom: 0px;
            }
            .pull-right{
                float:left !important;
            }
            .pull-left{
                float:right !important;
            }
        </style>
    @endpush

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 ">
                    <div class="page-header callout-primary d-flex justify-content-between">
                        <h2>المحادثه</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="card page-body" id="app">
            <public-component></public-component>
        </div>
    </section>

@push('js')
    <script src="{{ asset('js/app.js') }}" defer async></script>
@endpush
@endsection

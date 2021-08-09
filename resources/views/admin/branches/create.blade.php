@extends('admin.layout.master')
@section('title',awtTrans('اضافة فرع'))
@section('breadcrumb')
    <a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName()) }}" class="kt-subheader__breadcrumbs-link">
        {{ awtTrans('اضافة فرع') }}</a>
@endsection
@section('content')
@push('css')
    <link rel="stylesheet" href="{{asset('/css/admin.css')}}">
    <link rel="stylesheet" href="{{asset('/css/admin-rtl.css')}}">
    <style>
        .kt-aside-menu .kt-menu__nav>.kt-menu__item>.kt-menu__heading .kt-menu__link-text, .kt-aside-menu .kt-menu__nav>.kt-menu__item>.kt-menu__link .kt-menu__link-text {
            font-weight: 400 !important;
            font-size: 1rem !important;
            text-transform: initial !important;
        }
    </style>
@endpush
        <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <div class="row">
                <div class="col-md-12">
                    <!--begin::Portlet-->
                    @include('components.lang_taps')
                    <div class="kt-portlet" style="padding-top:15px">
                        <!--begin::Form-->
                        <form action="{{route('admin.branches.store')}}" method="post">
                            @csrf

                            <div class="form-group">
                                <div class="row" >
                                    <div class="col-md-4 col-lg-4 col-sm-12" >
                                        <div class="nav-tabs-custom nav-tabs-lang-inputs">
                                            <div class="tab-content">
                                                @foreach(\App\Entities\Lang::all() as $key => $locale)
                                                    <div class="tab-pane @if(\App\Entities\Lang::first() == $locale)  fade show active @endif" id="locale-tab-{{$locale['lang']}}">
                                                        <div class="form-group">
                                                            <label for="">{{awtTrans('الاسم')}}</label>
                                                            <input type="text" name="title_{{$locale['lang']}}" class="form-control" placeholder="{{__('enter')}} ..." required>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-4 col-sm-12" >
                                        <label for="">{{awtTrans('وقت الأستجابة')}}</label>
                                        <input type="number" name="assign_deadline" class="form-control" id="assign_deadline">
                                    </div>
                                    <div class="col-md-4 col-lg-4 col-sm-12" >
                                        <label for="">{{awtTrans('المدينه')}}</label>
                                        <select name="city_id" id="city_id" class="form-control">
                                            <option value="" selected hidden></option>
                                            @foreach($cities as $city)
                                                <option value="{{$city['id']}}">{{$city['title']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                        <div class="form-group region-dis" style="display: none">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>{{awtTrans('المناطق')}}</label>
                                    <div class="regions">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class='btn btn-primary' style='width:auto'>{{awtTrans('حفظ')}}</button>
                        </div>
                        </form>
                    <!--end::Form-->
                    </div>
                    <!--end::Portlet-->
                    <!--begin::Portlet-->
                </div>
            </div>
        </div>
        <!-- end:: Content -->
    </div>
@endsection
@push('js')
    <script>
        $(function (){
            'use strict'
           $('body').on('change','#city_id',function (){
               var city_id = $(this).val();
               getRegionsCheckBox(city_id);
           });
        });
    </script>
@endpush

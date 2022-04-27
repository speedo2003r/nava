@extends('admin.layout.master')
@section('title',awtTrans('الاشعارات'))
@section('breadcrumb')
    <a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName()) }}" class="kt-subheader__breadcrumbs-link">
        {{ awtTrans('الاشعارات') }}</a>
@endsection
@section('content')
@push('css')
    <style>
        .notify-list li{
            border: 1px solid #ccc;
            border-radius: 20px;
            padding: 20px;
            list-style: none;
            margin-bottom: 10px;
        }
    </style>

@endpush

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
                                    {{awtTrans('الاشعارات')}}
                                </h3>
                            </div>
                        </div>



                        <div class="kt-portlet__body kt-portlet__body--fit  margin-15 ">
                            @if(count($notifications) > 0)
                                <ul class="notify-list">
                                @foreach($notifications as $notification)
                                    <li class="position-relative">
                                        <a href="{{isset($notification->data['order_id']) ? route('admin.orders.show',$notification->data['order_id']) : '#'}}">
                                            <small>{{$notification->data['title'][app()->getLocale()] ?? ''}}</small>
                                            <p>{{$notification->data['body'][app()->getLocale()] ?? ''}}</p>
                                            <span style="position: absolute;bottom: 30px;left: 30px;">{{$notification->created_at->diffforhumans()}}</span>
                                        </a>
                                    </li>
                                @endforeach
                                </ul>
                            <div style="margin: 0 auto;">
                                {{$notifications->links()}}
                            </div>
                            @else
                                <h3 class="text-center">
                                    لا يوجد لديك اشعارات جديده
                                </h3>
                            @endif
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <!-- end:: Content -->
    </div>

@endsection

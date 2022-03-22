@extends('admin.layout.master')
@section('title',awtTrans('تقارير ماليه'))
@section('breadcrumb')
    <a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName()) }}" class="kt-subheader__breadcrumbs-link">
        {{ awtTrans('احصائيات الطلبات') }}</a>
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
                                    {{awtTrans('تقارير ماليه')}}
                                </h3>
                            </div>
                        </div>



                        <div class="kt-portlet__body kt-portlet__body--fit  margin-15 ">
                            <div class="row">
                                <div class="col-12 col-sm-6 col-md-4">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-tags"></i></span>

                                        <a href="{{route('admin.financial.orders',['type'=>'all'])}}" class="info-box-content">
                                            <span class="info-box-text">{{ awtTrans('اجمالي الطلبات') }}</span>
                                            <span class="info-box-number">
                                                {{ $allOrdersCount }}
                                                {{-- <small>%</small> --}}
                                            </span>
                                        </a>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                                <div class="col-12 col-sm-6 col-md-4">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-tags"></i></span>

                                        <a href="{{route('admin.financial.orders',['type'=>'new'])}}" class="info-box-content">
                                            <span class="info-box-text">{{ awtTrans('الطلبات الجديده') }}</span>
                                            <span class="info-box-number">
                                                {{ $newOrdersCount }}
                                                {{-- <small>%</small> --}}
                                            </span>
                                        </a>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                                <!-- /.col -->
                                <div class="col-12 col-sm-6 col-md-4">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-tags"></i></span>

                                        <a href="{{route('admin.financial.orders',['type'=>'progress'])}}" class="info-box-content">
                                            <span class="info-box-text">{{ awtTrans('الطلبات قيد التنفيذ') }}</span>
                                            <span class="info-box-number">
                                                {{ $InProgressOrdersCount }}
                                                {{-- <small>%</small> --}}
                                            </span>
                                        </a>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                                <!-- /.col -->
                                <div class="col-12 col-sm-6 col-md-4">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-tags"></i></span>

                                        <a href="{{route('admin.financial.orders',['type'=>'finish'])}}" class="info-box-content">
                                            <span class="info-box-text">{{ awtTrans('الطلبات المنتهيه') }}</span>
                                            <span class="info-box-number">
                                                {{ $FinishedOrdersCount }}
                                                {{-- <small>%</small> --}}
                                            </span>
                                        </a>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                                <!-- /.col -->
                                <div class="col-12 col-sm-6 col-md-4">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-tags"></i></span>

                                        <a href="{{route('admin.financial.orders',['type'=>'cash'])}}" class="info-box-content">
                                            <span class="info-box-text">{{ awtTrans('الطلبات المدفوعه كاش') }}</span>
                                            <span class="info-box-number">
                                                {{ $CashOrdersCount }}
                                                {{-- <small>%</small> --}}
                                            </span>
                                        </a>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                                <!-- /.col -->
                                <div class="col-12 col-sm-6 col-md-4">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-tags"></i></span>

                                        <a href="{{route('admin.financial.orders',['type'=>'online'])}}" class="info-box-content">
                                            <span class="info-box-text">{{ awtTrans('الطلبات المدفوعه أونلاين') }}</span>
                                            <span class="info-box-number">
                                                {{ $OnlineOrdersCount }}
                                                {{-- <small>%</small> --}}
                                            </span>
                                        </a>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>
                                <!-- /.col -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

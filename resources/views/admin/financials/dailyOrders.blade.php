@extends('admin.layout.master')
@section('title',awtTrans('الايرادات الماليه'))
@section('breadcrumb')
    <a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName()) }}" class="kt-subheader__breadcrumbs-link">
        {{ awtTrans('الايرادات الماليه') }}</a>
@endsection
@section('content')

    @push('css')

        <style>
            .week-swiper {
                display: flex;
                align-items: center;
                justify-content: space-around;
                margin: 45px 0 20px;
            }

            .week-swiper span {
                font-size: 20px;
                font-weight: bold;
                color: rgb(150, 14, 143);
            }

            .week-swiper a {
                font-size: 17px;
                color: #333;
                font-weight: bold;
            }

            .week-swiper.orders {
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }

            .week-swiper.orders p {
                color: #333;
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
                                    {{awtTrans('الايرادات الماليه')}}
                                </h3>
                            </div>
                        </div>



                        <div class="kt-portlet__body kt-portlet__body--fit  margin-15 ">
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="week-swiper text-center">
                                        <a href="{{url('/financial/dailyOrders?from='.$arr['end'])}}">
                                            &lt;
                                        </a>
                                        <span>
                                            {{$now->format('Y-m')}}
                                        </span>
                                        <a href="{{url('/financial/dailyOrders?from='.$arr['start'])}}">
                                            &gt;
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <h5>الايرادات اليوميه</h5>
                                    <div class="card">
                                        <div id='ActiveUsers'></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script>
        var days = {!! json_encode($days) !!};
        var orders = {!! json_encode($orders) !!};

        Highcharts.chart('ActiveUsers', {
            chart: {
                type: 'areaspline'
            },
            title: {
                text: `{{awtTrans('الأيام')}}`
            },
            xAxis: {
                categories: days,
                tickmarkPlacement: 'on',
                title: {
                    enabled: false
                }
            },
            yAxis: {
                title: {
                    text: 'العدد'
                },
                labels: {
                    formatter: function () {
                        return this.value;
                    }
                }
            },
            tooltip: {
                split: true,
                valueSuffix: ''
            },
            plotOptions: {
                area: {
                    stacking: 'normal',
                    lineColor: '#666666',
                    lineWidth: 1,
                    marker: {
                        lineWidth: 1,
                        lineColor: '#666666'
                    }
                }
            },
            series: [{
                name: `{{awtTrans('احصائيات الايردات اليوميه')}}`,
                data: orders
            }]
        });


    </script>
@endpush

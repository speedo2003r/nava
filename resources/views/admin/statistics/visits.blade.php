@extends('admin.layout.master')

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
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">

                <div class="col-md-12">
                    <div class="week-swiper text-center">
                        <a href="{{url('/statistics/visits?from='.$arr['end'])}}">
                            &lt;
                        </a>
                        <span>
                        {{$now->format('Y-m')}}
                    </span>
                        <a href="{{url('/statistics/visits?from='.$arr['start'])}}">
                            &gt;
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <h5>الزيارات من خلال ios</h5>
                    <div class="card">
                        <div id='ActiveUsers'></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h5>الزيارات من خلال android</h5>
                    <div class="card">
                        <div id='ActiveUsers2'></div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    @push('js')

        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script>
                    {{--var days = {!! json_encode($days) !!};--}}
                    {{--var visitors = {!! json_encode($visitors) !!};--}}
                    {{--var pageViews = {!! json_encode($pageViews) !!};--}}
            var days = {!! json_encode($days) !!};
            var ios = {!! json_encode($ios) !!};

            Highcharts.chart('ActiveUsers', {
                chart: {
                    type: 'areaspline'
                },
                title: {
                    text: 'الأيام'
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
                    name: 'عدد الزيارات من تطبيق ios',
                    data: ios
                }]
            });

            var android = {!! json_encode($android) !!};

            Highcharts.chart('ActiveUsers2', {
                chart: {
                    type: 'areaspline'
                },
                title: {
                    text: 'الأيام'
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
                    name: 'عدد الزيارات من تطبيق android',
                    data: android
                }]
            });

        </script>
    @endpush
@endsection

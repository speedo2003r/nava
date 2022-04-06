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
    <section class="content">
        <div class="card page-body">
            <div class="row">
{{--                @if(auth()->user()['role_id'] == 1)--}}
{{--                <div class="col-md-3"></div>--}}
{{--                <div class="col-md-6">--}}
{{--                    <form action="{{url('/admin/statistics/almostorder')}}" method="get">--}}
{{--                        <label for="" class="label-control">الدول</label>--}}
{{--                        <select name="country_id" class="form-control">--}}
{{--                            <option value="">اختر</option>--}}
{{--                            @foreach($countries as $country)--}}
{{--                                <option value="{{$country['id']}}" @if($countryquery == @$country['id']) selected @endif>{{$country->title}}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                        <button type="submit" class="btn btn-primary mt-2">اختيار</button>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--                @endif--}}
                @if($countryquery != null)
                    <div class="col-md-12">
                        <div class="week-swiper text-center">
                            <a href="{{url('/statistics/almostorder?from='.$arr['end'].'&country_id='.$countryquery)}}">
                                &lt;
                            </a>
                            <span>
                        {{$now->format('Y-m')}}
                    </span>
                            <a href="{{url('/statistics/almostorder?from='.$arr['start'].'&country_id='.$countryquery)}}">
                                &gt;
                            </a>
                        </div>
                    </div>

                    @else
                <div class="col-md-12">
                    <div class="week-swiper text-center">
                        <a href="{{url('/statistics/almostorder?from='.$arr['end'])}}">
                            &lt;
                        </a>
                        <span>
                        {{$now->format('Y-m')}}
                    </span>
                        <a href="{{url('/statistics/almostorder?from='.$arr['start'])}}">
                            &gt;
                        </a>
                    </div>
                </div>
                @endif
                <div class="col-md-6">

                    <div class="card">
                        <div id='ActiveUsers'></div>
                    </div>
                </div>
                <div class="col-md-6">

                    <div class="card">
                        <div id='ActiveUsers2'></div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="datatable-table" class="table table-striped table-bordered dt-responsive nowrap">
                                <thead>
                                <tr>
                                    <th>عدد الطلبات</th>
                                    <th>الصوره</th>
                                    <th> الاسم</th>
                                    <th> البريد الالكتروني</th>
                                    <th>رقم الجوال</th>
                                    <th>الحاله</th>
                                    <th> تاريخ التسجيل</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($users as $key => $u)
                                    @if($u['count'] > 0)
                                        <tr>
                                            <td data-order="asc">
                                                {{$u->count}}
                                            </td>
                                            <td><img src="{{$u->avatar}}" style="height: 120px;width: 120px;" class="img-circle"></td>
                                            <td>{{$u->name}}</td>
                                            <td>{{$u->email}}</td>
                                            <td>{{$u->phone}}</td>
                                            <td>
                                                <label class="label label-{{$u['banned'] == 1 ? 'warning' : 'success'}}">{{$u->banned == 1 ? 'حظر' : ' نشط'}}</label>
                                            </td>
                                            <td>{{$u->created_at->diffForHumans()}}</td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>


                            </table>
                        </div>
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
            var orders = {!! json_encode($almostorders) !!};

            Highcharts.chart('ActiveUsers', {
                chart: {
                    type: 'areaspline'
                },
                title: {
                    text: 'الأيام الأكثر طلبا'
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
                    name: 'طلبات',
                    data: orders
                }]
            });
            var times = {!! json_encode($times) !!};
            var almosttimeorders = {!! json_encode($almosttimeorders) !!};

            Highcharts.chart('ActiveUsers2', {
                chart: {
                    type: 'areaspline'
                },
                title: {
                    text: 'الساعات الأكثر طلبا'
                },
                xAxis: {
                    categories: times,
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
                    name: 'طلبات',
                    data: almosttimeorders
                }]
            });
        </script>

    @endpush
@endsection

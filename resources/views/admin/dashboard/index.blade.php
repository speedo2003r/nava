@extends('admin.layout.master')

@push('css')
    <link href="{{asset('assets/vendors/general/owl.carousel/dist/assets/owl.carousel.css')}}"  rel="stylesheet" type="text/css" />
    <style>
        .kt-portlet{
            padding:0;
        }
        .general-info .user-data{
            margin-bottom:1rem;
        }
        .general-info
        {
            color:#595d6e
        }
    </style>
@endpush

@section('content')

    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <!--Begin::Dashboard 1-->
            <!--Begin::Row-->
            <!--Start The New Content  -->
            <div class="row">

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{ awtTrans('الأعضاء') }}</span>
                            <span class="info-box-number">
                              {{ $countClients }}
                                                {{-- <small>%</small> --}}
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{ awtTrans('المديرين') }}</span>
                            <span class="info-box-number">{{ $countAdmins }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-database"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{ awtTrans('الأقسام') }}</span>
                            <span class="info-box-number">{{$countCategories}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-globe"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{ awtTrans('الدول') }}</span>
                            <span class="info-box-number">{{$countCountries}}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-lg-12">
                    <div class="kt-portlet kt-portlet--height-fluid">
                        <div class="kt-portlet__head">
                            <div class="kt-portlet__head-label">
                                <div class="form-group form-inline py-2 my-0">
                                    <h3 class="kt-portlet__head-title">
                                        {{awtTrans('احضائيات الطلبات')}}
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <canvas id="myChart" style="background: #fff"></canvas>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <!-- End  The New Content  -->




            <!--End::Row-->
            <!--End::Dashboard 1-->
        </div>
        <!-- end:: Content -->
    </div>
@endsection

@push('js')
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');

            var arr = [];
            @foreach($data['selleds'] as $selleds)
            arr.push({{$selleds}});
            @endforeach
            var ctx = document.getElementById('myChart').getContext('2d');

            var chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'line',

            // The data for our dataset
            data: {
            labels: [`{{awtTrans('January')}}`, `{{awtTrans('February')}}`, `{{awtTrans('March')}}`,`{{awtTrans('April')}}` , `{{awtTrans('May')}}`, `{{awtTrans('June')}}`, `{{awtTrans('July')}}`,`{{awtTrans('august')}}` ,`{{awtTrans('Septemper')}}` ,`{{awtTrans('October')}}`,`{{awtTrans('Novmber')}}` ,`{{awtTrans('December')}}`],
            datasets: [{
            label: "إحصائيات الطلبات",
            backgroundColor: 'rgba(0,0,0,0)',
            borderWidth: 3,
            hoverBackgroundColor: "rgba(1,152,117,0.2)",
            hoverBorderColor: "rgba(182,28,28,1)",
            scaleStepWidth: 5,
            borderColor: 'rgba(182,28,28,1)',
            data: arr
        }]
        },

            // Configuration options go here
            options: {}
        });
    </script>
@endpush

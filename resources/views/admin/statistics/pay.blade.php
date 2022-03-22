@extends('admin.layout.master')

@section('content')

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <h2>الدفع</h2>
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-dollar-sign"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">كاش</span>
                                    <span class="info-box-number">
                                {{$cod}}
                            </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-credit-card"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">شبكه</span>
                                    <span class="info-box-number">
                                {{$online}}
                            </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-credit-card"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">أبل باي</span>
                                    <span class="info-box-number">
                                {{$apple}}
                            </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

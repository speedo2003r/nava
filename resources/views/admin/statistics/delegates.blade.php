@extends('admin.layout.master')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                @if(auth()->user()['role_id'] == 1)
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <form action="{{url('/admin/statistics/delegates')}}" method="get">
                            <label for="" class="label-control">الدول</label>
                            <select name="country_id" class="form-control">
                                <option value="">اختر</option>
                                @foreach($countries as $country)
                                    <option value="{{$country['id']}}" @if($countryquery == @$country['id']) selected @endif>{{$country->title}}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary mt-2">اختيار</button>
                        </form>
                    </div>
                @endif
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">عدد المندوبين</span>
                                    <span class="info-box-number">
                                {{$delegates}}
                            </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">عدد المندوبين النشطين</span>
                                    <span class="info-box-number">
                                        {{$activedelegate}}
                            </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">عدد المندوبين الغير نشطين</span>
                                    <span class="info-box-number">
                                        {{$deactivedelegate}}
                            </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">عدد المندوبين الأكثر قبولا للطلبات</span>
                                    <span class="info-box-number">
                                        {{$accepteddelegate}}
                            </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                        </div>
                    </div>
                    <!-- /.info-box -->
                </div>
            </div>
        </div>
    </section>
@endsection

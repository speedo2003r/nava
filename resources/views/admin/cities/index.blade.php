@extends('admin.layout.master')
@section('content')


    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 ">
                    <div class="page-header callout-primary d-flex justify-content-between">
                        <h2>المدن</h2>
                        <button type="button" data-toggle="modal" data-target="#editModel" class="btn btn-primary btn-wide waves-effect waves-light add-user">
                            <i class="fas fa-plus"></i> اضافة مدينه
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card page-body">
            <div class="table-responsive">
                <table id="datatable-table" class="table table-striped table-bordered dt-responsive nowrap"  style="width:100%">
                    <thead>
                    <tr>
                        <th>
                            <label class="custom-control material-checkbox" style="margin: auto">
                                <input type="checkbox" class="material-control-input" id="checkedAll">
                                <span class="material-control-indicator"></span>
                            </label>
                        </th>
                        <th>{{__('name')}}</th>
                        <th>الدوله</th>
                        <th>أسعار الشحن</th>
                        <th>{{__('control')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cities as $ob)
                        <tr>
                            <td>
                                <label class="custom-control material-checkbox" style="margin: auto">
                                    <input type="checkbox" class="material-control-input checkSingle" id="{{$ob->id}}">
                                    <span class="material-control-indicator"></span>
                                </label>
                            </td>
                            <td>{{$ob->title}}</td>
                            <td>{{$ob->country->title}}</td>
                            <td><a href="{{route('admin.citiesShip.index',$ob['id'])}}" class="btn btn-success">أسعار الشحن</a></td>
                            <td>
                                <button class="btn btn-success mx-2"  onclick="edit({{$ob}})" data-toggle="modal" data-target="#editModel"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-danger" onclick="confirmDelete('{{route('admin.cities.destroy',$ob->id)}}')" data-toggle="modal" data-target="#delete-model">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    @if(count($cities) > 0)
                        <tr>
                            <td colspan="30">
                                <button class="btn btn-danger confirmDel" disabled onclick="deleteAllData('more','{{route('admin.cities.destroy',$ob->id)}}')" data-toggle="modal" data-target="#confirm-all-del">
                                    <i class="fas fa-trash"></i>
                                    حذف المحدد
                                </button>
                            </td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>
    </section>


    <!-- edit model -->
    <div class="modal fade" id="editModel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header"><h4 class="modal-title">تعديل المدينه</h4></div>
                <form action=""  id="editForm" method="post" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>الاسم بالعربي</label>
                                    <input type="text" name="title_ar" id="title_ar" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>الاسم بالانجليزي</label>
                                    <input type="text" name="title_en" id="title_en" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>الدول</label>
                                    <select name="country_id" id="country_id" class="form-control">
                                        <option value="">اختر</option>
                                        @foreach($countries as $country)
                                            <option value="{{$country['id']}}">{{$country->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 mb-3">
                                <div class="form-group">
                                    <label>المدينه من الخريطه</label>
                                    <input type="hidden" name="lat" id="lat">
                                    <input type="hidden" name="lng" id="lng">
                                    <input type="text" name="city_name" readonly id="city_name" class="form-control" value="" placeholder="Enter a query" autocomplete="off">
                                    <div id="map" style="height: 300px"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-primary">{{__('save')}}</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{__('close')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end edit model -->

@endsection
@push('js')
    <script src="{{dashboard_url('dashboard/js/map.js')}}"></script>
    <script
            src="https://maps.googleapis.com/maps/api/js?key={{settings('map_key')}}&libraries=places&callback=initMap&region=SA&language=en"
            async defer></script>
    <script>
        $('.add-user').on('click',function () {
            $('#addModel .modal-title').text('اضافة مدينه');
            $('#editForm :input:not([type=checkbox],[type=radio],[type=hidden])').val('');
            $('#editForm')      .attr("action","{{route('admin.cities.store')}}");
        });

        function edit(ob){
            $('#addModel .modal-title').text('تعديل مدينه');
            $('#editForm')      .attr("action","{{route('admin.cities.update','obId')}}".replace('obId',ob.id));
            $('#title_ar')    .val(ob.title.ar);
            $('#title_en')     .val(ob.title.en);
            $('#country_id')     .val(ob.country_id).change;
            $('#lat')     .val(ob.lat);
            $('#lng')     .val(ob.lng);
            $('#city_name')     .val(ob.city_name);
            initMap();
        }
    </script>
@endpush

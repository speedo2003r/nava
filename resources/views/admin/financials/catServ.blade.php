@extends('admin.layout.master')
@section('title',awtTrans('تقارير الأقسام والخدمات'))
@section('breadcrumb')
    <a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName()) }}" class="kt-subheader__breadcrumbs-link">
        {{ awtTrans('تقارير الأقسام والخدمات') }}</a>
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
                                    {{awtTrans('الطلبات')}}
                                </h3>
                            </div>
                        </div>
                        <form action="{{route('admin.financial.catServ')}}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">{{awtTrans('التاريخ من')}}</label>
                                        <input type="date" value="{{$from}}" name="from" class="form-control from">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">{{awtTrans('التاريخ الي')}}</label>
                                        <input type="date" value="{{$to}}" name="to" class="form-control from">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">{{awtTrans('الاقسام')}}</label>
                                        <select name="category_id" id="category_id" class="form-control">
                                            <option value="" selected>{{awtTrans('الكل')}}</option>
                                            @foreach($categories as $category)
                                                <option value="{{$category['id']}}" @if($category_id == $category['id']) selected @endif>{{$category['title']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">{{awtTrans('الاقسام الفرعيه')}}</label>
                                        <select name="subcategory_id" id="subcategory_id" class="form-control">
                                            <option value="" selected>{{awtTrans('الكل')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">{{awtTrans('الخدمات')}}</label>
                                        <select name="service_id" class="form-control">
                                            <option value="" selected>{{awtTrans('الكل')}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary">{{awtTrans('ارسال')}}</button>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-12 col-sm-6 col-md-4">
                                <div class="info-box">
                                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-tags"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">{{ awtTrans('اجمالي الايرادات') }}</span>
                                        <span class="info-box-number">
                                            {{$income->total ?? 0}}
                                            {{-- <small>%</small> --}}
                                            </span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                            </div>
                        </div>


                        <div class="kt-portlet__body kt-portlet__body--fit  margin-15 ">
                            <div class="table-responsive">
                                {!! $dataTable->table([
                                 'class' => "table table-striped table-bordered dt-responsive",
                                 'id' => "orderdatatable-table",
                                 ],true) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <!-- end:: Content -->
    </div>

@endsection
@push('js')
    {!! $dataTable->scripts() !!}
    <script>
        @if($category_id != null)
            getServices(`{{$category_id}}`);
        @endif
        @if($subcategory_id != null)
            getCategories(`{{$category_id}}`,`{{$subcategory_id}}`);
        @endif
        @if($service_id != null)
            getServices(`{{$subcategory_id}}`,`{{$service_id}}`);
        @endif
        $('body').on('change','#category_id',function (){
            var category_id = $(this).val();
            getCategories(category_id);
        });
        $('body').on('change','#subcategory_id',function (){
            var category_id = $(this).val();
            getServices(category_id);
        });
        function getServices(category_id,type = '',placeholder = 'الكل'){
            var html = '';
            var service_id = '';
            $('[name=service_id]').empty();
            if(category_id){
                $.ajax({
                    url: `{{route('admin.ajax.getservices')}}`,
                    type: 'post',
                    dataType: 'json',
                    data:{category_id: category_id},
                    success: function (res) {
                        if(type != ''){
                            service_id = type;
                        }
                        html += `<option value="" hidden selected>${placeholder}</option>`;
                        $.each(res.data,function (index,value) {
                            html += `<option value="${value.id}" ${service_id == value.id ? 'selected':'' }>${value.title.ar}</option>`;
                        });
                        $('[name=service_id]').append(html);
                    }
                });
            }
        }
        function getCategories(category_id,type = '',placeholder = 'الكل'){
            var html = '';
            var subcategory_id = '';
            $('[name=subcategory_id]').empty();
            if(category_id){
                $.ajax({
                    url: `{{route('admin.ajax.getCategories')}}`,
                    type: 'post',
                    dataType: 'json',
                    data:{category: category_id},
                    success: function (res) {
                        if(type != ''){
                            subcategory_id = type;
                        }
                        html += `<option value="" hidden selected>${placeholder}</option>`;
                        $.each(res.data,function (index,value) {
                            html += `<option value="${value.id}" ${subcategory_id == value.id ? 'selected':'' }>${value.title.ar}</option>`;
                        });
                        $('[name=subcategory_id]').append(html);
                    }
                });
            }
        }
    </script>
@endpush

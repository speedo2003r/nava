@extends('admin.layout.master')
@section('title',awtTrans('الطلبات'))
@section('breadcrumb')
    <a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName(),$id) }}" class="kt-subheader__breadcrumbs-link">
        {{ awtTrans('الطلبات') }}</a>
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
                                        ({{$orderCount}})
                                </h3>

                            </div>
                            <select style="width: 200px;margin: 10px" name="orderStatus" class="form-control" id="orderStatus">
                                <option value="" @if(request('status') == null || !request()->has('status')) selected @endif>أختر</option>
                                <option value="{{\App\Enum\OrderStatus::PENDING}}" @if(request('status') == \App\Enum\OrderStatus::PENDING) selected @endif>طلبات جاري تنفيذها</option>
                                <option value="{{\App\Enum\OrderStatus::DAILY}}" @if(request('status') == \App\Enum\OrderStatus::DAILY) selected @endif>الطلبات اليوميه</option>
                                <option value="{{\App\Enum\OrderStatus::FINISHED}}" @if(request('status') == \App\Enum\OrderStatus::FINISHED) selected @endif>الطلبات المنتهيه</option>
                            </select>
                        </div>



                        <div class="kt-portlet__body kt-portlet__body--fit  margin-15 ">
                            <div class="table-responsive">
                                {!! $dataTable->table([
                                 'class' => "table table-striped table-bordered dt-responsive nowrap",
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
        $('body').on('change','#orderStatus',function (){
            var route = $(this).val();
            location.replace(`{{route(\Illuminate\Support\Facades\Route::currentRouteName(),['id'=>$id,'status' => 'obId'])}}`.replace('obId',`${route}`))
        });
    </script>
@endpush

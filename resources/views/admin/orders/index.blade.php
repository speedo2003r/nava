@extends('admin.layout.master')
@section('title',awtTrans('الطلبات'))
@section('breadcrumb')
    <a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName()) }}" class="kt-subheader__breadcrumbs-link">
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
                                </h3>
                            </div>
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

    <!-- send-noti modal-->
    <div class="modal fade" id="assign-tech"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{awtTrans('تعيين تقني')}}</h5>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.orders.assignTech')}}" method="POST">
                        @csrf
                        <input type="hidden" name="order_id" id="order_id">
                        <div class="form-group">
                            <label for="">
                                {{awtTrans('التقني')}}
                            </label>
                            <select name="technician_id" class="form-control" id="technician_id">
                                <option value="" selected hidden>اختر</option>
                            </select>
                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="submit" class="btn btn-sm btn-success">{{awtTrans('إرسال')}}</button>
                            <button type="button" class="btn btn-default" id="notifyClose" data-dismiss="modal">{{awtTrans('اغلاق')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-danger" id="deleteModal-reject" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header"><h4 class="modal-title">رفض الطلب</h4></div>

                <form action="{{route('admin.orders.rejectOrder')}}" method="post">
                    @csrf()
                    <input type="hidden" name="order_id" id="reject_id">
                    <div class="modal-body">
                        <p>هل أنت متأكد من عملية الرفض ؟</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-primary">نعم</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{__('close')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-- end edit model -->

@endsection
@push('js')
    {!! $dataTable->scripts() !!}
    <script>
        $(document).on('click','.child',function (){
            var order = $(this).data('id');
            $('#technician_id').empty();
            $('#order_id').val(order);
            getTechs(order);
        });
        $(document).on('click','.reject',function (){
            var order = $(this).data('id');
            $('#reject_id').val(order);
        });
    </script>
@endpush

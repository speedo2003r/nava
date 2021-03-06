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
                                    @if(Route::currentRouteName() == 'admin.orders.index')
                                        ({{\App\Entities\Order::where('status','created')->where('live',1)->count()}})
                                    @elseif(Route::currentRouteName() == 'admin.orders.onWayOrders')
                                        ({{\App\Entities\Order::whereNotIn('status',['created','finished'])->where('technician_id','!=',null)->whereHas('category')->where('live',1)->count()}})
                                    @elseif(Route::currentRouteName() == 'admin.orders.finishedOrders')
                                        ({{\App\Entities\Order::where('status','finished')->where('technician_id','!=',null)->whereHas('category')->where('live',1)->count()}})
                                    @endif
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

    <!-- send-noti modal-->
    <div class="modal fade" id="deductions"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{awtTrans('خصم')}}</h5>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.technicians.decreaseVal')}}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="dis_user_id">
                        <input type="hidden" name="order_id" id="dis_order_id">
                        <div class="form-group">
                            <label for="">
                                {{awtTrans('القيمه')}}
                            </label>
                            <input type="number" min="0" value="0" name="deduction" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">
                                {{awtTrans('السبب')}}
                            </label>
                            <textarea name="notes" rows="5" class="form-control"></textarea>
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
    <!--end send-noti modal-->

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

    <!-- send-noti modal-->
    <div class="modal fade" id="send-noti"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{awtTrans('إرسال أشعار')}}</h5>
                </div>
                <div class="modal-body">
                    <form action="" id="sendnotifyuserForm" method="POST">
                        @csrf
                        <input type="hidden" name="type" id="notify_type" value="client">
                        <input type="hidden" name="id" id="notify_id">
                        <div class="form-group">
                            <label for="">
                                {{awtTrans('الرسالة')}}
                            </label>
                            <textarea name="message" id="notifyMessage" cols="30" rows="4" class="form-control"
                                      placeholder="{{awtTrans('اكتب رسالتك')}} ..."></textarea>
                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="submit" class="btn btn-sm btn-success save" onclick="sendnotifyuser()">إرسال</button>
                            <button type="button" class="btn btn-default" id="notifyClose" data-dismiss="modal">اغلاق</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    {!! $dataTable->scripts() !!}
    <script>
        $(document).on('click','.checkTech',function (){
            var order = $(this).data('id');
            var category_id = $(this).data('category');
            $('#technician_id').empty();
            $('#order_id').val(order);
            getTechs(order,category_id);
        });
        $(document).on('click','.reject',function (){
            var order = $(this).data('id');
            $('#reject_id').val(order);
        });
        $(document).on('click','.add-deduction',function (){
            var order = $(this).data('order_id');
            var total = $(this).data('total');
            var user = $(this).data('user_id');
            $('#dis_user_id').val(user);
            $('#dis_order_id').val(order);
            $('[name=deduction]').attr('min',total)
            $('[name=deduction]').attr('value',total)
        });
    </script>
@endpush

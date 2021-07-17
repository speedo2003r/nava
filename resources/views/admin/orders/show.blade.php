@extends('admin.layout.master')
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Timelime example  -->
            <div class="row">
                <div class="col-md-12">
                    <!-- The time line -->
                    <div class="timeline">
                        <!-- timeline item -->
                        <div>
                            <i class="fas fa-info bg-blue"></i>
                            <div class="timeline-item">
                                <h3 class="timeline-header">تفاصيل الطلب</h3>

                                <div class="timeline-body">
                                    <div class="bill-info">
                                        <ul>
                                            <li class="text-bold">
                                                <span>رقم الطلب</span>
                                                <span>:</span>
                                                <span>{{$order->id}}</span>
                                            </li>
                                            <li class="text-bold">
                                                <span>حالة الطلب</span>
                                                <span>:</span>
                                                <span>{{$order->status}}</span>
                                            </li>
                                            <li>
                                                <span>أسم العميل</span>
                                                <span>:</span>
                                                <span>{{!is_null($order->user) ? $order->user->name : $order->user_name}}</span>
                                            </li>
                                            <li>
                                                <span>جوال العميل</span>
                                                <span>:</span>
                                                <span>{{!is_null($order->user) ? $order->user->phone : $order->user_phone}}</span>
                                            </li>
                                            @if(!is_null($order->date))
                                                <li>
                                                    <span>تاريخ الطلب</span>
                                                    <span>:</span>
                                                    <span>{{date('Y-m-d' , strtotime($order->date))}}</span>
                                                </li>
                                            @endif
                                            <li>
                                                <span>العنوان</span>
                                                <span>:</span>
                                                <span>{{$order['address']}}</span>
                                            </li>
                                            @if(!is_null($order->time))
                                                <li>
                                                    <span>وقت الطلب</span>
                                                    <span>:</span>
                                                    <span>{{$order->time}}</span>
                                                </li>
                                            @endif
                                            <li class="text-bold">
                                                <span>طريقة الدفع</span>
                                                <span>:</span>
                                                <span>@if($order->payment_method == 'transfer') تحويل بنكي @elseif($order->payment_method == 'online') اون لاين @else كاش @endif</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END timeline item -->
                        <!-- timeline item -->
                        <div>
                            <i class="fas fa-list bg-yellow"></i>
                            <div class="timeline-item">
                                <h3 class="timeline-header">الطلبات</h3>
                                <div class="timeline-body">
                                    حط التفاصيل هنا
                                </div>
                            </div>
                        </div>
                        <!-- END timeline item -->
                    </div>
                </div>
                <!-- /.col -->
            </div>
        </div>
        <!-- /.timeline -->

    </section>
    <!-- /.content -->
@endsection

    <!-- confirm-del modal-->
    <div class="modal fade" id="notes-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ملاحظات</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3 class="text-center" id="notes">

                    </h3>
                </div>
            </div>
        </div>
    </div>
    <!--end confirm-del modal-->

@push('js')
    <script>
        function showNotes(notes) {
            if(notes == '') notes = 'لا يوجد ملاحظات';
            $('#notes').html(notes);
        }
    </script>
@endpush


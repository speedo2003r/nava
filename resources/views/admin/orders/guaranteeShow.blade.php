@extends('admin.layout.master')
@section('title',awtTrans('مشاهدة الطلب'))
@section('breadcrumb')
    <a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName(),$id) }}" class="kt-subheader__breadcrumbs-link">
        {{ awtTrans('مشاهدة الطلب') }}</a>
@endsection
@section('content')
    <!-- Main content -->
    @push('css')
        <style>
            .image.item{
                display: inline-block;
            }
        </style>

    @endpush
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
                                                    <span>{{$order->order_num}}</span>
                                                </li>
                                                <li class="text-bold">
                                                    <span>حالة الطلب</span>
                                                    <span>:</span>
                                                    <span>{{\App\Entities\Order::userStatus($order->status)}}</span>
                                                </li>
                                                <li class="text-bold">
                                                    <span>تاريخ ووقت الطلب</span>
                                                    <span>:</span>
                                                    <span>{{date('Y-m-d h:i a',strtotime($order->created_date))}}</span>
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
                                                        <span>تاريخ تنفيذ الطلب</span>
                                                        <span>:</span>
                                                        <span>{{date('Y-m-d' , strtotime($order->date))}}</span>
                                                    </li>
                                                @endif
                                                @if(!is_null($order->time))
                                                    <li>
                                                        <span>وقت تنفيذ الطلب</span>
                                                        <span>:</span>
                                                        <span>{{date('h:i a',strtotime($order->time))}}</span>
                                                    </li>
                                                @endif
                                                <li>
                                                    <span>الفني</span>
                                                    <span>:</span>
                                                    <span>{{$order->technician ? $order->technician['name'] : '---'}}</span>
                                                </li>
                                                <li>
                                                    <span>العنوان</span>
                                                    <span>:</span>
                                                    <span>{{$order['map_desc']}}</span>
                                                </li>
                                                <li>
                                                    <span>المنزل</span>
                                                    <span>:</span>
                                                    <span>{{$order['residence']}}</span>
                                                </li>
                                                <li>
                                                    <span>الشارع</span>
                                                    <span>:</span>
                                                    <span>{{$order['street']}}</span>
                                                </li>
                                                <li>
                                                    <span>الدور</span>
                                                    <span>:</span>
                                                    <span>{{$order['floor']}}</span>
                                                </li>
                                                <li>
                                                    <span>ملاحظات العنوان</span>
                                                    <span>:</span>
                                                    <span>{{$order['address_notes']}}</span>
                                                </li>
                                                <li class="text-bold">
                                                    <span>طريقة الدفع</span>
                                                    <span>:</span>
                                                    <span>{{\App\Entities\Order::orderMethods($order['pay_type'])}}</span>
                                                </li>
                                                <li class="text-bold">
                                                    <span>بداية الضمان</span>
                                                    <span>:</span>
                                                    <span>{{$orderGuarantee->start_date}}</span>
                                                </li>
                                                <li class="text-bold">
                                                    <span>نهاية الضمان</span>
                                                    <span>:</span>
                                                    <span>{{$orderGuarantee->end_date}}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END timeline item -->
                            <!-- timeline item -->
                            @if(count($order->files) > 0)
                                <div>
                                    <i class="fas fa-list bg-yellow"></i>
                                    <div class="timeline-item">
                                        <h3 class="timeline-header">الصور والفيديوهات الخاصه بمشكلة الطلب</h3>
                                        <div class="timeline-body">
                                            @if($order->files()->where('media_type','video')->exists())
                                                <div class="problem-title">
                                                    <h5 class="font-weight-bold">وصف بالفيديو : </h5>
                                                </div>
                                                @foreach($order->files()->where('media_type','video')->get() as $file)
                                                    <div class="problem-dec">
                                                        <video style="width: 200px" controls="controls" class="video-stream"
                                                               x-webkit-airplay="allow"
                                                               src="{{ dashboard_url('storage/images/orders/'.$file->image) }}"></video>
                                                    </div>
                                                @endforeach
                                            @endif
                                            @if($order->files()->where('media_type','audio')->exists())
                                                <div class="problem-title">
                                                    <h5 class="font-weight-bold">وصف بالصوت : </h5>
                                                </div>
                                                @foreach($order->files()->where('media_type','audio')->get() as $file)
                                                    <audio controls src="{{ dashboard_url('storage/images/orders/'.$file->image) }}">
                                                        Your browser does not support the
                                                        <code>audio</code> element.
                                                    </audio>
                                                @endforeach
                                            @endif
                                            @if($order->files()->where('media_type','image')->exists())
                                                <div class="problem-title">
                                                    <h5 class="font-weight-bold">وصف بالصور : </h5>
                                                </div>
                                                @foreach($order->files()->where('media_type','image')->get() as $file)
                                                    <div class="image item">
                                                        <a href="{{ dashboard_url('storage/images/orders/'.$file->image) }}" data-lightbox="photos">
                                                            <img class="img-fluid" style="width: 150px" src="{{ dashboard_url('storage/images/orders/'. $file->image) }}">
                                                        </a>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if($order->OrderBills && $order->OrderBills()->where('order_bills.status',1)->where('order_bills.type','service')->count() > 0)
                                @foreach($order->OrderBills()->where('order_bills.status',1)->where('order_bills.type','service')->get() as $key => $bill)
                                    <div>
                                        <i class="fas fa-list bg-yellow"></i>
                                        <div class="timeline-item">
                                            <h3 class="timeline-header">فاتوره ({{$key + 1}})</h3>
                                            <div class="timeline-body">
                                                {!! $bill['text'] !!}
                                                <div>{{$bill['price']}} {{awtTrans('ر.س')}}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        <!-- timeline item -->
                            <div>
                                <i class="fas fa-list bg-yellow"></i>
                                <div class="timeline-item">
                                    <h3 class="timeline-header">الخدمات</h3>
                                    <div class="timeline-body">
                                        <table class="table table-striped table-bordered dt-responsive nowrap">
                                            <tr>
                                                <td>اسم الخدمه</td>
                                                <td>العدد</td>
                                                <td>السعر</td>
                                                <td>الحاله</td>
                                                <td>النوع</td>
                                            </tr>
                                            @foreach($order->orderServices as $orderService)
                                                <tr>
                                                    <td>{{$orderService['title'] != null ? $orderService['title'] : $orderService->service['title']}}</td>
                                                    <td>{{$orderService['count']}}</td>
                                                    <td>{{$orderService['price']}}</td>
                                                    <td>{{$orderService['status'] == 1 ? 'مقبول' : ($orderService['status'] == 2 ? 'مرفوض' : ($orderService['status'] == 0 ? 'تحت المراجعه' : '-'))}}</td>
                                                    <td>{{\App\Entities\OrderService::serviceType($orderService['type'])}}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- timeline item -->
                            @if($order->orderParts()->whereHas('orderBills',function($query){$query->where('status',1);})->count() > 0)
                                <div>
                                    <i class="fas fa-list bg-yellow"></i>
                                    <div class="timeline-item">
                                        <h3 class="timeline-header">قطع الغيار</h3>
                                        <div class="timeline-body">
                                            <table class="table table-striped table-bordered dt-responsive nowrap">
                                                <tr>
                                                    <td>اسم قطعة الغيار</td>
                                                    <td>العدد</td>
                                                    <td>السعر</td>
                                                </tr>
                                                @foreach($order->orderParts()->whereHas('orderBills',function($query){$query->where('status',1);})->get() as $orderPart)
                                                    <tr>
                                                        <td>{{$orderPart['title'] != null ? $orderPart['title'] : '---'}}</td>
                                                        <td>{{$orderPart['count']}}</td>
                                                        <td>{{$orderPart['price']}}</td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                </div>
                        @endif
                        <!-- timeline item -->
                            <div>

                                @if($order->reviews)
                                    <div class="row">
                                        @foreach($order->reviews as $review)

                                            <div class="kt-portlet kt-portlet--mobile col-lg-6">


                                                <div class="kt-portlet__body">
                                                    <div class="decription d-block d-md-flex">

                                                        <div class="problem-title">
                                                            <h7 class="font-weight-bold">@if($review->user['user_type'] == 'client') تقييم العميل للفني @else تقييم الفني للعميل @endif : </h7>
                                                        </div>
                                                        <div class="">
                                                            <p>
                                                                @if($review->user['user_type'] == 'client') {{ $review->user['name'] }} @else {{ $review->user['name'] ?? '---' }}  @endif
                                                            </p>
                                                        </div>

                                                    </div>
                                                    <div class="requist-info rating">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <h7 class="font-weight-bold"> {{__('admin/requests.rate')}} : <ul
                                                                            class="list-unstyled d-inline-block">
                                                                        <li> <i class="la {{ $review->rate >=1 ? 'la-star' : 'la-star-o' }}"></i> </li>
                                                                        <li> <i class="la {{ $review->rate >=2 ? 'la-star' : 'la-star-o' }}"></i> </li>
                                                                        <li><i class="la {{ $review->rate >=3 ? 'la-star' : 'la-star-o' }}"></i></li>
                                                                        <li> <i class="la {{ $review->rate >=4 ? 'la-star' : 'la-star-o' }}"></i> </li>
                                                                        <li> <i class="la {{ $review->rate >=5 ? 'la-star' : 'la-star-o' }}"></i> </li>
                                                                    </ul>
                                                                </h7>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if($review->comment)
                                                        <div class="decription d-block d-md-flex">
                                                            <div class="problem-title">
                                                                <h7 class="font-weight-bold"> وصف التقييم : </h7>
                                                            </div>
                                                            <div class="problem-dec replay-info">
                                                                <p>
                                                                    {{ $review->comment }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <!-- END timeline item -->
                            <div>
                                <i class="fas fa-list bg-yellow"></i>
                                <div class="timeline-item">
                                    <h3 class="timeline-header">العنوان</h3>
                                    <div class="timeline-body">
                                        <div class="col-sm-12 mb-3">
                                            <div class="form-group">
                                                <input type="hidden" name="lat" id="lat" value="{{$order['lat']}}">
                                                <input type="hidden" name="lng" id="lng" value="{{$order['lng']}}">
                                                <input type="text" name="address" id="address" value="{{$order['map_desc']}}" class="form-control" placeholder="{{awtTrans('قم بادخال ...')}}">
                                            </div>
                                            <div id="map" style="height: 300px"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


    </div>

    <!-- /.content -->
@endsection
@push('js')
    <script src="{{dashboard_url('js/map.js')}}"></script>
    <script
            src="https://maps.googleapis.com/maps/api/js?key={{settings('map_key')}}&libraries=places&callback=initMap"
            async defer></script>
    <script>
        function showNotes(notes) {
            if(notes == '') notes = 'لا يوجد ملاحظات';
            $('#notes').html(notes);
        }
        $('body').on('click','.addressInfo',function (){
            var order = $(this).data('order');
            $('[name=map_desc]').val(order.map_desc);
            $('[name=residence]').val(order.residence);
            $('[name=street]').val(order.street);
            $('[name=floor]').val(order.floor);
            $('[name=address_notes]').val(order.address_notes);
        });
        $('body').on('click','#child',function (){
            var service = $(this).data('service_id');
            var price = $(this).data('price');
            $('[name=order_service_id]').val(service);
            $('#price').val(price);
        });
        $('body').on('click','#reject',function (){
            var service = $(this).data('service_id');
            $('[name=order_service_id]').val(service);
        });

        $(document).on('click','.checkTech',function (){
            var order = `{{$order['id']}}`;
            var category_id = `{{$order['category_id']}}`;
            $('#technician_id').empty();
            $('#order_id').val(order);
            getTechs(order,category_id);
        });
    </script>
@endpush


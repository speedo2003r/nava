@extends('admin.layout.master')
@section('title',awtTrans('التقنيين'))
@section('breadcrumb')
    <a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName(),$user['id']) }}" class="kt-subheader__breadcrumbs-link">
        {{ awtTrans('كشف حساب تقني') }}</a>
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
                                    {{awtTrans('كشف حساب تقني')}}
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__body kt-portlet__body--fit  margin-15 ">
                            <div class="table-responsive">
                                <table id="datatable-table" class="table table-striped table-bordered dt-responsive nowrap"  style="width:100%">
                                    <thead>
                                    <tr>
                                        <th>
                                            {{__('ID')}}
                                        </th>
                                        <th>{{awtTrans('رقم الطلب')}}</th>
                                        <th>{{awtTrans('مدخول')}}</th>
                                        <th>{{awtTrans('مدين')}}</th>
                                        <th>{{awtTrans('دائن')}}</th>
                                        <th>{{awtTrans('تسوية')}}</th>
                                        <th>{{awtTrans('تاريخ الاضافه')}}</th>
                                        <th>{{awtTrans('تاريخ التحديث')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($incomes as $ob)
                                        <tr>
                                            <td>
                                                {{$ob['id']}}
                                            </td>
                                            <td>{{$ob->order ? $ob->order['order_num'] : ''}}</td>
                                            <td>{{$ob->income}}</td>
                                            <td>{{$ob->debtor}}</td>
                                            <td>{{$ob->creditor}}</td>
                                            <td>
                                                @if($ob['status'] == 0)
                                                <button data-id="{{$ob['id']}}" data-type="{{$ob['type']}}" data-toggle="modal" data-target="#settlement" data-placement="top" data-original-title="{{awtTrans('تسويه')}}"  class="add-settlement btn btn-sm btn-clean btn-icon btn-icon-md">
                                                    <i class="la la-cog"></i>
                                                </button>
                                                @else
                                                تم التسويه
                                                @endif
                                            </td>
                                            <td>{{$ob->created_at->format('Y-m-d h:i a')}}</td>
                                            <td>{{$ob->updated_at->format('Y-m-d h:i a')}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- send-noti modal-->
    <div class="modal fade" id="settlement"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{awtTrans('تسوية الحساب')}}</h5>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.technicians.settlement')}}" method="POST">
                        @csrf
                        <input type="hidden" name="id" id="income_id">
                        <div class="form-group">
                            <label for="">الدفع عن طريق</label>
                            <select name="type" id="type" required class="form-control">
                                <option value="" selected hidden>اختر</option>
                                <option value="wallet">محفظه</option>
                                <option value="cash">كاش</option>
                            </select>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="submit" class="btn btn-sm btn-success">{{awtTrans('تسوية')}}</button>
                            <button type="button" class="btn btn-default" id="notifyClose" data-dismiss="modal">{{awtTrans('اغلاق')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end send-noti modal-->



@endsection
@push('js')
    <script>
        $('body').on('click','.add-settlement',function(){
           var id = $(this).data('id');
           var type = $(this).data('type');
           if(type == 'creditor'){
               $("#type option[value=wallet]").hide();
           }else{
               $("#type option[value=wallet]").show();
           }
           $('#income_id').val(id);
        });
    </script>
@endpush

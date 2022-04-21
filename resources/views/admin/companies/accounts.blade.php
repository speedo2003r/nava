@extends('admin.layout.master')
@section('title',awtTrans('الشركات'))
@section('breadcrumb')
    <a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName(),$user['id']) }}" class="kt-subheader__breadcrumbs-link">
        {{ awtTrans('كشف حساب شركه') }}</a>
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
                                    {{awtTrans('كشف حساب شركه')}}
                                </h3>
                            </div>
                        </div>
                        <div class="kt-portlet__head-label mt-3">
                            <button class="btn btn-brand btn-elevate btn-icon-sm confirmDel" disabled onclick="deleteAllData('more','{{route('admin.technicians.delete',0)}}')" data-toggle="modal" data-target="#confirm-all-del">
                                <i class="la la-trash"></i>
                                {{awtTrans('حذف')}}
                            </button>
                        </div>
                        <div class="kt-portlet__body kt-portlet__body--fit  margin-15 ">
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
                                        <th>{{awtTrans('رقم الطلب')}}</th>
                                        <th>{{awtTrans('مدخول')}}</th>
                                        <th>{{awtTrans('مدين')}}</th>
                                        <th>{{awtTrans('دائن')}}</th>
                                        <th>{{awtTrans('تسوية')}}</th>
                                        <th>{{awtTrans('تاريخ الاضافه')}}</th>
                                        <th>{{awtTrans('تاريخ التحديث')}}</th>
                                        <th>{{awtTrans('تحكم')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($incomes as $ob)
                                        <tr>
                                            <td>
                                                <label class="custom-control material-checkbox" style="margin: auto">
                                                    <input type="checkbox" class="material-control-input checkSingle" id="{{$ob->id}}">
                                                    <span class="material-control-indicator"></span>
                                                </label>
                                            </td>
                                            <td>{{$ob->order ? $ob->order['order_num'] : ''}}</td>
                                            <td>{{$ob->income}}</td>
                                            <td>{{$ob->debtor}}</td>
                                            <td>{{$ob->creditor}}</td>
                                            <td>
                                                @if($ob['status'] == 0)
                                                <button data-id="{{$ob['id']}}" data-toggle="modal" data-target="#settlement" data-placement="top" data-original-title="{{awtTrans('تسويه')}}"  class="add-settlement btn btn-sm btn-clean btn-icon btn-icon-md">
                                                    <i class="la la-cog"></i>
                                                </button>
                                                @else
                                                تم التسويه
                                                @endif
                                            </td>
                                            <td>{{$ob->created_at->format('Y-m-d h:i a')}}</td>
                                            <td>{{$ob->updated_at->format('Y-m-d h:i a')}}</td>
                                            <td class="tAction">
                                                <button type="button"  onclick="confirmDelete('{{route('admin.cities.destroy',$ob->id)}}')" data-toggle="modal" data-target="#delete-model" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="" data-placement="top" data-original-title="{{awtTrans('حذف')}}" style="cursor: pointer">
                                                    <i class="la la-trash"></i>
                                                </button>
                                            </td>
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
           $('#income_id').val(id);
        });
    </script>
@endpush

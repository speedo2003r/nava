@extends('admin.layout.master')
@section('title',awtTrans('الكوبونات'))
@section('breadcrumb')
    <a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName()) }}" class="kt-subheader__breadcrumbs-link">
        {{ awtTrans('الكوبونات') }}</a>
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
                                    {{awtTrans('الكوبونات')}}
                                </h3>
                            </div>
                        </div>

                        <div class="kt-portlet__head-label mt-3">
                            <button type="button" data-toggle="modal" data-target="#addModel" class="btn btn-brand btn-elevate btn-icon-sm add-user">
                                <i class="la la-plus"></i>
                                {{awtTrans('اضافه')}}
                            </button>

                            <button class="btn btn-brand btn-elevate btn-icon-sm confirmDel" disabled onclick="deleteAllData('more','{{route('admin.coupons.destroy',0)}}')" data-toggle="modal" data-target="#confirm-all-del">
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
                                        <th>النوع</th>
                                        <th>الكود</th>
                                        <th>قيمة الخصم</th>
                                        <th>عدد الاستخدامات</th>
                                        <th>{{__('control')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($coupons as $ob)
                                        <tr>
                                            <td>
                                                <label class="custom-control material-checkbox" style="margin: auto">
                                                    <input type="checkbox" class="material-control-input checkSingle" id="{{$ob->id}}">
                                                    <span class="material-control-indicator"></span>
                                                </label>
                                            </td>
                                            <td>{{($ob['kind'] == 'percent' ? 'نسبه' : 'قيمه')}}</td>
                                            <td>{{$ob['code']}}</td>
                                            <td>{{$ob['value']}}</td>
                                            <td>{{$ob['count']}}</td>
                                            <td class="tAction">
                                                <button onclick="edit({{$ob}})" data-toggle="modal" data-target="#editModel" data-placement="top" data-original-title="{{awtTrans('تعديل')}}"  class="btn btn-sm btn-clean btn-icon btn-icon-md">
                                                    <i class="la la-cog"></i>
                                                </button>
                                                <button type="button"  onclick="confirmDelete('{{route('admin.coupons.destroy',$ob->id)}}')" data-toggle="modal" data-target="#delete-model" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="" data-placement="top" data-original-title="{{awtTrans('حذف')}}" style="cursor: pointer">
                                                    <i    class="la la-trash"></i>
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
        <!-- end:: Content -->
    </div>


 <!-- add model -->
 <div class="modal fade" id="addModel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">اضافة كوبون</h4></div>
            <form action="{{route('admin.coupons.store')}}" method="post" role="form" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                <!--begin::Portlet-->
                        <div class="kt-portlet" style="padding-top:15px">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>رمز الكوبون</label>
                                    <input type="text" name="code" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>تحديد النوع</label>
                                    <select name="kind" class="form-control kind">
                                        <option value="">اختر</option>
                                        <option value="percent">نسبه</option>
                                        <option value="fixed">قيمه ثابته</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row value">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>عدد الاستخدامات</label>
                                    <input type="number" name="count" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>القيمه</label>
                                    <input type="number" name="value" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>تاريخ بداية الكوبون</label>
                                    <input type="date" name="start_date" max="9999-12-31" maxlength="4" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>تاريخ نهاية الكوبون</label>
                                    <input type="date" name="end_date" max="9999-12-31" maxlength="4" class="form-control">
                                </div>
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
<!-- end add model -->

<!-- edit model -->
<div class="modal fade" id="editModel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"><h4 class="modal-title">تعديل كوبون</h4></div>
            <form action=""  id="editForm" method="post" role="form" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                @include('components.lang_taps')
                <!--begin::Portlet-->
                    <div class="kt-portlet" style="padding-top:15px">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>رمز الكوبون</label>
                                    <input type="text" name="code" id="code" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>تحديد النوع</label>
                                    <select name="kind" class="form-control kind" id="kind">
                                        <option value="">اختر</option>
                                        <option value="percent">نسبه</option>
                                        <option value="fixed">قيمه ثابته</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row value">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>عدد الاستخدامات</label>
                                    <input type="number" name="count" id="count" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>القيمه</label>
                                    <input type="number" name="value" id="value" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>تاريخ بداية الكوبون</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>تاريخ نهاية الكوبون</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control">
                                </div>
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
    <script>
        $(function (){
            'use strict'
           $('body').on('click','[name=kind]',function (){
                var kind = $(this).val();
                if(kind == 'percent'){
                    $('[name=value]').attr('max',100);
                }else{
                    $('[name=value]').removeAttr('max');
                }
           })
        });
        function edit(ob){

            $('#editForm')      .attr("action","{{route('admin.coupons.update','obId')}}".replace('obId',ob.id));
{{--            @foreach(\App\Entities\Lang::all() as $key => $locale)--}}
{{--            $('#title_{{$locale['lang']}}')    .val(ob.title.{{$locale['lang']}});--}}
{{--            $('#content_{{$locale['lang']}}')    .val(ob.content.{{$locale['lang']}});--}}
{{--            @endforeach--}}
            $('#code')    .val(ob.code);
            $('#value')    .val(ob.value);
            $('#count')     .val(ob.count);
            $('#kind')     .val(ob.kind).change;
            if(ob.kind == 'percent'){
                $('[name=value]').attr('max',100);
            }else{
                $('[name=value]').removeAttr('max');
            }
            $('#user_id')     .val(ob.user_id);
            $('#start_date')     .val(ob.start_date).change;
            $('#end_date')     .val(ob.end_date).change;
        }

    </script>
@endpush

@extends('admin.layout.master')

@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 ">
                    <div class="page-header callout-primary d-flex justify-content-between">
                        <h2>المنتجات الأكثر بحثا</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="card page-body">
            <div class="row">
{{--                @if(auth()->user()['role_id'] == 1)--}}
{{--                    <div class="col-md-3"></div>--}}
{{--                    <div class="col-md-6">--}}
{{--                        <form action="{{url('/admin/statistics/search')}}" method="get">--}}
{{--                            <label for="" class="label-control">الدول</label>--}}
{{--                            <select name="country_id" class="form-control">--}}
{{--                                <option value="">اختر</option>--}}
{{--                                @foreach($countries as $country)--}}
{{--                                    <option value="{{$country['id']}}" @if($countryquery == @$country['id']) selected @endif>{{$country->title}}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                            <button type="submit" class="btn btn-primary mt-2">اختيار</button>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                @endif--}}
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table id="datatable-table" class="table table-striped table-bordered dt-responsive nowrap"  style="width:100%">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th class="product-th">المنتج</th>
                                <th class="quy-th">الحالة</th>
                                <th class="size-th">SKU</th>
                                <th class="total-th">الكمية</th>
                                <th>نوع</th>
                                <th>البائع</th>
                                <th>المشاهدات</th>
                                <th>التاريخ</th>
                                <th>{{__('control')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($items as $ob)
                                <tr>
                                    <td></td>
                                    <td class="product-col">
                                        <div class="pc-title">
                                            <img class="lazy" style="width: 100px" src="{{$ob->main_image}}" alt="">
                                            <a href="#">
                                                <h4 class="blue">
                                                    {{$ob['title_ar']}} |
                                                    {{$ob['title_en']}}
                                                </h4>
                                            </a>
                                            <p>{!! $ob->groups()->first() ? $ob->groups()->first()->_price() : null !!}</p>
                                        </div>
                                    </td>
                                    <td class="statustr{{$ob->id}}">
                                        @if($ob->status == 0)
                                            <span class="badge badge-danger">
								تحت المراجعة
							    </span>
                                        @elseif($ob->status == 1)
                                            <span class="badge badge-success">
								أونلاين
							    </span>
                                        @elseif($ob->status == 3)
                                            <span class="badge badge-warning">
								معطل
							    </span>
                                        @endif
                                    </td>
                                    <td>
                                        {{count($ob->groups) > 0 ? $ob->groups()->first()['in_stock_sku'] : '-'}}
                                    </td>
                                    <td class="size-col">
                                        <div>
                                            @if($ob->qty() > 0)
                                                <i class="fa fa-check-square"></i>
                                            @endif
                                            <span>{{$ob->qty()}}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if($ob->type == 'simple')
                                            بسيط
                                        @else
                                            متعدد
                                        @endif
                                    </td>
                                    <td>
                                        <a href="#">{{$ob->user ? $ob->user->seller['store_name'] : null}}</a>
                                    </td>
                                    <td>
                                        {{count($ob->searches)}}
                                    </td>
                                    <td class="quy-col">
                                        <?php
                                        $date = \Carbon\Carbon::parse($ob['created_at']);
                                        echo $date->format('Y-m-d / h:i A');
                                        ?>
                                    </td>
                                    <td>
                                        <a href="{{route('admin.items.edit',$ob['id'])}}" class="btn btn-success mx-2"><i class="fas fa-edit"></i></a>
                                        <button class="btn btn-danger" onclick="confirmDelete('{{route('admin.items.destroy',$ob->id)}}')" data-toggle="modal" data-target="#delete-model">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            @if(count($items) > 0)
                                <tr>
                                    <td colspan="30">
                                        <button class="btn btn-danger confirmDel" disabled onclick="deleteAllData('more','{{route('admin.items.destroy',$ob->id)}}')" data-toggle="modal" data-target="#confirm-all-del">
                                            <i class="fas fa-trash"></i>
                                            حذف المحدد
                                        </button>
                                    </td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

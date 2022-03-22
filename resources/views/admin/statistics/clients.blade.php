@extends('admin.layout.master')

@section('content')
    <section class="content">
        <div class="card page-body">
            <div class="row">
                @if(auth()->user()['role_id'] == 1)
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <form action="{{url('/admin/statistics/clients')}}" method="get">
                    <label for="" class="label-control">الدول</label>
                    <select name="country_id" class="form-control">
                        <option value="">اختر</option>
                        @foreach($countries as $country)
                            <option value="{{$country['id']}}" @if($countryquery == @$country['id']) selected @endif>{{$country->title}}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary mt-2">اختيار</button>
                    </form>
                </div>
                @endif
                <div class="col-md-12">
                    <h3>العملاء الأكثر طلبا</h3>
                    <table id="datatable-table" class="table table-striped table-bordered dt-responsive nowrap">
                        <thead>
                        <tr>
                            <th>عدد الطلبات</th>
                            <th>الصوره</th>
                            <th> الاسم</th>
                            <th> البريد الالكتروني</th>
                            <th>رقم الجوال</th>
                            <th>الحاله</th>
                            <th> تاريخ التسجيل</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($users as $key => $u)
                            @if($u['count'] > 0)
                            <tr>
                                <td data-order="asc">
                                    {{$u->count}}
                                </td>
                                <td><img src="{{$u->avatar}}" style="height: 120px;width: 120px;" class="img-circle"></td>
                                <td>{{$u->name}}</td>
                                <td>{{$u->email}}</td>
                                <td>{{$u->phone}}</td>
                                <td>
                                    <label class="label label-{{$u['banned'] == 1 ? 'warning' : 'success'}}">{{$u->banned == 1 ? 'حظر' : ' نشط'}}</label>
                                </td>
                                <td>{{$u->created_at->diffForHumans()}}</td>
                            </tr>
                            @endif
                        @endforeach
                        </tbody>


                    </table>
                </div>
                <div class="col-md-12">
                    <h3>العملاء الأكثر دفعا الكترونيا</h3>
                    <table id="datatable-table2" class="table table-striped table-bordered dt-responsive nowrap">
                        <thead>
                        <tr>
                            <th>الصوره</th>
                            <th> الاسم</th>
                            <th> البريد الالكتروني</th>
                            <th>رقم الجوال</th>
                            <th>الحاله</th>
                            <th> تاريخ التسجيل</th>
                        </tr>
                        </thead>

                        <tbody>
{{--                        @foreach($users as $key => $u)--}}
{{--                            <tr>--}}
{{--                                <td><img src="{{$u->avatar}}" style="height: 120px;width: 120px;" class="img-circle"></td>--}}
{{--                                <td>{{$u->name}}</td>--}}
{{--                                <td>{{$u->email}}</td>--}}
{{--                                <td>{{$u->phone}}</td>--}}
{{--                                <td>--}}
{{--                                    <label class="label label-{{$u['banned'] == 1 ? 'warning' : 'success'}}">{{$u->banned == 1 ? 'حظر' : ' نشط'}}</label>--}}
{{--                                </td>--}}
{{--                                <td>{{$u->created_at->diffForHumans()}}</td>--}}
{{--                            </tr>--}}
{{--                        @endforeach--}}
                        </tbody>


                    </table>
                </div>
            </div>
        </div>
    </section>

@endsection
@push('js')
    <script !src="">

        $(function () {
            'use strict'
            var a = $("#datatable-table2").DataTable({
                dom: 'Bfrtip',
                pageLength: 10,
                buttons: [
                    {
                        extend: 'csv',
                        text: 'ملف Excel',
                        className: "btn btn-success"

                    },
                    {
                        extend: 'print',
                        text: 'ملف PDF',
                        className: "btn btn-inverse"
                    },
                ],

                "language": {
                    "sEmptyTable": "ليست هناك بيانات متاحة في الجدول",
                    "sLoadingRecords": "جارٍ التحميل...",
                    "sProcessing": "جارٍ التحميل...",
                    "sLengthMenu": "أظهر _MENU_ مدخلات",
                    "sZeroRecords": "لم يعثر على أية سجلات",
                    "sInfo": "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
                    "sInfoEmpty": "يعرض 0 إلى 0 من أصل 0 سجل",
                    "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
                    "sInfoPostFix": "",
                    "sSearch": "ابحث:",
                    "sUrl": "",
                    "oPaginate": {
                        "sFirst": "الأول",
                        "sPrevious": "السابق",
                        "sNext": "التالي",
                        "sLast": "الأخير"
                    },
                    "oAria": {
                        "sSortAscending": ": تفعيل لترتيب العمود تصاعدياً",
                        "sSortDescending": ": تفعيل لترتيب العمود تنازلياً"
                    }
                }
            });
            a.buttons().container().appendTo("#datatable-table_wrapper .col-md-6:eq() ")


        });
    </script>

@endpush


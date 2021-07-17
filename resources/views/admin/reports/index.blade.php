@extends('admin.layout.master')
@section('content')


    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 ">
                    <div class="page-header callout-primary d-flex justify-content-between">
                        <h2>تقارير لوحة التحكم</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="card page-body">
            <div class="table-responsive">
                <div class="table-responsive">
                    {!! $dataTable->table([
                     'class' => "table table-striped table-bordered dt-responsive nowrap",
                     'id' => "reportdatatable-table",
                     ],true) !!}
                </div>
            </div>
        </div>
    </section>



@endsection
@push('js')
    {!! $dataTable->scripts() !!}
    <script>
        $(function () {
            'use strict'
            footerBtn(`{{route('admin.reports.delete',0)}}`);
        });
    </script>
@endpush

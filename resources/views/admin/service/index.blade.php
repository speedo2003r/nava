@extends('admin.layout.master')
@section('content')
    @push('css')
        <style>
            .select2-container{
                width: 100% !important;
            }
            .act-button {
                padding: 10px 0;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .act-button button {
                margin: 0 15px;
                border-radius: 30px;
            }

            .changeStar {
                background: transparent;
                border: none;
                position: absolute;
                top: 10px;
                left: 0;
                color: #ffc71b;
                font-size: 20px;
            }

            .changeStar i {
                font-size: 20px;
            }

            .cart-table .product-col {
                display: flex;
                width: 300px;
                align-items: center;
                position: relative;
            }

            .cart-table .product-col img {
                width: 100px;
                height: 100px;
                margin: auto;
            }

            .cart-table .product-col .pc-title h4 {
                font-size: 16px;
                color: #29ABE2;
                font-weight: 700;
                margin-bottom: 3px;
            }

            .cart-table .product-col .pc-title {
                display: flex;
                vertical-align: middle;
                padding-right: 30px;
                flex-direction: column;
                justify-content: center;
                text-align: center;
                margin: auto;
            }

            .cart-table .product-col .pc-title p {
                margin-bottom: 0;
                font-size: 16px;
                color: #414141;
            }
        </style>
    @endpush

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 ">
                    <div class="page-header callout-primary d-flex justify-content-between">
                        <h2>الخدمات</h2>
                        <a href="{{route('admin.services.create')}}" class="btn btn-primary btn-wide waves-effect waves-light">
                            <i class="fas fa-plus"></i> اضافة خدمه
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card page-body">
            <div class="table-responsive">
                {!! $dataTable->table([
                 'class' => "table table-striped table-bordered dt-responsive nowrap",
                 'id' => "servicedatatable-table",
                 ],true) !!}
            </div>
        </div>
    </section>
@endsection
@push('js')
    {!! $dataTable->scripts() !!}
    <script>
        footerBtn(`{{url('admin/services/delete/0')}}`);
    </script>
@endpush

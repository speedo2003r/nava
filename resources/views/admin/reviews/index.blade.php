@extends('admin.layout.master')
@section('title',awtTrans('التقييمات'))
@section('breadcrumb')
    <a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName()) }}" class="kt-subheader__breadcrumbs-link">
        {{ awtTrans('التقييمات') }}</a>
@endsection
@section('content')
    @push('css')
        <style>
            :root {
                --star-size: 15px;
                --star-color: #ccc;
                --star-background: #333;
            }
            .Stars {
                --percent: calc(var(--rating) / 5 * 100%);
                display: inline-block;
                font-size: var(--star-size);
                font-family: Times;
                line-height: 1;
            }
            .Stars::before {
                content: "★★★★★";
                letter-spacing: 3px;
                background: linear-gradient(90deg, var(--star-background) var(--percent), var(--star-color) var(--percent));
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
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
                                    {{awtTrans('التقييمات')}}
                                </h3>
                            </div>
                        </div>


                        <div class="kt-portlet__body kt-portlet__body--fit  margin-15 ">
                            <div class="table-responsive">
                                {!! $dataTable->table([
                                 'class' => "table table-striped table-bordered dt-responsive nowrap",
                                 'id' => "reviewdatatable-table",
                                 ],true) !!}
                            </div>
                        </div>

                    </div>
                </div>
            </div>


        </div>
        <!-- end:: Content -->
    </div>


    <!-- end add model -->

    <!-- edit model -->
    <div class="modal fade" id="showModel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header"><h4 class="modal-title">مشاهدة التعليق</h4></div>
                <form action=""  id="editForm" method="post" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                    <!--begin::Portlet-->
                        <div class="kt-portlet" style="padding-top:15px">
                            <div class="form-group">
                                <label>{{awtTrans('التعليق')}}</label>
                                <textarea class="form-control" id="comment" readonly cols="30" rows="10"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{__('close')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- end edit model -->

@endsection
@push('js')
    {!! $dataTable->scripts() !!}
    <script>
        function show(ob){
            $('#comment').val(ob.comment);
        }
    </script>
@endpush

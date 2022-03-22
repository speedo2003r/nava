@extends('admin.layout.master')
@section('title',awtTrans('تواصل معنا'))
@section('breadcrumb')
    <a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName()) }}" class="kt-subheader__breadcrumbs-link">
        {{ awtTrans('تواصل معنا') }}</a>
@endsection
@section('content')
@push('css')
    <style>
        .show-profile .modal-body {
            padding: 0;
            box-sizing: unset;
            border-radius: 4px 4px 0 0;
            overflow: hidden;
        }
        .show-profile .img-div {
            display: flex;
            padding: 15px;
            align-items: flex-end;
            position: relative;
        }
        .show-profile img {
            width: 100px;
            height: 100px;
            margin: 0 auto -50px;
            border-radius: 50%;
            border: 2px solid #ffff;
            background: #fff;
        }
        .show-profile .user-d {
            padding-top: 50px;
        }
        .show-profile .user-d p.name {
            font-size: 25px;
            font-weight: bold;
            margin-bottom: 0;
        }
        .show-profile .user-d ul {
            list-style: none;
            padding: 10px 15px;
        }
        .show-profile .user-d ul li {
            display: flex;
            align-items: center;
        }
        .show-profile .user-d ul li i {
            background: #000;
            color: #fff;
            text-align: center;
            width: 30px;
            height: 30px;
            line-height: 30px;
            display: block;
            margin-right: 10px;
            border-radius: 5px;
        }
        .show-profile .user-d ul a {
            color: #000;
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
                                    {{awtTrans('تواصل معنا')}}
                                </h3>
                            </div>
                        </div>



                        <div class="kt-portlet__body kt-portlet__body--fit  margin-15 ">
                            <div class="table-responsive">
                                <div class="table-responsive">
                                    {!! $dataTable->table([
                                     'class' => "table table-striped table-bordered dt-responsive nowrap",
                                     'id' => "contactusdatatable-table",
                                     ],true) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <!-- end:: Content -->
    </div>


<!-- end add model -->

<!-- show model -->
    <div class="modal fade show-profile" id="contact-profile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="img-div">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <img src="{{dashboard_url('mail.png')}}" alt="">
                    </div>
                    <div class="user-d text-center">
                        <p class="name" id="show_name"></p>
                        <ul>
{{--                            <li>--}}
{{--                                <i class="fa fa-phone"></i>--}}
{{--                                <a id="show_phone" href="">--}}

{{--                                </a>--}}
{{--                            </li>--}}
                            <li>
                                <i class="fa fa-envelope"></i>
                                <a id="show_email" href="">

                                </a>
                            </li>
                            <li>
                                <i class="fa fa-envelope"></i>
                                <span id="show_message"></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- end edit model -->

@endsection
@push('js')
    {!! $dataTable->scripts() !!}
    <script>

        footerBtn(`{{route('admin.contacts.destroy',0)}}`);
        function show(contact){
            $('#show_name').html(contact.name);
            $('#show_phone').html(contact.phone);
            $('#show_phone').removeAttr('href');
            $('#show_phone').attr('href' , "tel:" + contact.phone);
            $('#show_email').html(contact.email);
            $('#show_email').removeAttr('href');
            $('#show_email').attr('href' , "mailto:" + contact.email);
            $('#show_title').html(contact.title);
            $('#show_message').html(contact.message);

            var seen = 1;
            $.ajax({
                type: "POST",
                url: "{{url('/admin/contacts/')}}/"+contact.id,
                data: {id: contact.id,seen: seen, _token: '{{csrf_token()}}'},
                success: function( msg ) {}
            });
        }
    </script>
@endpush

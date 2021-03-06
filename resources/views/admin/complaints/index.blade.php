@extends('admin.layout.master')
@section('title',awtTrans('الشكاوي والمقترحات'))
@section('breadcrumb')
    <a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName()) }}" class="kt-subheader__breadcrumbs-link">
        {{ awtTrans('الشكاوي والمقترحات') }}</a>
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
                                    {{awtTrans('الشكاوي والمقترحات')}}
                                </h3>
                            </div>
                        </div>



                        <div class="kt-portlet__body kt-portlet__body--fit  margin-15 ">
                            <div class="table-responsive">
                                <div class="table-responsive">
                                    {!! $dataTable->table([
                                     'class' => "table table-striped table-bordered dt-responsive nowrap",
                                     'id' => "complaintdatatable-table",
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
                            <li>
                                <i class="fa fa-phone"></i>
                                <a id="show_phone" href="">

                                </a>
                            </li>
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

        footerBtn(`{{route('admin.complaints.destroy',0)}}`);
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
                url: "{{url('/admin/complaints/')}}/"+contact.id,
                data: {id: contact.id,seen: seen, _token: '{{csrf_token()}}'},
                success: function( msg ) {}
            });
        }
    </script>
@endpush

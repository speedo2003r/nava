@extends('admin.layout.master')
@section('content')


    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 ">
                    <div class="page-header callout-primary d-flex justify-content-between">
                        <h2>تواصل معنا</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="card page-body">
            <div class="table-responsive">
                <div class="table-responsive">
                    {!! $dataTable->table([
                     'class' => "table table-striped table-bordered dt-responsive nowrap",
                     'id' => "contactusdatatable-table",
                     ],true) !!}
                </div>
            </div>
        </div>
    </section>


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

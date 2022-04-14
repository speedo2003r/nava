@extends('admin.layout.master')
@section('title',awtTrans('المحادثه'))
@section('breadcrumb')
    <a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName(),$order['id']) }}" class="kt-subheader__breadcrumbs-link">
        {{ awtTrans('المحادثه') }}</a>
@endsection
@section('content')
    <style>
        /* chat box */
        .chat .modal.modal-sticky-bottom-right{
            width: 100%;
            max-width: 100%;
            position: static;
            z-index: auto;

        }
        .chat .modal.modal-sticky-bottom-right .modal-dialog{
            width: 100%;
            max-width: 100%;
        }
        .chat .chat-message{
            width: 50%;
            padding:25px;;
            border-radius:4px;
            margin-bottom: 20px;
            position: relative;
        }
        @media(max-width:992px){
            .chat .chat-message{
                width:100% !important;
            }
        }
        /* .chat .chat-message i{
            position: absolute;
            bottom: 5px;
            left: 25px;
        } */
        .chat .chat-message p{
            font-size: 14px;
        }
        .chat .color-1{
            background-color: #f7f8fa;
        }
        .chat .color-2{
            background-color:rgba(10, 187, 135, 0.1);
        }
        textarea.input-custom-size{
            resize: none;
            margin: 15px 0;
        }
        .chat .color-3{
            background-color: rgba(255, 184, 34, 0.1);
        }
        .chat .right-message{
            float: right;
        }
        .chat .left-message{
            float: left;
        }
        .chat  .message-ditails{
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            color: #5d78ff;
            font-weight: bold;
            font-size: 14px;
        }
        .chat  .message-ditails .position{
            color: #8e8f93;
            font-size: 12px;
        }
        .chat  .message-ditails .time{
            color:#8e8f93;
            direction: ltr;
        }
        .chat .right-message .message-ditails{
            flex-direction: row;
        }

        .chat-head{
            padding:  15px 0;;
        }
        .modal.modal-sticky-bottom-right{
            width: 100% !important;
            max-width: 100% !important;
            position: static !important;
            z-index: auto !important;
        }
        .font_12{
            clear:both;
            margin: 10px 0;
        }
        .chat-head ul li{
            margin-bottom: 15px;
            font-size: 14px;
        }
        .chat-head ul li span{
            width: 60px;
            display: inline-block;
            font-weight: 600;
        }
        .chat .text-right{
            display: flex;
            align-items: center;
            height: 100%;
            flex-direction: row-reverse;
        }
        .chat .text-right button{
            width: 100px;
        }
        .direct-chat-text {
            border-radius: 0.3rem;
            background: #d2d6de;
            border: 1px solid #d2d6de;
            color: #444;
            margin: 5px 0 0 50px;
            padding: 5px 10px;
            position: relative;
        }
        .sent_chat{
            margin: 15px;
        }
    </style>


    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

            <div class="">


                <div class="kt-portlet__body kt-portlet__body--fit ">

                    <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid p-0">
                        <!--Begin::Dashboard 1-->
                        <!--Begin::Row-->
                        <div class="chat">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="kt-portlet__body kt-portlet__body--fit">
                                        <div class="kt-widget17">
                                            <div class="kt-widget17__stats m-0  w-100">
                                                <div class="modal fade- modal-sticky-bottom-right show" id="kt_chat_modal" role="dialog" data-backdrop="false" aria-modal="true" style="padding-right: 17px; display: block;">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="kt-chat">
                                                                <div class="kt-portlet kt-portlet--last">
                                                                    <div class="kt-portlet__head">
                                                                        <div class="kt-chat__head ">
                                                                            <div class="kt-chat__left">
                                                                                <div class="kt-chat__label">
                                                                                    <div class="chat-head">
                                                                                        <div class="requist-info" id="app">
                                                                                            <div class="row">
                                                                                                <div class="col-lg-3">
                                                                                                    <ul class="list-unstyled">
                                                                                                        <li> <span style="width: 90px;"> رقم الطلب  : </span> {{$order->order_num}} </li>
                                                                                                    </ul>
                                                                                                </div>
                                                                                                <div class="col-lg-3">
                                                                                                    <ul class="list-unstyled">
                                                                                                        <li> <span style="width: 90px;"> اسم العميل : </span> {{$order->user->name}} </li>
                                                                                                    </ul>
                                                                                                </div>
                                                                                                <div class="col-lg-3">
                                                                                                    <ul class="list-unstyled">
                                                                                                        <li> <span style="width: 90px;"> اسم التقني : </span> {{$order->technician_id ? $order->technician->name : '---'}} </li>
                                                                                                    </ul>
                                                                                                </div>
                                                                                                <div class="col-lg-3">
                                                                                                    <ul class="list-unstyled">
                                                                                                        <li> <span style="width: 90px;"> تاريخ الطلب : </span> {{$order->time}} / {{$order->date}} </li>                                                                                                    </ul>
                                                                                                </div>
                                                                                            </div>

                                                                                            <chat-order-component order="{{ $order['id'] }}" room_id="{{$existRoom['id']}}" ></chat-order-component>
{{--                                                                                        </div>--}}



                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>

                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ---------------- -->
                                    </div>
                                </div>
                                <!--End::Row-->
                                <!--End::Dashboard 1-->
                            </div>
                            <!-- end:: Content -->

                            <!-- end:: Footer -->
                            <!-- end:: Page -->






                        </div></div>

                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')

    <script src="{{ asset('js/app.js') }}" defer async></script>
    <script type="text/javascript">

        $('#reply-message-chat').on('click',function(){

            $('#formReply').show();
            $('#reply-message-chat').hide();
        });

        $('#closeForm').on('click',function(){

            $('#formReply').hide();
            $('#reply-message-chat').show();
        });


    </script>

@endpush


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
                                                                                        <div class="requist-info">
                                                                                            <div class="row">
                                                                                                <div class="col-lg-8">
                                                                                                    <ul class="list-unstyled">
                                                                                                        <li> <span style="width: 90px;"> رقم الطلب  : </span> {{$order->order_num}} </li>
                                                                                                        <li> <span style="width: 90px;"> وقت تنفيذ الطلب : </span> {{$order->time}} / {{$order->date}} </li>
                                                                                                        <li> <span style="width: 90px;"> اسم العميل : </span> {{$order->user->name}} </li>
                                                                                                    </ul>
                                                                                                </div>
                                                                                            </div>
{{--                                                                                            <form method="post" id="formReply" action="{{action('Admin\MsgController@sendMsg')}}" style="display:none;">--}}

{{--                                                                                                <div class="row" style="border-top: 1px solid #EBEDF2;padding-top: 15px; text-align:right; position:relative">--}}

{{--                                                                                                    <textarea class="form-control" placeholder="{{__('admin/messages.message_placeholder')}}" name="message" id="exampleTextarea" rows="3" required></textarea>--}}
{{--                                                                                                    <div class="text-right mt-3 w-100">--}}
{{--                                                                                                        {{ csrf_field() }}--}}
{{--                                                                                                        <input type="hidden" name="chat_id" value="{{$chat->id}}">--}}
{{--                                                                                                        <button type="submit" class="btn btn-primary"> <i class="flaticon2-send-1"></i>{{__('admin/messages.send')}} </button>--}}
{{--                                                                                                        <a href="javascript:void(0)" id="closeForm"><i class="fa fa-close" style="position: absolute;top: 20px;left: 10px;"></i></a>--}}
{{--                                                                                                    </div>--}}

{{--                                                                                                </div>--}}
{{--                                                                                            </form>--}}



                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>

                                                                    </div>
                                                                    <div class="kt-portlet__body">
                                                                        <div class="kt-scroll kt-scroll--pull ps ps--active-y" data-height="350px" data-mobile-height="300" style="height: 410px; overflow: hidden;">
                                                                            <div class="kt-chat__messages kt-chat__messages--solid">
                                                                                <div class="row">

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


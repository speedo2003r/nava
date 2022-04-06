
<form action="{{route('hyperApplePayResult',['order_id'=>$order['id']])}}" lang="{{app()->getLocale()}}" class="paymentWidgets" data-brands="APPLEPAY"></form>

<script id="wpwloptions" src="/js/wpwloption.js"></script>
<script>
    var wpwlOptions = {
        applePay: {
            displayName: "MyStore",
            total: { label: "COMPANY, INC." }
        }
    }
</script>

@if(isset($checkout['id']))
    <script async src="https://test.oppwa.com/v1/paymentWidgets.js?checkoutId={{$checkout['id']}}"></script>
@endif

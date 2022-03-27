
<form action="{{route('hyperInvoiceResult',['order_id'=>$order['id']])}}" lang="{{app()->getLocale()}}" class="paymentWidgets" data-brands="VISA MASTER"></form>

<script id="wpwloptions" src="/js/wpwloption.js"></script>
<script>
    var wpwlOptions = {
        style: "card",
        locale: `{{app()->getLocale()}}`,
        forceCardHolderEqualsBillingName: true,
    }
</script>
@if(isset($checkout['id']))
    <script async src="https://test.oppwa.com/v1/paymentWidgets.js?checkoutId={{$checkout['id']}}"></script>
@endif

<div class="nav-tabs-custom nav-tabs-lang-inputs">
    <div class="tab-content">
        {{$slot}}
    </div>
</div>

@push('scripts')
@parent
<script>
$(document).ready(function() {
    $('.nav-tabs-lang-inputs .nav-tabs > li:first-child, .nav-tabs-lang-inputs .tab-content > .tab-pane:first-child').addClass('active');
});
</script>
@endpush

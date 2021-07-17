@if(Session::has('success'))
    <script>
        toastr.success('{{ Session::get('success') }}');
    </script>

    @elseif(Session::has('danger'))
    <script>
        toastr.error('{{ Session::get('danger') }}');
    </script>
@endif


@if (count($errors) > 0)
<script>
    @foreach(array_reverse($errors->all()) as $error)
        toastr.error('{{$error}}');
    @endforeach
</script>
    {{-- <script>

        @foreach(array_reverse($errors->all()) as $error)
        $(document).Toasts('create', {
            class: 'bg-danger error-toast',
            title: 'Error',
            subtitle: '',
            body: '{{$error}}'
        });
        @endforeach
    </script> --}}
@endif




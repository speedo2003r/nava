@extends('admin.layout.master')
@section('title',awtTrans('تعديل قائمة الصلاحيات'))
@section('breadcrumb')
    <a href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName(),$role['id']) }}" class="kt-subheader__breadcrumbs-link">
        {{ awtTrans('تعديل قائمة الصلاحيات') }}</a>
@endsection
@section('content')

    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <div class="row">
                <div class="col-md-12">

                @include('components.lang_taps')
                    <!--begin::Portlet-->
                    <div class="kt-portlet" style="padding-top:15px">
                        <form action="{{route('admin.roles.update',$role->id)}}" method="post">
                @method('put')
                @csrf
                <div class="nav-tabs-custom nav-tabs-lang-inputs">
                    <div class="tab-content">
                    @foreach(\App\Entities\Lang::all() as $key => $locale)
                        <div class="tab-pane @if(\App\Entities\Lang::first() == $locale)  fade show active @endif" id="locale-tab-{{$locale['lang']}}">
                            <div class="form-group">
                                <input type="text" name="name_{{$locale['lang']}}" class="form-control" value="{{$role['name_'.$locale['lang']]}}" placeholder="{{__('enter')}} ..." required>
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>
                <div class="row">
                    {{editRole($role->id)}}
                </div>
                <div class="m-5">
                    <input type="submit" value="{{__('save')}}" class="btn btn-success form-control" >
                </div>
            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('js')
    <script>
        $(function () {
            $('.roles-parent').change(function () {

                var childClass = '.' + $(this).attr('id');
                if (this.checked) {

                    $(childClass).prop("checked", true);

                } else {

                    $(childClass).prop("checked", false);
                }
            });
        });


        $("#checkedAll").change(function () {
            if (this.checked) {
                $("input[type=checkbox]").each(function () {
                    this.checked = true
                })
            } else {
                $("input[type=checkbox]").each(function () {
                    this.checked = false;
                })
            }
        });
    </script>
@endpush


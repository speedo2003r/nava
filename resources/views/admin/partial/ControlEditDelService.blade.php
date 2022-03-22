{{--<a id="child" data-toggle="kt-tooltip" title="" data-placement="top" data-original-title="قطع الغيار" href="{{route('admin.parts.index',$id)}}" class="btn btn-sm btn-clean btn-icon btn-icon-md">--}}
{{--    <i class="flaticon2-menu"></i>--}}
{{--</a>--}}
<button onclick="edit({{$data}})" data-toggle="modal" data-target="#{{$target}}" data-placement="top" data-original-title="{{awtTrans('تعديل')}}"  class="btn btn-sm btn-clean btn-icon btn-icon-md">
    <i class="la la-cog"></i>
</button>
{{--<button type="button"  onclick="confirmDelete('{{route($url,$id)}}')" data-toggle="modal" data-target="#delete-model" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="" data-placement="top" data-original-title="{{awtTrans('حذف')}}" style="cursor: pointer">--}}
{{--    <i    class="la la-trash"></i>--}}
{{--</button>--}}

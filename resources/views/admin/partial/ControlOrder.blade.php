@if($technician_id == null)
    <button data-id="{{$id}}" data-category="{{$category_id}}" data-toggle="modal" data-target="#assign-tech" title="" data-placement="top" data-original-title="تعيين" class="child btn btn-sm btn-clean btn-icon btn-icon-md">
        <i class="fa fa-check"></i>
    </button>
@endif
@if($status != 'rejected' && $status != 'canceled' && $technician_id == null)
<a data-id="{{$id}}" data-toggle="kt-tooltip" title="" data-placement="top" data-original-title="رفض" class="btn btn-sm btn-clean btn-icon btn-icon-md reject" style="cursor: pointer;">
    <i data-toggle="modal" data-target="#deleteModal-reject" class="la la-close"></i>
</a>
@endif
<button onclick="sendNotify('one' , '{{ $user_id }}')" data-toggle="modal" data-target="#send-noti" data-placement="top" data-original-title="{{awtTrans('إرسال إشعار')}}"  class="btn btn-sm btn-clean btn-icon btn-icon-md">
    <i class="fas fa-paper-plane"></i>
</button>
<a id="child" data-toggle="kt-tooltip" title="" data-placement="top" data-original-title="محادثه"  href="{{route('admin.chats.room', $id)}}" class="btn btn-sm btn-clean btn-icon btn-icon-md">
    <i class="flaticon2-chat"></i>
</a>
<a href="{{route($show,$id)}}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="" data-placement="top" data-original-title="{{awtTrans('مشاهده')}}"><i class="fas fa-eye"></i></a>
<button type="button"  onclick="confirmDelete('{{route($url,$id)}}')" data-toggle="modal" data-target="#delete-model" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="" data-placement="top" data-original-title="{{awtTrans('حذف')}}" style="cursor: pointer">
    <i class="la la-trash"></i>
</button>

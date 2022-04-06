@if($status != 'user_cancel')
@if($technician_id == null)
    <button data-id="{{$id}}" data-category="{{$category_id}}" data-toggle="modal" data-target="#assign-tech" title="" data-placement="top" data-original-title="تعيين" class="child btn btn-sm btn-clean btn-icon btn-icon-md checkTech">
        <i class="fa fa-check"></i>
    </button>
@endif
@if($status != 'rejected' && $status != 'canceled' && $technician_id == null)
<a data-id="{{$id}}" data-toggle="kt-tooltip" title="" data-placement="top" data-original-title="رفض" class="btn btn-sm btn-clean btn-icon btn-icon-md reject" style="cursor: pointer;">
    <i data-toggle="modal" data-target="#deleteModal-reject" class="la la-close"></i>
</a>
@endif
@endif
<button onclick="sendNotify('one' , '{{ $user_id }}')" data-toggle="modal" data-target="#send-noti" data-placement="top" data-original-title="{{awtTrans('إرسال إشعار')}}"  class="btn btn-sm btn-clean btn-icon btn-icon-md">
    <i class="fas fa-paper-plane"></i>
</button>
@if($technician_id != null)
<button data-toggle="modal" data-user_id="{{$user_id}}" data-order_id="{{$id}}" data-total="{{$final_total}}" data-target="#deductions" data-placement="top" data-original-title="{{awtTrans('خصم')}}"  class="btn btn-sm btn-clean btn-icon btn-icon-md add-deduction">
    <i class="fa fa-percent"></i>
</button>
@endif
@if($status != 'user_cancel')
<a id="child" data-toggle="kt-tooltip" title="" data-placement="top" data-original-title="محادثه"  href="{{route('admin.chats.room', $id)}}" class="btn btn-sm btn-clean btn-icon btn-icon-md">
    <i class="flaticon2-chat"></i>
</a>
@endif
<a href="{{route($show,$id)}}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="" data-placement="top" data-original-title="{{awtTrans('مشاهده')}}"><i class="fas fa-eye"></i></a>
<button type="button"  onclick="confirmDelete('{{route($url,$id)}}')" data-toggle="modal" data-target="#delete-model" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="" data-placement="top" data-original-title="{{awtTrans('حذف')}}" style="cursor: pointer">
    <i class="la la-trash"></i>
</button>

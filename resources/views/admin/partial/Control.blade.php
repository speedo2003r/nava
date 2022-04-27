<button onclick="sendNotify('one' , '{{ $id }}')" data-toggle="modal" data-target="#send-noti" data-placement="top" data-original-title="{{awtTrans('إرسال إشعار')}}"  class="btn btn-sm btn-clean btn-icon btn-icon-md">
    <i class="fas fa-paper-plane"></i>
</button>
<button onclick="sendToWallet({{$id}})" data-toggle="modal" data-target="#send-wallet" data-placement="top" data-original-title="{{awtTrans('اضافة رصيد')}}"  class="btn btn-sm btn-clean btn-icon btn-icon-md">
    <i class="fas fa-wallet"></i>
</button>
<button onclick="edit({{$data}})" data-toggle="modal" data-target="#{{$target}}" data-placement="top" data-original-title="{{awtTrans('تعديل')}}"  class="btn btn-sm btn-clean btn-icon btn-icon-md">
    <i class="la la-cog"></i>
</button>
<a id="child" data-toggle="kt-tooltip" title="" data-placement="top" data-original-title="محادثه"  href="{{route('admin.clients.chat', $id)}}" class="btn btn-sm btn-clean btn-icon btn-icon-md">
    <i class="flaticon2-chat"></i>
</a>
<button type="button"  onclick="confirmDelete('{{route($url,$id)}}')" data-toggle="modal" data-target="#delete-model" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="" data-placement="top" data-original-title="{{awtTrans('حذف')}}" style="cursor: pointer">
    <i    class="la la-trash"></i>
</button>

<a href="#" class="btn btn-sm btn-warning single" title="إرسال إشعار" onclick="sendNotify('one' , '{{ $id }}')" data-toggle="modal" data-target="#send-noti">
    <i class="fas fa-paper-plane"></i>
</a>
<a href="#" class="btn btn-sm btn-info mr-2 single" title="اضافة رصيد" onclick="sendToWallet('{{ $id }}')" data-toggle="modal" data-target="#send-wallet">
    <i class="fas fa-wallet"></i>
</a>
<button class="btn btn-success mx-2"  onclick="edit({{$data}})" data-toggle="modal" data-target="#{{$target}}"><i class="fas fa-edit"></i></button>
<button class="btn btn-danger" onclick="confirmDelete('{{route($url,$id)}}')" data-toggle="modal" data-target="#delete-model">
    <i class="fas fa-trash-alt"></i>
</button>

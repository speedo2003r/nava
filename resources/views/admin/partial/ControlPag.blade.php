
<a href="{{route($url,$item_id)}}" class="btn btn-success mx-2"><i class="fas fa-edit"></i></a>
<button class="btn btn-danger" onclick="confirmDelete('{{route($delete_url,$item_id)}}')" data-toggle="modal" data-target="#delete-model">
    <i class="fas fa-trash-alt"></i>
</button>

<button class="btn btn-success mx-2"  onclick="edit({{$data}})" data-toggle="modal" data-target="#editModel"><i class="fas fa-edit"></i></button>
<button class="btn btn-danger" onclick="confirmDelete('{{route($url,$id)}}')" data-toggle="modal" data-target="#delete-model">
    <i class="fas fa-trash-alt"></i>
</button>

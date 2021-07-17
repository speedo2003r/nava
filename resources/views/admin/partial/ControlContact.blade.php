<button class="btn btn-primary mx-2" onclick="show({{$data}})"  data-toggle="modal" data-target="#contact-profile"><i class="fas fa-eye"></i></button>
<button class="btn btn-danger" onclick="confirmDelete('{{route($url,$id)}}')" data-toggle="modal" data-target="#delete-model">
    <i class="fas fa-trash-alt"></i>
</button>

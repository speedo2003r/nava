<a href="{{route($show,$id)}}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="" data-placement="top" data-original-title="{{awtTrans('مشاهده')}}" data-toggle="modal" data-target="#contact-profile"><i class="fas fa-eye"></i></a>
<button type="button"  onclick="confirmDelete('{{route($url,$id)}}')" data-toggle="modal" data-target="#delete-model" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="" data-placement="top" data-original-title="{{awtTrans('حذف')}}" style="cursor: pointer">
    <i class="la la-trash"></i>
</button>

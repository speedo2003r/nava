 
 <form action ="{{url()->current() . '/'. $id}}" method="POST" onsubmit="return confirm('هل تريد الحذف ؟');" class = "mb-0 d-inline">
      @if(isset($branch_id))
                <input type="hidden" name="branch_id" value="{{ $branch_id }}" />
      @endif
      {{ method_field('DELETE') }}
      {{ csrf_field() }}
 <button type="submit" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="kt-tooltip" title="" data-placement="top" data-original-title="{{__('admin/general.delete')}}" style="cursor: pointer">
 <i    class="la la-trash"></i>   
 </button>
 
   </form>


 
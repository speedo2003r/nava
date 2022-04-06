 
 <a id="child" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="kt-tooltip" title="" data-placement="top" data-original-title="{{__('admin/requests.reject')}}" style="cursor: pointer">
 <i   data-toggle="modal" data-target="#deleteModal-{{$id}}" class="la la-close"></i>   
 </a>

<div class="modal fade modal-danger" id="deleteModal-{{$id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="deleteModalLabel">{{__('admin/requests.confirm_reject')}}</h4>
            </div>
            <div class="modal-body">
                {{__('admin/requests.confirm_reject_message')}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">@lang('admin/general.cancel')</button>
                {!! Form::open(['url' => url()->current() . '/'. $id, 'method' => 'delete','class' => 'mb-0']) !!}
                @if(isset($branch_id))
                <input type="hidden" name="branch_id" value="{{ $branch_id }}" />
                @endif
                <button type="submit" class="btn btn-primary">{{__('admin/requests.reject')}}</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

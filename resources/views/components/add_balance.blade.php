<a class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="kt-tooltip" title="" data-placement="top" data-original-title="{{__('admin/users.add_balance')}}" style="cursor: pointer" >
    <i  data-toggle="modal" data-target="#add-balance-Modal-{{$id}}" class="fa fa-dollar-sign"></i>
</a>

 <div class="modal fade modal-info" id="add-balance-Modal-{{$id}}" tabindex="-1" role="dialog" aria-labelledby="add-balance-ModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"> 
				                <h4 class="modal-title text-left" id="add-balance-ModalLabel">{{__('admin/users.add_balance_client')}}</h4>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
            {!! Form::open(['url' => action('Admin\UserController@updateBalance', ['user' => $id]), 'method' => 'put']) !!}
            <div class="modal-body">
                <div class="form-group">
                    {!! Form::label('balance', __('admin/users.balance')) !!}
                    {!! Form::number('balance', null, ['class' => 'form-control', 'id' => 'balance']) !!}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">{{__('admin/general.cancel')}}</button>
                <button type="submit" class="btn btn-primary">{{__('admin/users.add_balance_submit')}}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

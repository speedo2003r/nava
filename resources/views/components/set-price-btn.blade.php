 
 <a id="child" class="btn btn-sm btn-clean btn-icon btn-icon-md" data-toggle="kt-tooltip" title="" data-placement="top" data-original-title="{{__('admin/requests.estimate_price')}}" style="cursor: pointer">
 <i   data-toggle="modal" data-target="#set-price-{{$id}}" class="la la-dollar"></i>   
 </a>

<div class="modal fade modal-danger" id="set-price-{{$id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="deleteModalLabel">{{__('admin/requests.estimate_price_title')}}</h4>
            </div>
            {!! Form::open(['url' => route('requests.request.update', $request->id), 'method' => 'put']) !!}
            <div class="modal-body">
                <div class="form-group form-group-last">
                    {!! Form::number('price', $request->price, ['class' => 'form-control', 'id' => 'price', 'placeholder' => __('admin/requests.estimate_price_placeholder')]) !!}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">@lang('admin/general.cancel')</button>
                {!! Form::submit(__('admin/requests.message_confirm'), ['class' => 'btn btn-primary' ,'style'=>'width:auto']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<button type="button" class="btn btn-xs btn-default" data-toggle="modal" data-target="#logs-Modal-{{$log->id}}" ><i class="fa fa-database"></i> @lang('admin/logs.details')</button>

<div class="modal fade modal-default" id="logs-Modal-{{$log->id}}" tabindex="-1" role="dialog" aria-labelledby="logs-ModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 100%">
            <div class="modal-header">
                 <h4 class="modal-title" id="logs-ModalLabel">@lang('admin/logs.details')</h4>
            </div>
            <div class="modal-body">
                <table class="table" style="width: 100%">
                    
                    <tbody>
                      <tr>
                        <td>{{__('admin/users.name')}} : {{$log->user->name ?? '---'}}</td>
                        <td>{{__('admin/users.type')}} : {{$log->user->type ? @trans('admin/users.' . $log->user->type) : '---'}}</td>
                      </tr>
                      <tr>
                        <td>{{__('admin/users.branch')}} : {{$log->user->branch->title ?? '---'}} </td>
                        <td>{{__('admin/logs.action')}} : {{$log->action ? @trans('admin/logs.' . $log->action) : '---'}} </td>
                    </tr>
                    <tr>
                        <td>{{__('admin/logs.date')}}: {{$log->created_at->format('M d, Y') ?? '---'}}</td>
                        <td>{{__('admin/logs.time')}}: {{$log->created_at->format('h:m:s') ?? '---'}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">@lang('admin/logs.close')</button>
            </div>
        </div>
    </div>
</div>

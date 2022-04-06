<a id="child"  data-toggle="modal" data-target="#branch-Modal-{{$branch->id}}" title="" data-placement="top" data-original-title="التفاصيل" href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md">
    <i class="la la-bars"></i>
</a>

<div class="modal fade modal-default" id="branch-Modal-{{$branch->id}}" tabindex="-1" role="dialog" aria-labelledby="branch-ModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 100%">
            <div class="modal-header">
                 <h4 class="modal-title" id="branch-ModalLabel">{{__('admin/reports.branch_details')}}</h4>
            </div>
            <div class="modal-body">
                <table class="table" style="width: 100%">
                    
                    <tbody>
                      <tr>
                        <td>{{__('admin/reports.technicians')}} : {{ $branch->technicians()->count() }}</td>
                        <td>{{__('admin/reports.drivers')}} : {{ $branch->drivers()->count() }} </td>
                        <td>{{__('admin/reports.operations')}} : {{ $branch->operations()->count() }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">{{__('admin/general.close')}}</button>
            </div>
        </div>
    </div>
</div>

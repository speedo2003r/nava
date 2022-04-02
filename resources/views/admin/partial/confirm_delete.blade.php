<div class="modal fade" id="delete-model">
    <div class="modal-dialog model-sm">
        <div class="modal-content">
            <form action="" method="post" id="confirm-delete-form">
                @csrf
                @method('delete')
                <div class="modal-header"><h6 class="modal-title">تأكيد الحذف</h6></div>
                <div class="modal-body p-5"><h5 class="text-center">هل انت متاكد من عملية الحذف</h5></div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                    <button type="submit" class="btn btn-danger">حذف</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- confirm-del-all modal-->
<div class="modal fade" id="confirm-all-del" >
    <div class="modal-dialog model-sm">
        <div class="modal-content">
            <form action="" method="post" id="delete-all">
                @csrf
                @method('delete')
                <input type="hidden" name="data_ids" id="delete_ids">
                <input type="hidden" name="type" id="delete_type">

                <div class="modal-header"><h6 class="modal-title">تأكيد الحذف</h6></div>
                <div class="modal-body p-5"><h5 class="text-center">هل انت متاكد من عملية الحذف</h5></div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                    <button type="submit" class="btn btn-danger">حذف</button>
                </div>
            </form>
        </div>
    </div>
</div>

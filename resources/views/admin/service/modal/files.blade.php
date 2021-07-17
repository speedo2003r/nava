<div class="modal modal_product_files" style="background: #3333338c;">
    <div class="modal-dialog" style="min-width:1100px">
        <div class="modal-content">
            <div class="modal-header" style="background: #5dd5c4;direction: ltr;">
                <h6 class="modal-title text-left"> تفاصيل المنتج</h6>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body" style="direction: rtl">
                <input type="file"
                       multiple
                       class="filepond"
                       name="filepond"
                       data-allow-reorder="true"
                       data-max-file-size="3MB"
                       data-max-files="5">
                    <div class="row">
                        <div class="col-sm-6 my-3" v-if="forms[details].files" v-for="file, i in forms[details].files">
                            <div class="slim-result">
                                <img v-bind:src="file.image" alt="" style="width: 100%;object-fit: contain;height: 100%;">
                            </div>
                            <div class="product-photo-meta">
                                <a href="javascript:void(0)" style="color: #e74c3c;line-height: 3.5;" v-on:click="delImage(i,details)"><i class="fa fa-trash"></i></a>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>

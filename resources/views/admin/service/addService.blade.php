@extends('admin.layout.master')
@section('content')
    @push('css')
        <style>
            [v-cloak]{
                display: none;
            }
            select.form-control{
                height: 36px !important;
            }
            .small{
                font-size:9px;
                margin-bottom: 0;
            }
            .d-flex{
                display: flex !important;
            }
            .d-flex .form-group{
                width: 100% !important;
            }
            .checker input[type=checkbox], .choice input[type=radio]{
                opacity: 1;
            }
            .category-section{
                padding: 30px 70px 30px 120px !important
            }
            .branch-btn{
                margin-bottom: 20px;
                margin-right: 150px;
            }
            .text-danger, .text-danger:hover, .text-danger:focus{
                font-size: 10px;
            }
            .input-group-prepend {
                position: absolute !important;
                right: 0px !important;
                left: auto !important;
                height: 40px !important;
                z-index: 9 !important;
                line-height: 36px !important;
                color: #d5d5d5 !important;
            }
            .pin_btn{
                right: 15px;
                bottom: 15px;
                background: #404146;
                border-radius: 50%;
                border: 0;
                width: 30px;
                height: 30px;
                cursor: pointer;
                color: #fff;
            }
            .product_image_btn{
                position: absolute;
                bottom: 35px;
                left: 15px;
                background: #5dd5c4;
                border: 1px solid #5dd5c4;
                color: #fff;
                border-radius: 99px;
                padding: 3px 15px 4px;
                font-size: 12px;
                cursor: pointer;
                width: 20px;
            }
            .product_image_btn::after{
                content: "";
                display: block;
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                background: #5dd5c4;
                width: 30px;
                height: 30px;
            }
            .product_image_btn:before{
                content: "\f062";
                font-family: 'Font Awesome\ 5 Free';
                font-weight: 900;
                -webkit-font-smoothing: antialiased;
                display: inline-block;
                font-style: normal;
                font-variant: normal;
                text-rendering: auto;
                line-height: 1;
                position: absolute;
                top: 8px;
                left: 0;
                z-index: 99;
                right: 10px;
                background: #5dd5c4;
                width: 30px;
                height: 30px;
            }
            .input-group-prepend{
                position: absolute;
                right: 0px;
                height: 42px;
                z-index: 9;
                color: #d5d5d5;
            }
            /*.input-group-text{*/
            /*    background-color: transparent;*/
            /*    border: none;*/
            /*}*/
            .btn-tiffany{
                padding: 5px 8px;
                height: 36px;
                background: #5dd5c4;
                color: #fff;
                cursor: pointer;
            }
            .form-control{
                line-height: 1.6em;
            }
            select.form-control:not([size]):not([multiple]){
                height: calc(2.50rem + 2px);
            }
            .select2,.select2-selection{
                height: calc(2.50rem + 2px);
                overflow: hidden;
            }
            .select2-selection__rendered{
                display: inline-flex !important;
            }
            .icofont{
                font-size: 18px;
            }
            .down-button,.up-button{
                background: transparent;
                color: #333;
            }
            .category-section{
                background: #f3f3f3;
                padding: 30px;
                border-radius: 15px;
            }
            #product-desc-tab,#product-options-tab{
                padding: 40px 20px;
            }
            .ck-editor{
                width: 100% !important;
            }
            .input-group-addon{
                border-radius: 0;
            }
            .slim-result{
                height: 150px;
            }
            .product-photo-meta{
                padding: 0 20px;
                background: #cccccc;
            }
            .product-data-row .input-group-addon{
                /*line-height: 37px;*/
                background: #ccc;
                width: 40px;
                text-align: center;
                color: #fff;
            }
        </style>
    @endpush
    <div class="page-body" id="items" v-cloak>
        <div class="row">
            <div class="col-sm-12">
                <span class="pb-5 d-block">
                    @if(!isset($id))
                        <button type="button" v-cloak @click="addItem()" class="btn btn-tiffany px-5 py-3" style="border-radius: 25px !important;height: auto !important;margin-bottom: 20px">اضافة منتج جديد</button>
                    @endif
                </span>
                <!-- Product edit card start -->
                <div class="row">

                    <div class="col-md-3 col-sm-6 col-xs-12 product-box" v-for="form, index in forms" v-cloak>

                        <div class="product_conent">
                            <div class="card mb-4" style="padding: 2px;border-top: none">
                                <div class="thumbnail position-relative">
                                    <a v-bind:href="form.image"  data-fancybox v-bind:data-caption="form.image" v-if="form.image" ><img class="card-img-top w-100" style="height: 300px;object-fit: cover;" v-bind:src="form.image" alt="Card image cap"></a>
                                    <img class="card-img-top w-100" v-else style="height: 300px;object-fit: cover;" src="{{dashboard_url('images/placeholder.png')}}" alt="Card image cap">
                                    <button class="pin_btn position-absolute" v-on:click="changeStatus(index)" v-if="form.status == 1" type="button" title="اظهار المنتج"><span class="fa fa-bookmark"></span></button>
                                    <button class="pin_btn position-absolute" v-on:click="changeStatus(index)" style="background: #ef6c00" v-else-if="form.status == 0" type="button" title="اظهار المنتج"><span class="fa fa-bookmark"></span></button>
                                    <button class="pin_btn position-absolute" style="background: #d84315" v-else-if="form.status == 3" type="button" title="اظهار المنتج"><span class="fa fa-bookmark"></span></button>
                                    <input class="product_image_btn" type="file" ref="file" v-on:change="addFile($event,index)"/></button>
                                </div>
                                <div class="card-body py-3 px-0">
                                    <div class="container" style="width: 100%">
                                        <div class="form-group">
                                            <label class="small">مقدم الخدمه</label>
                                            <select class="form-control mb-0" v-model="form.user_id" v-on:change="getSellerCategories(index)">
                                                <option value="" selected hidden>مقدم الخدمه</option>
                                                <option v-for="seller in sellers" v-bind:value="seller.id">@{{ seller.name }}</option>
                                            </select>
                                            <ul class="nav nav-tabs md-tabs mt-2" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" style="padding: 0.2rem 0.6rem !important;" data-toggle="tab" v-bind:href="langHref('ar',index)" role="tab" aria-expanded="false">عربي</a>
                                                    <div class="slide"></div>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" style="padding: 0.2rem 0.6rem !important;" data-toggle="tab" v-bind:href="langHref('en',index)" role="tab" aria-expanded="false">انجليزي</a>
                                                    <div class="slide"></div>
                                                </li>
                                            </ul>
                                            <label class="small">الاسم</label>
                                            <div class="tab-content">
                                                <div class="tab-pane active" v-bind:id="langId('ar',index)" role="tabpanel" aria-expanded="false">
                                                    <div class="input-group mb-3" title="الاسم بالعربي">
                                                        <input type="text" class="form-control"  v-model="form.title_ar" placeholder="الاسم بالعربي">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i class="fa fa-heading"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" v-bind:id="langId('en',index)" role="tabpanel" aria-expanded="false">
                                                    <div class="input-group mb-3" title="الاسم بالانجليزي">
                                                        <input type="text" class="form-control" v-model="form.title_en" placeholder="الاسم بالانجليزي">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i class="fa fa-heading"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row p-0">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small">السعر</label>
                                                        <div class="input-group mb-3" title="السعر">
                                                            <input type="number" class="form-control" v-model="form.price" placeholder="السعر">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><i class="fa fa-dollar-sign"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small">القسم الفرعي</label>
                                                        <select class="form-control" v-model="form.subcategory_id">
                                                            <option value="" selected hidden>قسم فرعي</option>
                                                            <option v-for="child in form.subcategories" v-bind:value="child.id">@{{ child.title.ar }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" @click="save(index)" class="btn btn-tiffany btn-xs save-product btn-save px-5" style="opacity: 1;">حفظ</button>

                                        <span class="nav-item dropdown" style="float: left;">
                                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-angle-down fa-2x"></i></a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="javascript:void(0)" v-on:click="delItem(index)">حذف</a>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <template  v-cloak>
                    <div class="d-block">
                        @if(\Illuminate\Support\Facades\Route::currentRouteName() =='admin.services.create')
                            {!! $services->render("pagination::bootstrap-4") !!}
                        @endif
                    </div>
                </template>

            </div>
            <!-- Product edit card end -->
        </div>
    </div>
    @push('js')
        <script src="{{dashboard_url('dashboard/js/vue.js')}}"></script>
        <script src="{{dashboard_url('dashboard/js/axios.min.js')}}"></script>
        <script>
            Vue.component('v-select',{
                template: `<select class="form-control select2" data-allow-clear=true multiple><slot></slot></select>`,
                props:['value'],
                mounted: function () {
                    var vm = this
                    var arr = [];
                    $(this.$el)
                        // init select2
                        .select2()
                        .val(this.value)
                        // emit event on change.
                        .on('change', function (ev, args) {
                            if (!(args && "ignore" in args)) {
                                vm.$emit('input', $(this).val())
                            }
                        });
                },
                watch: {
                    value: function (value, oldValue) {
                        // update value
                        $(this.$el)
                            .val(value)
                            .trigger('change', { ignore: false });
                    },
                    options: function (options) {
                        // update options
                        $(this.$el).select2({ data: options })
                    }
                },
                destroyed: function () {
                    $(this.$el).off().select2('destroy')
                }
            });
            Vue.component('v-textarea',{
                template: `<textarea class="form-control editor" name="content" id="editor" :value="value"
         v-on:input="updateValue($event.target.value)" cols="30" rows="2"><slot></slot></textarea>`,
                data: function () {
                    return {
                        instance: null
                    }
                },
                props: ['value'],
                mounted(){
                    var vm = this;
                    ClassicEditor
                        .create( document.querySelector('.editor'), {
                            // The language code is defined in the https://en.wikipedia.org/wiki/ISO_639-1 standard.

                            language: `{{app()->getLocale()}}`,
                        } )
                        .then( editor => {
                            this.instance = editor;
                            editor.model.document.on( 'change:data', () => {
                                vm.$emit('input',editor.getData())
                            });
                        })
                        .catch( error => {
                            console.error( error );
                        } );
                },
                watch: {
                    value: function(){
                        let html = this.instance.getData();
                        if(html != this.value){
                            this.instance.setData(this.value)
                        }
                    }
                }
            });

            let items = new Vue({
                el: `#items`,
                data:{
                    sellers:[
                            @foreach($sellers as $key => $seller)
                        {
                            id: `{{$seller['id']}}`,
                            name: `{{$seller['name']}}`,
                        },
                        @endforeach
                    ],
                    subcategories:[],
                    details:0,
                    file:'',
                    forms:[
                            @if(count($services) > 0)
                            @foreach($services as $service)
                            <?php
                            $sub_category_id = $service->sub_category_id;
                            ?>
                        {
                            id:`{{$service['id'] ? $service['id'] : null}}`,
                            title_ar:`{{$service->getTranslations('title')['ar'] ?? ''}}`,
                            title_en:`{{$service->getTranslations('title')['en'] ?? ''}}`,
                            image:`{{$service->image}}`,
                            price:`{{$service['price'] ?? 0}}`,
                            user_id:`{{$service['user_id']}}`,
                            category_id:`{{$service->user->category_id}}`,
                            categories:[

                                    @foreach($categories as $category)
                                {
                                    id: `{{$category['id']}}`,
                                    title: {
                                        'ar' : `{{$category->getTranslations('title')['ar']}}`,
                                        'en' : `{{$category->getTranslations('title')['en']}}`,
                                    },
                                },
                                @endforeach
                            ],
                            subcategory_id:`{{$service->user->whereHas('services',function ($service) use ($sub_category_id) { return $service->where('sub_category_id',$sub_category_id); })->exists() == true ?  $service->sub_category_id : null}}`,
                            subcategories:[
                                    @if($service->user)
                                    @if(count($service->user->categories) > 0)
                                    @foreach($service->user->categories as $category)
                                {
                                    id: `{{$category['id']}}`,
                                    title: {
                                        'ar' : `{{$category->getTranslations('title')['ar']}}`,
                                        'en' : `{{$category->getTranslations('title')['en']}}`,
                                    },
                                },
                                @endforeach
                                @endif
                                @endif

                            ],
                            files: [
                                {
                                    id: `{{$service['id']}}`,
                                    image:`{{$service['image']}}`,
                                },
                            ],
                            errors: [],
                        },
                            @endforeach
                            @else
                        {
                            id:null,
                            title_ar:'',
                            title_en:'',
                            price:0,
                            category_id:'',
                            subcategory_id:'',
                            subcategories:[],
                            user_id:'',
                            files:[],
                            selected:0,
                            status:0,
                            image:'',
                            errors: [],
                        },
                        @endif
                    ],
                },
                methods:{
                    addItem(){
                        this.forms.unshift({
                            id:null,
                            title_ar:'',
                            title_en:'',
                            price:0,
                            category_id:'',
                            subcategory_id:'',
                            subcategories:[],
                            user_id:'',
                            files:[],
                            selected:0,
                            status:0,
                            image:'',
                            errors: [],
                        });
                        $('.dropdown-toggle').dropdown();
                    },
                    addImages(index){
                        if (this.forms[index].id != null){
                            this.details = index;
                            this.forms[index].files.filter((value,fileindex)=>{
                                value.id == this.forms[index].selected;
                            });
                            $('.modal_product_files').modal('toggle')
                        }else{
                            toastr.error(`يرجي حفظ المنتج قبل الاستكمال`)
                        }
                    },
                    addFile(event,index){
                        var that = this;
                        that.details = index;
                        const formData = new FormData();
                        formData.append('file', event.target.files[0]);
                        formData.append('id',that.forms[index].id)
                        axios.post('/admin/services/files',formData,{
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }).then(response => {
                            console.log(response.data);
                            that.forms[index].image = response.data.image;
                        }).catch((thrown) => {
                            if (axios.isCancel(thrown)) {
                                // file
                            } else {
                                // handle error
                            }
                        });
                    },
                    changeStatus(index){
                        if (this.forms[index].id != null){
                            var that = this;
                            axios.post(`/admin/items/changeStatus`,{id: this.forms[index].id}).then((res)=> {
                                that.forms[index].status = res.data;
                            });
                        }else{
                            toastr.error(`يرجي حفظ المنتج قبل الاستكمال`)
                        }
                    },
                    getSellerCategories(index){
                        if(this.forms[index].user_id == ''){
                            this.forms[index].subcategories = [];
                            this.forms[index].category_id = '';
                            return;
                        }
                        axios.post(`{{route('admin.services.SellerCategories')}}`,{id: this.forms[index].user_id}).then((res)=>{
                            this.forms[index].subcategories = res.data.categories;
                            this.forms[index].category_id = '';
                        });
                    },
                    fileMainChange(i,index){
                        axios.post(`{{route('admin.services.changeMain')}}`,{id: this.forms[index].files[i].id}).then((res)=>{
                            this.forms[index].image = res.data;
                        })

                    },
                    delImage(i,index){
                        axios.post(`/admin/delimage`,{id: this.forms[index].files[i].id}).then((res)=>{
                            var that = this;
                            if(res.data == true){
                                if(this.forms[index].files[i].image == this.forms[index].image){
                                    that.forms[index].image = '';
                                }
                                that.$delete(this.forms[index].files,i)
                                toastr.success(`تم الحذف بنجاح`);

                            }
                        })

                    },
                    delItem(index){
                        if (this.forms[index].id != null){
                            axios.post(`{{route('admin.services.delete')}}`,{id:this.forms[index].id}).then((res)=>{
                                if(res.data == true){
                                    toastr.success(`تم الحذف بنجاح`,
                                        {
                                            onHidden: function () {
                                                this.$delete(this.forms,index)
                                            }
                                        });
                                }
                            })
                        }else{
                            this.$delete(this.forms,index)
                        }

                    },
                    langHref(lang,index){
                        return `#${lang}${index}`;
                    },
                    langId(lang,index){
                        return `${lang}${index}`;
                    },
                    modelHref(index){
                        return `.modal_product_feature${index}`
                    },
                    dropdownMenuHref(index){
                        return `modal_product_feature${index}`
                    },
                    dropdownMenuRoute(index){
                        return `.modal_product_feature${index}`
                    },
                    save(index){
                        this.checkForm(index);
                        let check = '';
                        check = this.forms[index].price >= 0 && this.forms[index].user_id != '' && this.forms[index].title_ar != '' && this.forms[index].title_en != '' && ((this.forms[index].subcategories.length > 0 && this.forms[index].subcategory_id != null) || (this.forms[index].subcategories.length == 0 && this.forms[index].subcategory_id == ''));
                        if (check){
                            axios.post(`{{route('admin.services.store')}}`,this.forms[index]).then((res)=>{
                                if(this.forms[index].id == null){
                                    this.forms[index].id = res.data.id;
                                }
                                this.forms[index].status = res.data.status;
                                toastr.success(`تم الحفظ بنجاح`);
                            })
                        }
                    },
                    checkForm: function (index) {
                        if (!this.forms[index].title_ar) {
                            toastr.error(`الاسم مطلوب`);
                        }
                        if (this.forms[index].price === null || this.forms[index].price === '') {
                            toastr.error(`السعر مطلوب`);
                        }
                        if(this.forms[index].subcategories.length > 0){
                            if (!this.forms[index].subcategory_id) {
                                toastr.error(`القسم الفرعي مطلوب`);
                            }
                        }

                        if (!this.forms[index].user_id) {
                            toastr.error(`البائع مطلوب`);
                        }
                    },
                    checkDetailsForm: function (index) {
                        if (!this.forms[index].description_ar) {
                            toastr.error(`الوصف مطلوب بالعربي`);
                        }
                        if (!this.forms[index].description_en) {
                            toastr.error(`الوصف مطلوب بالانجليزي`);
                        }
                    },
                    checkDetailsGroup: function (index,groupIndex) {
                        if (!this.forms[index].groups[groupIndex].count) {
                            toastr.error(`الكميه مطلوبه`);
                        }
                        if (!this.forms[index].groups[groupIndex].price) {
                            toastr.error(`السعر مطلوب`);
                        }
                        if (!this.forms[index].groups[groupIndex].image_id) {
                            toastr.error(`الصوره مطلوبه`);
                        }
                    }
                },
                mounted(){

                    $('.dropdown-toggle').dropdown();
                    const inputElement = document.querySelector('input[class="filepond"]');
                    const pond = FilePond.create( inputElement );
                    var tokenElement = document.head.querySelector('meta[name="csrf-token"]');
                    var token;


                    FilePond.setOptions({
                        server: {
                            // process:(fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                            process: (fieldName, file, metadata, load, error, progress, abort) => {

                                // set data
                                const formData = new FormData();
                                formData.append(fieldName, file, file.name);
                                formData.append('id',this.forms[this.details].id)

                                // related to aborting the request
                                const CancelToken = axios.CancelToken;
                                const source = CancelToken.source();

                                // the request itself
                                axios({
                                    method: 'post',
                                    url: '/admin/services/files',
                                    data: formData,
                                    cancelToken: source.token,
                                    onUploadProgress: (e) => {

                                        progress(e.lengthComputable, e.loaded, e.total);
                                    }
                                }).then(response => {
                                    // passing the file id to FilePond
                                    this.forms[this.details].image = value.image;
                                    load(response.data.id)
                                }).catch((thrown) => {
                                    if (axios.isCancel(thrown)) {
                                        console.log('Request canceled', thrown.message);
                                    } else {
                                        // handle error
                                    }
                                });

                                // Setup abort interface
                                return {
                                    abort: () => {
                                        source.cancel('Operation canceled by the user.');
                                    }
                                };
                            }
                        }
                    })
                }
            });
        </script>
        <style>
            .dropdown-toggle::after{
                content: none !important;
            }
        </style>
    @endpush
@endsection

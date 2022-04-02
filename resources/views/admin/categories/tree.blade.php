@extends('admin.layout.master')
@section('content')
@push('css')

    <link rel="stylesheet" href="{{dashboard_url('dashboard/css/style.min.css')}}">
    <style>
        .jstree-default.jstree-rtl .jstree-node{
            margin-left: 0;
        }
        .d-block{
            display: block !important;
        }
    </style>
@endpush
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 ">
                <div class="page-header callout-primary d-flex justify-content-between">
                    <h2>الأقسام</h2>
                    <a href="{{route('admin.categories.index')}}" class="btn btn-primary btn-wide waves-effect waves-light add">
                        <i class="fas fa-plus"></i> اضافه قسم رئيسي
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card page-body">
    <div id="tree" style="margin-top: 20px"></div>

    <!-- Add model  -->
    <div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> اضافه جديد : <span class="userName"></span></h5>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.categories.store')}}" method="post">

                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-sm-12" style="margin-top: 10px">
                                <label>الإسم باللغة العربية</label>
                                <input required type="text" name="name_ar" class="form-control">
                            </div>
                            <div class="col-sm-12" style="margin-top: 10px">
                                <label>الإسم باللغة الإنجليزية</label>
                                <input required type="text" name="name_en" class="form-control">
                            </div>
                            <div class="col-sm-12" style="margin-top: 10px">
                                <button type="submit" class="btn btn-primary">اضافه</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">أغلاق</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
        <div class="modal fade" id="Modal">
            <div class="modal-dialog" role="document" style="max-width: 900px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="modal_form" v-on:submit.prevent="save" class="j-forms">
                            <div class="content">
                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <label class="control-label text-right mb-3">الاسم بالعربي</label>
                                        <input type="text" v-model="form.ar_title" name="ar_title" class="form-control" placeholder="الاسم بالعربي">
                                        <div v-if="errors.name_ar" class="col-form-label text-danger">@{{errors.name_ar[0]}}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="control-label text-right mb-3">الاسم بالانجليزي</label>
                                        <input type="text" v-model="form.en_title" name="en_title" class="form-control" placeholder="الاسم بالانجليزي">
                                        <div v-if="errors.name_en" class="col-form-label text-danger">@{{errors.name_en[0]}}</div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div v-bind:class="[{ 'd-block': isActive }]" class="col-md-6" style="display: none">
                                        <label for="" class="control-label mb-3 text-right">القسم الرئيسي</label>
                                        <select name="type" v-model="form.category" class="form-control">
                                            <template v-for="category in categories">
                                                <option v-bind:key="category.id" v-bind:value="category.id">@{{ category.title }}</option>
                                            </template>
                                        </select>
                                        <div v-if="errors.category_id" class="col-form-label text-danger">@{{errors.category_id[0]}}</div>
                                    </div>
                                    <div v-bind:class="[{ 'col-md-12': !isActive },{ 'col-md-6': isActive }]">
                                        <label for="" class="control-label mb-3 text-right">العموله</label>
                                        <input type="number" v-model="form.commission" class="form-control">
                                        <div v-if="errors.commission" class="col-form-label text-danger">@{{errors.commission[0]}}</div>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="" class="control-label mb-3 text-right">الصوره</label>
                                        <input type="file" v-on:change="selectFile" class="form-control" ref="fileInput" style="margin-bottom: 10px">
                                        <img v-bind:src="form.getimage" v-if="form.getimage != ''" style="width: 150px;display: block;margin: 0 auto" alt="">
                                        <div v-if="errors.image" id="img" class="col-form-label text-danger">@{{errors.image[0]}}</div>
                                    </div>
                                </div>
                                <br>
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary btn-outline-primary m-b-0 addcat">
                                        حفظ
                                        &nbsp; <i class="spinner-ajax fa fa-spinner fa-spin" style="display: none"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

@endsection

@push('js')

    <script src="{{dashboard_url('dashboard/js/vue.js')}}"></script>
    <script src="{{dashboard_url('dashboard/js/axios.min.js')}}"></script>
    <script src="{{dashboard_url('dashboard/js/alertify.min.js')}}"></script>
    <script src="{{dashboard_url('dashboard/js/jstree.min.js')}}"></script>

    <script>
        let store = '{{route('admin.categories.store')}}';
        let tree_details = new Vue ({
            el:"#Modal",
            data:{
                categories: [
                        @foreach($categories as $key => $type)
                    {
                        id: `{{$type['id']}}`,
                        title: `{{$type['title_ar']}}`,
                    },
                    @endforeach
                ],
                form:{
                    category: "",
                    type: "",
                    id: null,
                    ar_title:'',
                    en_title:'',
                    parent:'',
                    image:'',
                    commission: 0,
                    getimage: '',
                },
                errors: {},
                isActive: true,
            },
            methods:{
                selectFile(event) {
                    this.form.image = event.target.files[0];
                    this.loadPicture(event.target.files[0])
                },
                loadPicture(file) {
                    let self = this;
                    let img = document.getElementById('img');
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        self.form.getimage = e.target.result;
                    }
                    reader.readAsDataURL(file);
                },
                save(){
                    if (this.form.type == 'new' || this.form.type == 'add'){
                        tree_details.isActive = false;
                        const data = new FormData();
                        data.append('id', this.form.id);
                        data.append('image', this.form.image);
                        data.append('commission', this.form.commission);
                        data.append('name_ar', this.form.ar_title);
                        data.append('name_en', this.form.en_title);
                        data.append('category_id', this.form.category);
                        data.append('parent_id', this.form.id);
                        data.append('type', this.form.type);
                        $('.addcat').prop('disabled', true).css({opacity: '0.5'});
                        $('.spinner-ajax').css({display: 'inline-block'});
                        return axios.post(store,data).then((data)=>{
                            $('#tree').jstree(true).settings.core.data.push(data.data);
                            $('#Modal').modal('toggle');
                            toastr.success('تم الحفظ بنجاح');
                            $('#tree').jstree(true).refresh();
                            $('.addcat').removeAttr("disabled").css({opacity: '1'});
                            $('.spinner-ajax').css({display: 'none'});
                        }).catch((error)=>{
                            tree_details.isActive = true;
                            $('.addcat').removeAttr("disabled").css({opacity: '1'});
                            $('.spinner-ajax').css({display: 'none'});
                            $('.model').model('hide');
                            this.errors = error.response.data.errors;
                        })
                    }
                    if (this.form.type == 'edit'){
                        const data = new FormData();
                        data.append('id', this.form.id);
                        data.append('image', this.form.image);
                        data.append('commission', this.form.commission);
                        data.append('name_ar', this.form.ar_title);
                        data.append('name_en', this.form.en_title);
                        this.form.category != '' || this.form.category != null ? data.append('category_id', this.form.category) : null;
                        $('.addcat').prop('disabled', true).css({opacity: '0.5'});
                        $('.spinner-ajax').css({display: 'inline-block'});
                        return axios.post(`{{route('admin.categories.store')}}`,data).then((data)=>{
                            var valObj = $('#tree').jstree(true).settings.core.data.filter(function(elem){
                                if(elem.id === data.data.id){
                                    elem.text = data.data.text;
                                };
                            });
                            $('#Modal').modal('toggle');
                            toastr.success('تم التعديل بنجاح');
                            $('#tree').jstree(true).refresh();
                            $('.addcat').removeAttr("disabled").css({opacity: '1'});
                            $('.spinner-ajax').css({display: 'none'});
                        }).catch((error)=>{
                            this.errors = error.response.data.errors;
                            $('.addcat').removeAttr("disabled").css({opacity: '1'});
                            $('.spinner-ajax').css({display: 'none'});
                        })
                    }
                },
                getid(id,type){
                    this.reset();
                    this.form.id = id;
                    this.form.type = type;
                    this.form.parent = id;
                    if(type == 'edit'){
                        return axios.get(`subcategories/getdetails/${id}`).then((res)=>{
                            this.form.commission = res.data.commission;
                            this.form.ar_title = res.data.name_ar;
                            this.form.en_title = res.data.name_en;
                            this.form.category = res.data.category_id;
                            this.form.getimage = '/assets/uploads/subcategories/'+res.data.image;
                            this.form.parent = res.data.parent_id;
                            if(this.form.category != null){
                                this.isActive = true;
                            }else{
                                this.isActive = false;
                            }
                        })
                    }
                },
                reset(){
                    const input = this.$refs.fileInput
                    input.type = 'text'
                    input.type = 'file'
                    this.form.id = "";
                    this.form.type = "";
                    this.form.category = "";
                    this.form.ar_title = "";
                    this.form.en_title = "";
                    this.form.parent = "";
                    this.form.image = "";
                    this.form.getimage = "";
                    this.errors = {};
                }
            },
            mounted(){

            }
        })
    </script>

    <script>

        $(document).ready(function () {
            let new_data = $('#tree').jstree({
                "core" : {
                    'data' : {!! load_dep('parent_id') !!},
                    "multiple" : false,
                    "themes":{
                        "icons":true,
                        "variant":false,
                        "ellipsis":false,
                        "stripes":false,
                        "dots":true,
                        "dir":false,
                    },
                    'check_callback' : true,
                },
                'plugins' : ["ui","dnd"],
            });
            $('#tree').on('loaded.jstree', function() {
                $('#tree').jstree('open_all');
            });
            $('#tree').on("changed.jstree", function (e, data) {
                var i, j, r = [];
                var name = [];
                for (i=0,j=data.selected.length;i < j;i++){
                    r.push(data.instance.get_node(data.selected[i]).id);
                    name.push(data.instance.get_node(data.selected[i]).text);
                }
                $('#modal-delete').attr('action','{{url('categories/')}}/'+r.join(', '));
                if(r.join(', ') != ''){
                    $('.showbtn_control').removeClass('hidden');
                    $('.edit_dep').attr('href','{{url('categories/')}}/'+r.join(', '));
                }else{
                    $('.showbtn_control').addClass('hidden');
                }
            });

            $('body').on('click','.jstree-anchor',function () {
                // $('#tree').jstree(true).refresh();
                $('.btn-group').remove();
                var id = $(this).parent('li').attr('id');
                if ($(this).parent('li').hasClass('jstree-leaf')) {
                    // var html = `
                    // <div class="d-inline btn-group">
                    // <button type="button" data-id="${id}" data-type="new" data-toggle="modal" data-target="#Modal" class="btn btn-primary add" style="padding: 5px 14px;"><i class="fa fa-plus"></i></button>
                    // <button type="button" id="edit" data-id="${id}" data-type="edit" data-toggle="modal" data-target="#Modal" class="btn btn-success" style="padding: 5px 14px;"><i class="fas fa-pencil-alt"></i></button>
                    // <button type="button" data-id="${id}" data-type="delete" class="btn btn-danger delete" style="padding: 5px 14px;"><i class="fa fa-trash"></i></button></div>`;
                    // $(this).after(html)
                }else{
                    // var html = `
                    // <div class="d-inline btn-group">
                    // <button type="button" data-id="${id}" data-type="new" data-toggle="modal" data-target="#Modal" class="btn btn-primary add" style="padding: 5px 14px;"><i class="fa fa-plus"></i></button>
                    // <button type="button" id="edit" data-id="${id}" data-type="edit" data-toggle="modal" data-target="#Modal" class="btn btn-success" style="padding: 5px 14px;"><i class="fas fa-pencil-alt"></i></button>`;
                    // $(this).after(html)
                }
            });
        });
        $('body').on('click','#edit',function () {
            var id = $(this).data('id');
            var type = $(this).data('type');
            $('#Modal').find('#ModalLabel').text('تعديل');
            tree_details.getid(id,'edit');
        });
        $('body').on('click','.add',function () {
            var id = $(this).data('id');
            var type = $(this).data('type');
            $('#Modal').find('#ModalLabel').text('حفظ');
            console.log(type);
            if (type == 'new'){
                tree_details.isActive = false;
                tree_details.getid(id,'new');
            }else{
                tree_details.isActive = true;
                tree_details.getid(id,'add');
            }
        });
        $('body').on('click','.delete',function () {
            var id = $(this).data('id');
            var type = $(this).data('type');

            alertify.confirm("هل أنت متأكد من عملية الحذف؟", "حذف", function() {

                $.ajax({
                    url: `{{url('subcategories/')}}`+id,
                    type: 'post',
                    dataType:'json',
                    data:{id: id},
                    success(res){
                        if (res === true){
                            location.reload();
                        }
                    }
                })
            }, function() {
                alertify.error('الغاء')
            });
        });
    </script>
@endpush


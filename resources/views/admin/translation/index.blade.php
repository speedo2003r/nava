@extends('admin.layout.master')
@section('content')
    @push('css')
        <style>
            [v-cloak] {
                display: none;
            }
        </style>
    @endpush


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body" id="translate_table">
                    <div class="row">
                        <div class="col-md-8">
                            <ul class="nav nav-tabs md-tabs" role="tablist">
                                @foreach($langs as $key => $lang)
                                    <li class="nav-item">
                                        <a class="nav-link @if ($loop->first) active @endif" data-toggle="tab" href="#{{ $lang }}" v-on:click="getDetails('{!! $key !!}')" role="tab" aria-expanded="false">{{ $lang }}</a>
                                        <div class="slide"></div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <select name="filtergroup" v-model="filtergroup" v-on:change="getdatagroup" class="form-control d-block my-3 mx-auto" style="width: 200px">
                        <option v-for="file in files" v-bind:value="file.name">@{{file.name}}</option>
                    </select>
                    <div class="tab-content card-block">
                        @foreach($langs as $key => $lang)
                            <div class="tab-pane @if ($loop->first) active @endif" id="{{ $lang }}" role="tabpanel" aria-expanded="false">
                                <div id="example_wrapper_{{ $lang }}" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                    <table class="table table-striped table-bordered dt-responsive nowrap">
                                        <tr>
                                            <th>الكلمه</th>
                                            <th>الترجمه</th>
                                        </tr>
                                        <tr v-for="translate, key in alltranslation" v-cloak>
                                            <td>@{{ key }}</td>
                                            <td>
                                                <input class="form-control" v-model="alltranslation[key]" v-on:blur="transInput(key)" type="text">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script src="{{dashboard_url('dashboard/js/vue.js')}}"></script>
        <script src="{{dashboard_url('dashboard/js/axios.min.js')}}"></script>
        <script>
            let translate_table = new Vue({
                el: `#translate_table`,
                data: {
                    alltranslation : [],
                    lang : '',
                    filtergroup : '',
                    files:[
                        @foreach($files as $file)
                        {
                            name: `{{$file}}`
                        },
                        @endforeach
                    ]
                },
                methods:{
                    getDetails(lang){
                        this.alltranslation = [];
                        var filtergroup = this.filtergroup;
                        axios.post(`{{route('admin.trans.getLangDetails')}}`,{lang: lang,group:filtergroup}).then((res) => {
                            this.alltranslation = res.data;
                            this.lang = lang;
                        });
                    },
                    getdatagroup(){
                        this.alltranslation = [];
                        var filtergroup = this.filtergroup;
                        axios.post(`{{route('admin.trans.getLangDetails')}}`,{lang: this.lang,group:filtergroup}).then((res) => {
                            this.alltranslation = res.data;
                            this.lang = this.lang;
                        });
                    },
                    transInput(key){
                        axios.post(`{{route('admin.trans.transInput')}}`,{id: key,text: this.alltranslation[key],group: this.filtergroup,lang: this.lang});
                    },

                },
                mounted(){
                    this.lang = 'ar';
                    this.filtergroup = this.files[0].name;
                    this.getDetails('ar');
                }
            });
        </script>

    @endpush
@endsection
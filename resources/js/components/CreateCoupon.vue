<template>
    <div class="row" >
        <div class="nav-tabs-custom nav-tabs-lang-inputs w-100">
            <div class="tab-content">
                <div class="tab-pane" :id="'locale-tab-'+language" v-for="language in languages" :key="'tab-'+language">
                    <div class="form-group col-md-12">
                        <label :for="language+'[title]'">{{title_label}}</label>
                        <input class="form-control" type="text" :id="language+'[title]'" :name="language+'[title]'" v-model="translations[language]['title']">
                    </div>
                    <div class="form-group col-md-12">
                        <label :for="language+'[content]'">{{content_label}}</label>
                        <textarea class="form-control" :name="language+'[content]'" :id="language+'[content]'" rows="7" v-model="translations[language].content"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group col-md-4">
            <label for="code">{{code_label}}</label>
            <div class="input-group">
                <input type="text" name="code" id="code" v-model="coupon.code" class="form-control" >
                <div class="input-group-btn">
                    <button @click="autoGenerate(5)" type="button" class="btn btn-danger" >{{generate_label}}</button>
                </div>
            </div>
        </div>
        <div class="form-group col-md-4">
            <label for="amount">{{amount_label}}</label>
            <div class="input-group">
                <input type="text" name="amount" id="amount" v-model="coupon.amount" class="form-control">
                <div class="input-group-btn">
                    <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" >
                        {{type == 'fixed' ? currency_label : '%'}}
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="javascript:void(0)" @click="type = 'percentage'">%</a></li>
                        <li><a href="javascript:void(0)" @click="type = 'fixed'">{{currency_label}}</a></li>
                    </ul>
                </div>
            </div>
            <input type="hidden" name="type" id="type" v-model="type">
        </div>
        <div class="form-group col-md-4">
            <label for="max_use">{{max_use_label}}</label>
            <input type="text" name="max_use" id="max_use" v-model="coupon.max_use" class="form-control" >
        </div>
        <div class="form-group col-md-6">
            <label for="expiry_date">{{expiration_label}}</label>
            <input type="date" name="expiry_date" v-model="coupon.expiry_date" id="expiry_date" class="form-control">
        </div>
        <div class="form-group col-md-6">
            <label for="target">{{targets_label}}</label>
            <div class="input-group">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-info" :class="{active: target == 'all'}" @click="target = 'all'">{{all_users_label}}</button>
                    <button type="button" class="btn btn-info" :class="{active: target == 'branch'}" @click="target = 'branch'">{{branch_label}}</button>
                    <button type="button" class="btn btn-info" :class="{active: target == 'admin'}" @click="target = 'admin'">{{admin_label}}</button>
                </div>
            </div>
            <input type="hidden" name="target" v-model="target">
            <select-branch name="branch_id" :selectable="branches" label="Branch" :value2="coupon.branch" v-if="target == 'branch'"></select-branch>
            <single-select name="admin_id" :selectable="admins" label="Manager" :value="coupon.admin" v-if="target == 'admin'"></single-select>
        </div>

        <div class="form-group col-md-2">
            <label for="rate_from">{{rate_label}}</label>
            <div class="input-group">
                <input type="text" name="rate_from" id="rate_from" v-model="coupon.rate_from" class="form-control" :placeholder="from_label" >
                <input type="text" name="rate_to" id="rate_to" v-model="coupon.rate_to" class="form-control" :placeholder="to_label">
            </div>
        </div>

        <div class="form-group col-md-2">
            <label for="rate_from">{{requests_label}}</label>
            <div class="input-group">
                <input type="text" name="requests_from" id="requests_from" v-model="coupon.requests_from" class="form-control" :placeholder="from_label">
                <input type="text" name="requests_to" id="requests_to" v-model="coupon.requests_to" class="form-control" :placeholder="to_label">
            </div>
        </div>

        <div class="form-group col-md-2">
            <label for="rate_from">{{amount_label}}</label>
            <div class="input-group">
                <input type="text" name="price_from" id="price_from" v-model="coupon.price_from" class="form-control" :placeholder="from_label">
                <input type="text" name="price_to" id="price_to" v-model="coupon.price_to" class="form-control" :placeholder="to_label">
                
            </div>
        </div>
        <div class="form-group col-auto">
            <label for="rate_from">&nbsp</label>
            <div class="input-group">
                <span class="input-group-btn">
                    <button type="list_users" class="btn btn-dark" name="list_users" value="1" id="list_users">{{show_clients_label}}</button>
                </span>
            </div>
        </div>
        <div class="form-group col-md-3">
            <label for="rate_from">{{upload_clients_label}}</label>
            <div class="custom-file mt-1">
                <input type="file" name="users_file" class="custom-file-input" id="customFile" accept=".xls,.xlsx">
                <label class="custom-file-label" for="customFile">Choose file</label>
            </div>
        </div>
        
    </div>
</template>

<script>
    export default {
        name: "create-coupon",
        data() {
            return {
                type: 'percentage',
                target: null,
                coupon: {
                    code: ''
                },
                languages: {},
                translations: {
                    //languages must exist for the binding
                    ar:{},
                    en:{}
                },
            }
        },
        props: [
            'branches',
            'admins',
            'old',
            'coupon_model',
            'available_languages',
            'coupon_translations',

            //fields translations
            'title_label',
            'content_label',
            'code_label',
            'generate_label',
            'amount_label',
            'currency_label',
            'max_use_label',
            'expiration_label',
            'targets_label',
            'all_users_label',
            'branch_label',
            'admin_label',
            'rate_label',
            'requests_label',
            'price_label',
            'from_label',
            'to_label',
            'show_clients_label',
            'upload_clients_label',
        ],
        mounted: function() {
            this.setupLanguages();
            this.loadOldModel();
            this.loadOldInput(JSON.parse(this.old));
        },
        methods: {
            autoGenerate(length) {
               var result           = '';
               var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
               var charactersLength = characters.length;
               for ( var i = 0; i < length; i++ ) {
                  result += characters.charAt(Math.floor(Math.random() * charactersLength));
               }
               this.coupon.code = result;
            },
            loadOldInput(old){
                if(Object.keys(old).length > 0){
                    this.languages.forEach((element)=>{
                        this.translations[element] = {
                            title: old[element].title,
                            content: old[element].content,
                        }
                    });
                    this.coupon.amount = old.amount;
                    this.coupon.code = old.code;
                    this.type = old.type;
                    this.coupon.expiry_date = old.expiry_date;
                    this.coupon.branch = old.branch_id;
                    this.coupon.admin = old.admin_id;
                    this.coupon.max_use = old.max_use;
                    this.coupon.rate_from = old.rate_from;
                    this.coupon.rate_to = old.rate_to;
                    this.coupon.requests_from = old.requests_from;
                    this.coupon.requests_to = old.requests_to;
                    this.coupon.price_from = old.price_from;
                    this.coupon.price_to = old.price_to;
                    this.coupon.branch = JSON.parse(this.branches).find( ({ id }) => id == old.branch_id );
                    this.coupon.admin = JSON.stringify(JSON.parse(this.admins).find( ({ id }) => id == old.admin_id ));
                    this.target = old.target;
                }
            },
            loadOldModel(){
                let translations = JSON.parse(this.coupon_translations);
                if(this.coupon_model) {
                    this.coupon = JSON.parse(this.coupon_model);
                }
                this.languages.forEach((element)=>{
                    this.translations[element] = {
                        title: translations[element] != undefined ? translations[element]['title'] : '',
                        content: translations[element] != undefined ? translations[element]['content'] : '',
                    }
                });
                this.target = this.coupon.target_vue;
            },
            setupLanguages(){
                this.languages = Object.values(JSON.parse(this.available_languages));
            }
        }
    }
</script>

<style>
    .input-group {
        z-index: 1;
    }
</style>

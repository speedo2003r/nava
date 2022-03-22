<template>
    <div class="form-group">
        <label :for="name">{{label}}</label>
        <multiselect v-model="selected" :options="options" :searchable="true" track-by="id" label="name" :id="name"></multiselect>
        <input type="hidden" :name="name" v-model="selected.id" v-if="selected">
    </div>
</template>

<script>
    export default {
        data() {
            return {
                selected: null,
                options: []
            }
        },
        props: [
            'name',
            'selectable',
            'label',
            'value'
        ],
        mounted() {
            if(this.selectable) {
                this.options = JSON.parse(this.selectable);
                this.options.unshift({id: null, name: 'None'});
            }else{
                console.error('You must define selectable');
            }

            if(this.value) {
                this.selected = JSON.parse(this.value);
            }else{
                this.selected = this.options[0];
            }
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<template>
    <div class="form-group">
        <label :for="name">{{label}}</label>
        <multiselect v-model="selected" :options="options" :searchable="true" track-by="id" label="title" :id="name"></multiselect>
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
            'value',
            'value2'
        ],
        mounted() {
            if(this.selectable) {
                this.options = JSON.parse(this.selectable);
            }else{
                console.error('You must define selectable');
            }

            if(this.value) {
                this.selected = JSON.parse(this.value);
            }

            if(this.value2) {
                this.selected = this.value2;
            }
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

/*
 * Input-image Vue Component
 * Usage: <image-input src="..."></image-input>
 * Set src attribute with image url only if you
 * want to show uploaded image or default image
 */

<template>
    <div class="form-group">
        <div class="image-preview" v-if="image">
            <img :src="image">
        </div>
        <label for="image" class="btn" :class="{'btn-primary': !image, 'btn-danger': image}">
            {{(image) ? 'Change image' : 'Select image'}}
            <input type="file" name="image" id="image" @change="onFileChange" class="hidden">
        </label>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                image: '',
            }
        },
        props: [
            'src'
        ],
        methods: {
            onFileChange(el) {
                let reader = new FileReader();
                let self = this;

                reader.readAsDataURL(el.target.files[0]);

                reader.onload = function (e) {
                    self.image = e.target.result;
                }
            }
        },
        mounted() {
            if(this.src) {
                this.image = this.src;
            }
        }
    }
</script>

<style lang="scss" scoped>
.image-preview {
    width: 250px;
    text-align: center;
    background: #f4f4f4;
    padding: 5px;

    img {
        max-width: 100%;
        max-height: 200px;
        height: auto;
    }
}
.btn {
    width: 250px;

    &.btn-danger {
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
}
</style>

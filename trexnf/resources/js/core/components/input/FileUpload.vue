<template>
    <div class="custom-file">
        <input type="file" class="custom-file-input" :disabled="data.disabled" :id="inputFieldId" v-on="listeners">
        <label class="custom-file-label" :for="inputFieldId">{{ data.label }}</label>
    </div>
</template>

<script>
    import {InputMixin} from './mixin/InputMixin.js';

    export default {
        name: "FileUpload",
        mixins: [InputMixin],
        methods: {
            // getFile($event){
            //     const file = $event.target.files[0];
            //     // this.value = URL.createObjectURL(file);
            //     this.fieldValue = file;
            //     this.changed();
            // },
            // changed() {
            //     this.$emit('input', this.fieldValue);
            // }
        }
    }
</script>

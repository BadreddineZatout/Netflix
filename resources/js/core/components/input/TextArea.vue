<template>

    <textarea
        :type="data.type"
        :id="inputFieldId"
        :name="name"
        :required="data.required"
        :class="'form-control ' + data.inputClass"
        :placeholder="data.placeholder"
        :readonly="data.readOnly"
        :disabled="data.disabled"
        :rows="data.textAreaRows"
        :cols="data.textAreaCols"
        :minlength="data.minlength"
        :maxlength="data.maxlength"
        :spellcheck="data.textAreaSpellCheck"
        :style="'direction:'+data.textAreaDir"
        v-bind:value="value"
        v-on="listeners">
    </textarea>

</template>

<script>
    import {InputMixin} from './mixin/InputMixin.js';

    export default {
        name: "TextArea",
        mixins: [InputMixin],
        methods: {

            // input($event) {
            //     let value = $event.target.value;
            //
            //     this.fieldValue = value;
            //
            //     this.$emit('input', value);
            // },
            // initComponent(initialValue){
            //     //:initial-value has a value,it will replace with default value
            //     this.value = initialValue ? initialValue : this.value;
            // }
        }
    };
</script>

<template>
    <!--input-->
    <input :type="data.type" :name="name" :id="inputFieldId" :required="data.required"
           :class="'form-control '+data.inputClass"
           :max="data.maxNumber"
           :min="data.minNumber"
           :placeholder="data.placeholder"
           :readonly="data.readOnly"
           :disabled="data.disabled"
           v-bind:value="value"
           v-on="listeners"
           :autocomplete="data.autocomplete"
    />
</template>
<script>
    import {InputMixin} from './mixin/InputMixin.js';

    export default {
        name: "NumberInput",
        mixins: [InputMixin],
        methods: {
            // input($event) {
            //     let value = $event.target.value;
            //     this.fieldValue = value;
            //
            //     this.$emit('input', value);
            // },
            // initComponent(initialValue){
            //     //:initial-value has a value,it will replace with default value
            //     this.fieldValue = initialValue ? initialValue : this.fieldValue;
            // }
        }
    }
</script>


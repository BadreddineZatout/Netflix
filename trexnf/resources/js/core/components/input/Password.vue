<template>
    <!--input-->
    <input :type="data.type"
           :name="name"
           :id="inputFieldId"
           :required="data.required"
           :class="'form-control '+data.inputClass"
           :placeholder="data.placeholder"
           :readonly="data.readOnly"
           :disabled="data.disabled"
           :minlength="data.minlength"
           :maxlength="data.maxlength"
           v-bind:value="value"
           v-on="listeners"
           :autocomplete="data.autocomplete"
    />
</template>

<script>
    import {InputMixin} from './mixin/InputMixin.js';

    export default {
        name: "PassWord",
        mixins: [InputMixin],
        methods: {
            // input($event) {
            //     let value = $event.target.value;
            //
            //     this.fieldValue = value;
            //
            //     this.$emit('input', value);
            // },
            // // changed() {
            // //     this.$emit('changed', this.value);
            // // },
            // initComponent(initialValue){
            //     //:initial-value has a value,it will replace with default value
            //     this.value = initialValue ? initialValue : this.value;
            // }
        }
    }
</script>

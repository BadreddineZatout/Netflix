<template>
    <span>
        <label :class="['customized-radio radio-default', data.customRadioType, data.disabled ? 'disabled' : '']"
               v-for="(item, index) in data.list"
               :key="index">
            <input class="radio-inline"
                   :type="data.type"
                   :name="name"
                   :id="name+'-'+index"
                   :required="data.required"
                   :disabled="item.disabled"
                   :checked="item.id == value"
                   :value="item.id"
                   v-on="listeners"
                   ref="radio">
            <span class="outside">
                <span class="inside"/>
            </span>
            {{ item[data.listValueField] }}
        </label>
    </span>
</template>

<script>
    import {InputMixin} from "./mixin/InputMixin.js";

    export default {
        name: "Radio",
        mixins: [InputMixin],
        methods: {

            // input(value) {
            //     //while using radio, weird thing happens in vue extension
            //     this.fieldValue = value ? value : this.fieldValue;
            //     this.$emit("input", this.fieldValue);
            // },

        }

    };
</script>


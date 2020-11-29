<template>
    <select :id="inputFieldId"
            :style="'backgroundImage: url('+downArrow()+')'"
            :disabled="data.disabled"
            ref="select"
            :class="'custom-select' + data.inputClass"
            v-bind:value="value" v-on="listeners">
        <option v-for="(item,index) in allList"
                :value="item.id"
                :disabled="item.disabled"
                :selected="item.id === value"
                :key="item.id">
            {{item[data.listValueField]}}
        </option>
    </select>
</template>

<script>
    import {InputMixin} from './mixin/InputMixin.js';
    import AppFunction from "../../helpers/app/AppFunction";

    export default {
        name: "SelectInput",
        mixins: [InputMixin],
        computed: {
            allList() {
                let instance = this;
                if (!_.isEmpty(instance.searchValue)) {
                    return instance.data.list.filter(item => {
                        return item[this.data.listValueField].toLowerCase().includes(instance.searchValue.toLowerCase());
                    });
                } else return instance.data.list;
            },
        },
        methods: {
            downArrow(){
                if (this.$store.state.theme.darkMode) {
                    return AppFunction.getAppUrl('images/chevron-down-dark.svg');
                } else {
                    return AppFunction.getAppUrl('images/chevron-down.svg');
                }
            }
            // input($event) {
            //     // this.value = this.$refs.select.value ? this.$refs.select.value
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

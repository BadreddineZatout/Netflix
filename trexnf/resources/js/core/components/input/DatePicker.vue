<template>
    <div class="date-picker-input" :class="{'date-picker-input-group':borderGroup}">
        <div class="input-group" :class="{'disabled':data.disabled}" @focusin="borderGroup=true" @focusout="borderGroup=false">
            <v-date-picker :color="data.dateColor"
                           :mode="data.dateMode"
                           :masks="{input:[dateFormat]}"
                           :min-date="data.minDate"
                           :max-date="data.maxDate"
                           :input-props='{
                                class: "form-control",
                                placeholder: data.placeholder,
                                readonly: data.readOnly,
                                disabled: data.disabled,
                           }'
                           :popover="{
                               placement: 'bottom-start',
                               visibility: 'click'
                           }"
                           :value="value"
                           popover-align="left"
                           @input="input"/>
            <div class="input-group-append">
                <span class="input-group-text">
                    <app-icon :name="'calendar'"/>
                </span>
            </div>
        </div>
    </div>
</template>

<script>
    import {InputMixin} from './mixin/InputMixin.js';
    import moment from "moment";

    export default {
        name: "DatePicker",

        mixins: [InputMixin],

        data(){
            return{
                borderGroup: false,
                // dateFormat: this.$store.state.settings.dateFormat
            }
        },
        computed:{
            dateFormat(){
                return this.$store.state.settings.dateFormat;
            }
        },
        methods: {
            input(date) {
                this.fieldValue = date;
                this.$emit('input', date);
            }
        }
    }
</script>


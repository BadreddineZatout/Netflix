<template>
    <smart-select key="smart-select-filter"
                :data="$props"
                v-model="searchAndSelect"
                @input="changed"/>
</template>

<script>
    import {FilterMixin} from './mixins/FilterMixin';
    import SmartSelect from "../input/SmartSelect";

    export default {
        name: "DropDownFilter",
        mixins: [FilterMixin],
        components: {SmartSelect},
        props: {
            id: {
                type : String,
                default : 'drop-down-filter'
            },
            list: Array,
            label: {
                type: String,
                default: ""
            },
            listValueField: {
                type: String,
                default: 'value'
            }
        },
        data() {
            return {
                searchAndSelect: null
            }
        },
        methods: {
            changed(value) {
                this.returnValue(value);
            },
        },
    }
</script>

<template>
    <div class="radio-filter single-filter">
        <div class="dropdown keep-inside-clicks-open">
            <button class="btn btn-filter"
                    :class="{'applied': isApply}"
                    type="button"
                    :id="filterId"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false">
                {{ isApply? labelAfterApply:label }}
                <span class="clear-icon" v-if="isApply" @click.prevent="clear">
                    <app-icon :name="'x'"/>
                </span>
            </button>
            <div class="dropdown-menu" :aria-labelledby="filterId">
                <div class="btn-dropdown-close d-sm-none">
                    <span class="title">
                        {{ label }}
                    </span>
                    <span class="back float-right" @click.prevent="closeDropDown">
                        <app-icon :name="'x'"/>
                    </span>
                </div>
                <div class="dropdown-item pb-0">
                    <h6>{{ header.title }}</h6>
                    <p class="text-justify mb-0 filter-subtitle-text">
                        {{ header.description }}
                    </p>
                </div>
                <div class="dropdown-item">
                    <label class="customized-radio radio-default d-block"
                           :class="{'mb-3': (filterOption.length -1) != index, 'disabled':item.disabled}"
                           v-for="(item,index) in filterOption"
                           :key="index" @click.prevent="updateValue(item)">
                        <input class="radio-inline"
                               type="radio"
                               name="customRadio"
                               :id="'input-radio-'+item.id"
                               :disabled="item.disabled"
                               :checked="checkedValue(item.id)">
                        <span class="outside">
                            <span class="inside"/>
                        </span>
                        {{ item[listValueField] }}
                    </label>
                </div>
                <div class="dropdown-divider d-none d-sm-block"/>

                <filter-action :is-clear-disabled="isClearDisabled" @apply="applyFilter" @clear="clear"/>
            </div>
        </div>
    </div>
</template>

<script>
    import {FilterMixin} from './mixins/FilterMixin';
    import CoreLibrary from "../../helpers/CoreLibrary";
    import FilterAction from "./FilterAction";

    export default {
        name: "RadioFilter",
        mixins: [FilterMixin],
        extends: CoreLibrary,
        components: {FilterAction},
        props: {
            filterOption: {
                type: Array,
                required: true
            },
            label: {
                type: String
            },
            header: {
                type: Object
            },
            listValueField: {
                type: String,
                default: 'value'
            },
            initValue: {}
        },
        data() {
            return {
                value: '',
                labelAfterApply: this.label
            }
        },
        mounted() {
            if (this.initValue) {
                this.value = this.initValue;
                this.filterOption.forEach((option)=>{
                    if(option.id === this.value){
                        this.labelAfterApply = option[this.listValueField];
                    }
                });
                this.applyFilter();
            }
        },
        computed: {
            isClearDisabled() {
                return this.value.length < 1;
            }
        },
        methods: {
            updateValue(item) {
                this.labelAfterApply = item[this.listValueField];
                this.value = item.id;
            },
            checkedValue(v) {
                return this.value == v;
            },
            clear($event) {
                $event.stopPropagation();
                this.value = '';
                this.isApply = false;
                this.returnValue(this.value);
            },
            applyFilter() {
                if (this.value) {
                    this.isApply = true;
                }
                this.closeDropDown();
                this.returnValue(this.value);
            }
        },
    }
</script>

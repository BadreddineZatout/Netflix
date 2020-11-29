<template>
    <div class="dropdown-menu-filter mr-2">
        <div class="dropdown keep-inside-clicks-open">
            <button class="btn menu-filter-btn" type="button" :id="'dropdownMenuButton-segments-'+filterId"
                    data-toggle="dropdown">
                {{filterLabel}}
                <img :src="getAppUrl('images/chevron-down.svg')" alt="">
            </button>
            <div :class="'dropdown-menu '+filterId" :aria-labelledby="'dropdownMenuButton-segments-'+filterId">
                <div class="btn-dropdown-close d-sm-none">
                    <span class="title">
                        {{ label ? label:filterLabel }}
                    </span>
                    <span class="back float-right" @click.prevent="closeDropDown">
                        <app-icon :name="'x'"/>
                    </span>
                </div>
                <a v-for="(item,index) in list" :key="index" href="#" class="dropdown-item" :class="{'active disabled':item.id===activeClassId}"
                   @click.prevent="selectedItem(item,$event)">
                    <app-icon v-if="item.icon" :name="item.icon" class="mr-2"/>
                    {{item[listValueField]}}</a>
            </div>
        </div>
    </div>
</template>

<script>
    import {FilterMixin} from './mixins/FilterMixin';
    import CoreLibrary from "../../helpers/CoreLibrary";

    export default {
        name: "DropdownMenuFilter",
        mixins: [FilterMixin],
        extends: CoreLibrary,
        props: {
            list: {
                type: Array,
                require: true
            },
            label: {
                type: String,
                default: ""
            },
            listValueField: {
                type: String,
                default: 'value'
            },
            initValue: {}
        },
        data() {
            return {
                filterLabel: '',
                activeClassId: null,
            }
        },
        mounted() {
            if (!this.isUndefined(this.initValue)) {
                this.selectedItem(this.findItem(this.initValue));
            } else {
                this.filterLabel = this.label;
            }
        },
        watch:{
            label: function (value) {
                if (!this.isUndefined(this.initValue)) {
                    this.selectedItem(this.findItem(this.initValue));
                } else {
                    this.filterLabel = value;
                }
            }
        },
        methods: {
            selectedItem(value , e) {
                this.returnValue(value.id);
                this.activeClassId = value.id;
                this.filterLabel = value[this.listValueField];
                if(e){
                    $('.dropdown-menu-filter .'+this.filterId).toggleClass('show');
                }
            },
            findItem(index) {
                for (const item of this.list) {
                    if (item.id === index) {
                        return item
                    }
                }
            }
        }
    }
</script>

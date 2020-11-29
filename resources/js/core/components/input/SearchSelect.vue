<template>
    <div class="single-filter search-filter-dropdown">
        <div class="dropdown dropdown-with-animation" :class="{'disabled':data.disabled}">
            <div class="my-1"
                 :id="inputFieldId"
                 data-toggle="dropdown"
                 aria-haspopup="true"
                 aria-expanded="false">
                <input type="text"
                       class="form-control cursor-pointer"
                       :placeholder="data.placeholder"
                       :disabled="data.disabled"
                       @click="startNavigation"
                       v-model="showValue">
            </div>

            <div class="dropdown-menu py-0 my-1" :class="data.listClass" :aria-labelledby="inputFieldId">
                <div class="form-group form-group-with-search">
                    <span class="form-control-feedback">
                        <app-icon name="search"/>
                    </span>
                    <input type="text"
                           ref="searchInput"
                           :class="'form-control '+data.listItemInputClass"
                           :placeholder="$t('search')"
                           v-bind:value="searchValue"
                           @input="getSearchValue($event)"
                           @keydown.down="navigateDown"
                           @keydown.up="navigateUp"
                           @keydown.enter.prevent="enterSelectedValue"
                           :autofocus="startNavigation">
                </div>
                <div class="dropdown-divider my-0"/>
                <div class="dropdown-search-result-wrapper custom-scrollbar" ref="optionList">
                    <a class="dropdown-item"
                       href="#"
                       v-for="(item,index) in allList"
                       :class="{'active':index==activeIndex, [data.listItemClass]: !isUndefined(data.listItemClass),'selected':item.id === value, 'disabled':item.disabled}"
                       @click.prevent="changeSelectedValue(item)"
                       :key="`${inputFieldId}-${index}`">
                        {{item[data.listValueField]}}
                        <span class="check-sign float-right">
                            <app-icon name="check" class="menu-icon"/>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {InputMixin} from './mixin/InputMixin.js';
    import CoreLibrary from "../../helpers/CoreLibrary";
    import {FilterCloseMixin} from "../filter/mixins/FilterCloseMixin";

    export default {
        name: "SearchSelect",
        mixins: [InputMixin, FilterCloseMixin],
        extends: CoreLibrary,
        data() {
            return {
                selectedValue: '',
                searchValue: "",
                activeIndex: -1,
                navigationStart: false,
                showValue: '',
            }
        },
        mounted() {
            this.initSearchSelect(this.value);
        },
        watch: {
            showValue: function (value) {
                if (value == '') {
                    this.clear();
                }
            },
            searchSelectValue: function (value) {
                if (!value) {
                    this.showValue = '';
                }
            }
        },
        computed: {
            allList() {
                this.activeIndex = -1;
                if (!_.isEmpty(this.searchValue)) {
                    return this.data.list.filter(item => {
                        return item[this.data.listValueField].toLowerCase().includes(this.searchValue.toLowerCase());
                    });
                } else return this.data.list;
            },
            searchSelectValue() {
                return this.value;
            }
        },
        methods: {
            initSearchSelect(value) {
                let item = this.allList.filter(item => {
                    return item.id == value;
                });
                if (item.length === 1)
                    this.changeSelectedValue(item[0]);
            },
            getSearchValue($event) {
                this.searchValue = $event.target.value;
            },
            changed() {
                this.$emit('input', this.selectedValue);
            },
            changeSelectedValue(value) {
                this.selectedValue = value.id;
                this.showValue = value[this.data.listValueField];
                this.searchValue = "";
                this.navigationStart = false;
                this.changed();
            },
            startNavigation() {
                this.activeIndex = -1;
                this.navigationStart = true;
                setTimeout(() => {
                    this.$refs.searchInput.focus();
                    this.$refs.optionList.scrollTop = 0;
                }, 300);
            },
            navigateUp() {
                if (this.activeIndex >= 1) {

                    this.activeIndex--;
                    // this.selectedValue = this.allList[this.activeIndex];

                    let sH = this.$refs.optionList.scrollHeight;
                    let aH = this.$refs.optionList.offsetHeight;
                    if (sH > aH) {
                        //need to adjust scroll height
                        let adS = this.activeIndex == 0 ? 0 : this.$refs.optionList.scrollTop - (sH - aH) / (this.allList.length);
                        this.$refs.optionList.scrollTo(0, adS)
                    }
                }
            },
            navigateDown() {
                if (this.activeIndex < this.allList.length - 1 && this.activeIndex > -2) {

                    this.activeIndex++;
                    // this.selectedValue = this.allList[this.activeIndex];

                    let sH = this.$refs.optionList.scrollHeight;
                    let aH = this.$refs.optionList.offsetHeight;

                    if (sH > aH && this.activeIndex > 0) {
                        //need to adjust scroll height
                        let adS = this.activeIndex == this.allList.length - 1 ? (sH - aH) : this.$refs.optionList.scrollTop + (sH - aH) / (this.allList.length);
                        this.$refs.optionList.scrollTo(0, adS)
                    }
                }
            },
            enterSelectedValue() {
                this.allList.filter((item, index) => {
                    if (index == this.activeIndex) {
                        this.changeSelectedValue(item)
                    }
                });
                this.endNavigation();
            },
            endNavigation() {
                this.activeIndex = -1;
                this.navigationStart = false;
                $(".dropdown-menu").removeClass('show');
            },
            clear() {
                this.selectedValue = '';
                this.changed();
            }
        }
    }
</script>

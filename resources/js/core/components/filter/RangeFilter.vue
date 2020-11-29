<template>
    <div class="range-filter-dropdown single-filter">
        <div class="dropdown keep-inside-clicks-open">
            <button class="btn btn-filter"
                    :class="{'applied': isApply}"
                    :id="filterId"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false">
                {{isApply? minRange+(data.sign ? data.sign : '')+' - '+maxRange+(data.sign ? data.sign : ''):label}}
                <span class="clear-icon" v-if="isApply" @click.prevent="clear">
                    <app-icon :name="'x'"/>
                </span>
            </button>
            <div class="dropdown-menu" :aria-labelledby="filterId">
                <div class="btn-dropdown-close d-sm-none">
                    <span class="title">
                        {{label}}
                    </span>
                    <span class="back float-right" @click.prevent="closeDropDown">
                        <app-icon :name="'x'"/>
                    </span>
                </div>
                <div class="dropdown-item pt-5">
                    <div :id="'slider-'+tableId"/>
                    <div class="rate-status mt-primary d-flex justify-content-center">
                        <div class="min-rate">
                            <p class="text-center">{{data.minTitle ? data.minTitle : $t('minimum_rate')}}</p>
                            <h5 class="text-center">{{`${minRange}${data.sign ? data.sign : ''}`}}</h5>
                        </div>
                        <hr>
                        <div class="max-rate">
                            <p class="text-center">{{data.maxTitle ? data.maxTitle : $t('maximum_rate')}}</p>
                            <h5 class="text-center">{{`${maxRange}${data.sign ? data.sign : ''}`}}</h5>
                        </div>
                    </div>
                </div>
                <div class="dropdown-divider d-none d-sm-block"/>

                <filter-action :is-clear-disabled="isClearDisabled" @apply="applyFilter" @clear="clear"/>

            </div>
        </div>
    </div>

</template>

<script>
    import noUiSlider from 'nouislider/distribute/nouislider.min';
    import {FilterMixin} from './mixins/FilterMixin';
    import CoreLibrary from "../../helpers/CoreLibrary";
    import FilterAction from "./FilterAction";

    export default {
        name: "RangeFilter",
        components: {FilterAction},
        mixins: [FilterMixin],
        extends: CoreLibrary,
        props: {
            label: String,
            data: {
                type: Object,
                default: function () {
                    return {
                        maxTitle: '',
                        minTitle: '',
                        sign: '',
                        maxRange: 100,
                        minRange: 0,
                    }
                }
            }
        },
        data() {
            return {
                minRange: 0,
                maxRange: 100,
                value: {},
                filterMinRange: 0,
                filterMaxRange: 100
            }
        },
        computed: {
            isClearDisabled() {
                return this.minRange === this.filterMinRange && this.maxRange === this.filterMaxRange;
            }
        },
        methods: {
            clear($event) {
                $event.stopPropagation();
                const slider = document.getElementById('slider-'+this.tableId);
                slider.noUiSlider.reset();
                this.minRange = this.filterMinRange;
                this.maxRange = this.filterMaxRange;
                this.isApply = false;
                this.value = null;
                this.returnValue(this.value);
            },
            initRangeFilter() {
                if (!this.isUndefined(this.data.minRange)) {
                    this.minRange = this.data.minRange;
                    this.filterMinRange = this.data.minRange
                }
                if (!this.isUndefined(this.data.maxRange)) {
                    this.maxRange = this.data.maxRange;
                    this.filterMaxRange = this.data.maxRange
                }
            }
        },
        mounted() {
            let instance = this;
            instance.initRangeFilter();
            this.$nextTick(function () {
                const slider = document.getElementById('slider-'+this.tableId);
                noUiSlider.create(slider, {
                    start: [instance.minRange, instance.maxRange],
                    step: 1,
                    connect: true,
                    range: {
                        min: [instance.minRange],
                        max: [instance.maxRange]
                    },
                    // tooltips: true
                });

                slider.noUiSlider.on('change', function (value) {
                    instance.minRange = Math.round(value[0]);
                    instance.maxRange = Math.round(value[1]);
                    instance.value = {'min': instance.minRange, 'max': instance.maxRange}
                });
            });
        }
    }
</script>

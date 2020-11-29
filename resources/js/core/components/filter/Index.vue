<template>
    <div class="filters-loop-wrapper">
        <template v-for="(filter, index) in filterComputed">
            <date-range-filter v-if="filter.type === 'range-picker'" :key="'range-picker'+index"
                               :table-id="tableId"
                               :filter-key="filter.key"
                               :label="filter.title"
                               :visible-value="false"
                               :preset-ranges="filter.option"
                               @get-value="store"/>

            <range-filter v-if="filter.type === 'range-filter'"
                          :filter-key="filter.key"
                          :table-id="tableId"
                          :key="'range-filter'+index"
                          :label="filter.title"
                          :data="filter"
                          @get-value="store"/>

            <checkbox-filter :filter-key="filter.key" :key="'checkbox'+index"
                             v-if="filter.type === 'checkbox'"
                             :table-id="tableId"
                             :label="filter.title"
                             :filter-option="filter.option"
                             :list-value-field="filter.listValueField"
                             @get-value="store"/>

            <radio-filter v-if="filter.type === 'radio'"
                          :filter-key="filter.key"
                          :table-id="tableId"
                          :key="'radio'+index"
                          :label="filter.title"
                          :init-value="filter.initValue"
                          :filter-option="filter.option"
                          :list-value-field="filter.listValueField"
                          :header="filter.header"
                          @get-value="store"/>

            <drop-down-filter v-if="filter.type === 'drop-down-filter'"
                              :key="'drop-down-filter'+index"
                              :filter-key="filter.key"
                              :id="`${filter.key}-${tableId}`"
                              :table-id="tableId"
                              :list="filter.option"
                              :label="filter.title"
                              :list-value-field="filter.listValueField"
                              @get-value="store"/>

            <dropdown-menu-filter v-if="filter.type === 'dropdown-menu-filter'"
                                  :key="'dropdown-menu-filter'+index"
                                  :filter-key="filter.key"
                                  :table-id="tableId"
                                  :list="filter.option"
                                  :label="filter.title"
                                  :init-value="filter.initValue"
                                  :list-value-field="filter.listValueField"
                                  @get-value="store"/>

            <app-tab-filter v-if="filter.type === 'tab-filter'"
                            :key="'tab-filter'+index"
                            :table-id="tableId"
                            :filter-key="filter.key"
                            :filter-option="filter.option"
                            @get-value="store"/>
        </template>
    </div>
</template>


<script>
    import RangeFilter from "./RangeFilter";
    import CheckboxFilter from "./CheckboxFilter";
    import DropDownFilter from "./DropDownFilter";
    import RadioFilter from "./RadioFilter";
    import DateRangeFilter from "./DateRangeFilter";
    import coreLibrary from '../../helpers/CoreLibrary';
    import DropdownMenuFilter from "./DropdownMenuFilter";

    export default {
        name: "AppFilter",
        extends: coreLibrary,
        components: {RadioFilter, DateRangeFilter, DropDownFilter, CheckboxFilter, RangeFilter, DropdownMenuFilter},
        props: {
            tableId: String,
            filters: {
                required: true,
                type: Array,
            },
            options: {}
        },
        data() {
            return {
                filterValues: {}
            }
        },
        computed: {
            filterComputed() {
                let keys = [];
                this.filters.map(i => {
                    let k, t, v;
                    k = _.snakeCase(_.lowerCase(i.key));
                    t = _.kebabCase(_.lowerCase(i.type));
                    v = {'title': i.title, 'key': k, 'type': t};
                    if (i.option) {
                        v['option'] = i.option;
                    }
                    if (i.header) {
                        v['header'] = i.header
                    }
                    if (i.listValueField) {
                        v['listValueField'] = i.listValueField;
                    }
                    if (i.type === 'range-filter') {
                        v['maxTitle'] = i.maxTitle;
                        v['minTitle'] = i.minTitle;
                        v['sign'] = i.sign;
                        if (!this.isUndefined(i.minRange)) {
                            v['minRange'] = i.minRange;
                        }
                        if (!this.isUndefined(i.maxRange)) {
                            v['maxRange'] = i.maxRange;
                        }
                    }
                    if(i.type ==='dropdown-menu-filter' || i.type ==='radio'){
                        if(!this.isUndefined(i.initValue)){
                            v['initValue'] = i.initValue;
                        }
                    }

                    keys.push(v)
                });
                return keys;


            }
        },
        methods: {
            store(v) {
                this.filterValues[v.key] = v.value;
                this.$emit('get-values', this.filterValues);
            }
        },
    }
</script>


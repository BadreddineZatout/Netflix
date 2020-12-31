<template>
    <div>
        <div v-if="options.showFilter || isUndefined(options.showFilter)" class="d-flex justify-content-between">

            <div class="">
                <div v-if="options.showFilter || isUndefined(options.showFilter)"
                     class="filters-wrapper d-flex justify-content-start flex-wrap">

                    <manage-columns v-if="options.showManageColumn || isUndefined(options.showManageColumn)"
                                    :manage-option="columns"
                                    :init-option="initColumns"
                                    @get-columns-options="getColumnsOptions"/>

                    <!--Open Filters Button For Mobile-->
                    <button class="btn d-block d-sm-none btn-toggle-filters"
                            type="button"
                            @click.prevent="toggleFilters">
                        <app-icon :name="'filter'"/>
                        {{$t('filters')}}
                    </button>

                    <span v-if="!isUndefined(options.filters) && options.filters.length > 0" v-show="isFiltersOpen"
                          class="mobile-filters-wrapper">
                        <app-filter :table-id="id" :filters="options.filters" :options="options"
                                    @get-values="getFilterValues"/>

                        <button type="button"
                                class="btn btn-primary btn-with-shadow d-sm-none btn-close-filter-wrapper d-flex justify-content-center align-items-center"
                                @click="toggleFilters">
                            {{$t('close')}}
                        </button>
                    </span>
                    <ul v-if="options.name == 'TransactionsTable'" class="nav mt-2 tab-filter-menu justify-content-flex-end">
                        <li class="nav-item">
                            <a href="#" @click="getFilterValues('', 'etat')" class="nav-link py-0 font-size-default">all</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" @click="getFilterValues('paye', 'etat')" class="nav-link py-0 font-size-default">payé</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" @click="getFilterValues('non paye', 'etat')" class="nav-link py-0 font-size-default">non payé</a>
                        </li>
                    </ul>
                    <app-input v-if="options.name == 'TransactionsTable'"
                               id="dateFilter"
                               class="col-sm-4"
                               type="date"
                               v-model="filterValues['date']"/>
                    <button v-if="options.name == 'TransactionsTable'" type="button" class="btn btn-primary btn-with-shadow"
                            @click="getFilterValues(filterValues['date'], 'date')">
                        FILTER
                    </button>
                    <button v-if="options.name == 'TransactionsTable'" type="button" class="btn btn-primary btn-with-shadow ml-1"
                            @click="getFilterValues('', 'date')">
                        CLEAR
                    </button>
                </div>
            </div>

            <div v-if="options.showSearch || isUndefined(options.showSearch)" class="">
                <div class="mr-0 single-filter single-search-wrapper">
                    <app-search @input="getSearchValue"/>
                </div>
            </div>
        </div>

        <!-- <table-with-wrapper v-if="options.datatableWrapper || isUndefined(options.datatableWrapper)"
                            :id="id"
                            :options="options"
                            :columns="columns"
                            :filtered-data="filterForTable"
                            :search-value="searchForTable"
                            @action="getAction"
                            :key="'table-with-wrapper'+id"/> -->

        <table-without-wrapper
                               :id="id"
                               :options="options"
                               :columns="columns"
                               :filtered-data="filterForTable"
                               :search-value="searchForTable"
                               @action="getAction"
                               :key="'table-without-wrapper'+id"/>
    </div>
</template>

<script>

    import TableWithWrapper from "./TableWithWrapper";
    import ManageColumns from "./ManageColumns";
    import coreLibrary from '../../helpers/CoreLibrary';
    import TableWithoutWrapper from "./TableWithoutWrapper";


    export default {
        name: "AppTable",
        components: {TableWithWrapper, ManageColumns, TableWithoutWrapper},
        extends: coreLibrary,
        props: {
            id: {
                required: true,
                type: String,
            },
            options: {
                required: true,
                type: Object
            },
            filteredData: Object,
            search: String
        },
        data() {
            return {
                filterValues: {},
                columns: [],
                isFiltersOpen: true,
                searchValue: '',
                columnModifier: '',
            }
        },
        watch:{
            initColumns: function (data) {
                this.columns = data;
            }
        },
        created() {
            this.columns = this.preparedColumn();
        },
        mounted() {
            this.isFiltersActive();
            window.onresize = () => {
                this.isFiltersActive();
            };
            this.setRows();
        },
        computed: {
            filterForTable() {
                let condition = this.options.datatableWrapper || this.isUndefined(this.options.datatableWrapper);
                return condition ? this.filterValues : this.filteredData;
            },
            searchForTable() {
                let condition = this.options.datatableWrapper || this.isUndefined(this.options.datatableWrapper);
                return condition ? this.searchValue : this.search;
            },
            initColumns() {
                return this.preparedColumn();
            }
        },
        methods: {
            /**
             * emit from manage-columns
             * */
            getColumnsOptions(value) {
                let data = _.cloneDeep(value);
                this.columns = data;
                this.setCookies(data);
            },

            /**
             * emit from filter
             * */
            getFilterValues(values, type) {
                let event = "";
                if (type == 'etat'){
                    event = "filterEtat";
                    this.filterValues['etat'] = values;
                }
                else{
                    event = "filterDate";
                    this.filterValues['date'] = '';
                    if(values != ''){
                        let day = values.getDate().toString();
                        if (day.length==1) day = '0'+day;
                        let month = (values.getMonth()+1).toString();
                        if (month.length==1) month = '0'+month;
                        let year = values.getFullYear().toString();
                        this.filterValues['date'] = year + '-' + month + '-' + day;
                    }
                } 
                setTimeout(() => {
                    this.$hub.$emit(event);
                });
            },

            getSearchValue(value) {
                this.searchValue = value;
                setTimeout(() => {
                    this.$hub.$emit('reload-' + this.id);
                });
            },

            /**
             * for filter options
             * */
            isFiltersActive() {
                this.isFiltersOpen = window.innerWidth > 575;
            },
            toggleFilters() {
                this.isFiltersOpen = !this.isFiltersOpen;
            },

            /**
             * $emit for action
             * @param rowData
             * @param actionObj
             * @param active
             * */
            getAction(rowData, actionObj, active) {
                this.$emit("action", rowData, actionObj, active);
            },
            setRows() {
                this.$hub.$on('selectedRowsData-' + this.id, (rows) => {
                    this.$emit('getRows', rows);
                });
            },
            /**
             * set value in cookies
             * */
            setCookies(values) {
                let name = this.id + '-columns',
                    data = JSON.stringify(values);
                AppCookie.set(name, data);
            },

            /**
             * set value in cookies
             * */
            getCookies() {
                let name = this.id + '-columns',
                    data = JSON.parse(AppCookie.get(name));
                if (data) {
                    data.map((item) => {
                        if (!this.isUndefined(item.title)) {
                            item.modifier = this.getModifier(item.title);
                        }
                    });
                    this.columns = data;
                }
            },
            getModifier(title) {
                for (let index in this.initColumns) {
                    if (this.initColumns[index].title === title && !this.isUndefined(this.initColumns[index].modifier)) {
                        this.columnModifier = this.initColumns[index].modifier;
                        break;
                    }
                }
                return this.columnModifier;
            },
            preparedColumn(){
                let createdColumn = (this.options.columns);
                createdColumn.map((item)=>{
                    if(this.isUndefined(item.isVisible)){
                        item.isVisible = true
                    }
                });
                return createdColumn;
            },
        }
    }
</script>

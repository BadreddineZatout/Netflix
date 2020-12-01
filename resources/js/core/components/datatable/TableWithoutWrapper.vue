<template>
    <div class="datatable">
        <div class="table-responsive custom-scrollbar"
             :class="[{'table-view-responsive': options.responsive || isUndefined(options.responsive), 'loading-opacity': preloader},options.tablePaddingClass?options.tablePaddingClass:'p-primary',isUndefined(options.tableShadow)?'shadow':options.tableShadow?'shadow':'']">
            <table class="table mb-0">
                <thead>
                <tr v-if="isUndefined(options.showHeader) || options.showHeader"
                    :key="id+'-table-header'">
                    <th v-if="!allColumnDisable && options.enableRowSelect"
                        :key="id+'-customized-checkbox'"
                        class="pt-0 pr-0">
                        <div class="customized-checkbox checkbox-default">
                            <input type="checkbox"
                                   id="row-select-all"
                                   :checked="selectedRows.length===dataSet.length && dataSet.length!==0"
                                   @input="doSelectAllRow($event)"/>
                            <label for="row-select-all" class="mb-0"/>
                        </div>
                    </th>
                    <th class="pt-0"
                        v-for="(column, index) in dataTableColumns"
                        v-if="!isEmpty(column) && (column.isVisible || isUndefined(column.isVisible))"
                        :key="id+'-header-column-'+index"
                        :track-by="index"
                        :class="{'text-right pr-0': column.type === 'action'}">

                        <span v-if="column.type === 'action' && (isUndefined(options.showAction) || options.showAction)"
                              :key="id+'column-action-'+index"
                              class="font-size-default">
                            {{ column.title}}
                        </span>

                        <span class="font-size-default" v-else
                              :key="id+'column-normal-'+index">
                            <span v-if="!isUndefined(column.sortable) && column.sortable"
                                  :key="id+'column-normal-sortable-'+index"
                                  class="btn d-flex justify-content-start cursor-pointer font-weight-bold"
                                  @click.prevent="sortByColumn(column, index)">
                                    <span>{{ column.title }}</span>
                                    <span class="ml-2">
                                        <sort v-if="isSort" :icon="column.sortIcon"
                                              :key="`column-sort-${column.key}-${index}`"/>
                                    </span>
                            </span>
                             <span v-else
                                   :key="id+'column-normal-without-sortable-'+index">
                                {{ column.title}}
                            </span>
                        </span>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-if="dataSet.length > 0" v-for="(row, rowIndex) in dataSet" :key="'row'+rowIndex">
                    <td v-if="!allColumnDisable && options.enableRowSelect" class="pr-0">
                        <div class="customized-checkbox checkbox-default">
                            <input type="checkbox"
                                   :id="'row-select-'+rowIndex"
                                   :checked="includesInSelectedRow(row)"
                                   :value="row.id" @input="doSelectRow($event,row)"/>
                            <label :for="'row-select-'+rowIndex" class="mb-0"/>
                        </div>
                    </td>

                    <td v-for="(column, columnIndex) in columns"
                        v-if="!isEmpty(column) && (column.isVisible || isUndefined(column.isVisible))"
                        :key="'column'+rowIndex+columnIndex"
                        :data-title="[(options.responsive || isUndefined(options.responsive)) ? column.title : '']"
                        :class="{'text-md-right': column.type === 'action', 'pt-0 border-top-0': options.showHeader === false && rowIndex === 0}">

                        <span v-if="column.type === 'link'"
                              :class="{[column.className]: !isUndefined(column.className)}"
                              :key="'column-link-'+rowIndex+columnIndex">

                            <a :href="getAppUrl(column.modifier(row[column.key], row))">
                                {{row[column.key]}}
                            </a>
                        </span>

                        <span v-else-if="column.type === 'image'"
                              :key="'column-image-'+rowIndex+columnIndex">
                            <app-avatar :avatar-class="column.className"
                                        :url="row[column.key] ? row[column.key] : column.default"
                                        :alt-text="column.altText"/>
                        </span>

                        <span v-else-if="column.type === 'media-object'"
                              :key="'column-media-object-'+rowIndex+columnIndex">
                            <app-media-object
                                :img-url="column.modifier(row[column.key], row) ? column.modifier(row[column.key], row) : column.default"
                                :alt-text="row[column.mediaTitleKey]"
                                :media-title="row[column.mediaTitleKey]"
                                :media-subtitle="row[column.mediaSubtitleKey]"/>
                        </span>

                        <span v-else-if="column.type === 'component'"
                              :key="'column-component-'+rowIndex+columnIndex"
                              :class="{[column.className]: !isUndefined(column.className)}">
                            <component v-bind:is="column.componentName"
                                       :value="row[column.key]"
                                       :row-data="row"
                                       :table-id="id"
                                       :index="columnIndex">
                            </component>
                        </span>

                        <span v-else-if="column.type === 'custom-html'"
                              :key="'column-custom-html-'+rowIndex+columnIndex"
                              v-html="column.modifier(row[column.key], row)">
                        </span>

                        <span v-else-if="column.type === 'custom-class'"
                              :key="'column-custom-class-'+rowIndex+columnIndex"
                              :class="column.modifier(row[column.key], row)">
                            {{ row[column.key] }}
                        </span>

                        <span v-else-if="column.type === 'object'" :key="'column-object-'+rowIndex+columnIndex">
                            {{ column.modifier(row[column.key], row) }}
                        </span>

                        <span
                            v-else-if="column.type === 'action' && !isUndefined(options.actions) && (isUndefined(options.showAction) || options.showAction)"
                            :key="'column-action-'+rowIndex+columnIndex">

                            <dropdown-action v-if="isUndefined(options.actionType) || options.actionType === 'dropdown'"
                                             :key="options.actionType+columnIndex"
                                             :actions="options.actions"
                                             :unique-key="row[column.key]"
                                             :row-data="row"
                                             @action="getAction"/>

                            <default-action v-else
                                            :key="options.actionType+columnIndex"
                                            :actions="options.actions"
                                            :unique-key="row[column.key]"
                                            :row-data="row"
                                            @action="getAction"/>
                        </span>

                        <span v-else-if="column.type === 'dynamic-content'" :key="'column-dynamic-content-'+rowIndex+columnIndex">
                            <button
                                v-if="!column.modifier(row[column.key], row).isValue && !getDynamicContentValueByKey('dynamicContent'+activePaginationPage+rowIndex+columnIndex)"
                                :class="[column.className ? column.className : 'btn btn-primary']"
                                @click="getDynamicContent('dynamicContent'+activePaginationPage+rowIndex+columnIndex, column.modifier(row[column.key], row))">
                                <app-icon v-if="column.icon" :name="column.icon"/>
                                {{column.label ? column.label: ''}}
                            </button>
                            <span v-else>
                                {{column.modifier(row[column.key], row).isValue ? column.modifier(row[column.key], row).value : getDynamicContentValueByKey('dynamicContent'+activePaginationPage+rowIndex+columnIndex)}}
                            </span>
                        </span>

                        <span v-else-if="column.type === 'button'" :key="'column-button-'+rowIndex+columnIndex">
                            <button v-if="column.modifier(row[column.key], row)!=false" :class="[column.className ? column.className : 'btn btn-primary']"
                                    @click="getButtonTypeValue(row, column)">
                                    <app-icon v-if="column.icon" :name="column.icon"/>
                                {{column.modifier(row[column.key], row)}}
                                <!--{{column.label ? column.label: ''}}-->
                            </button>
                        </span>

                        <span v-else-if="column.type === 'text'" :key="'column-normal-'+rowIndex+columnIndex"
                              :class="{[column.className]: !isUndefined(column.className)}">
                            {{row[column.key]}}
                        </span>
                    </td>

                </tr>
                </tbody>
            </table>
            <hr v-if="dataSet.length === 0" class="m-0">
            <app-empty-data-block v-if="(dataSet.length == 0 && !preloader) ||(allColumnDisable)"
                                  :message="$t('empty_data_block_dummy_message')"/>
        </div>
        <div v-if="totalRow> 0 && paginationRowLimit>0 && totalRow > dataOffset && !allColumnDisable"
             class="mt-primary">
            <div v-if="options.paginationType === 'pagination'" class="text-right">
                <app-pagination :total-row="totalRow"
                                :row-limit="paginationRowLimit"
                                @submit="paginationSubmit"/>
            </div>
            <div v-else class="text-center">
                <app-load-more :preloader="loadMorePreloader"
                               @submit="loadMoreSubmit"/>
            </div>
        </div>
    </div>
</template>

<script>
    import DefaultAction from "./DefaultAction";
    import DropdownAction from "./DropdownAction";
    import Sort from "./helpers/Sort";
    import {TableMixin} from "./mixin/TableMixin.js";

    export default {
        name: "TableWithoutWrapper",
        components: {DefaultAction, DropdownAction, Sort},
        mixins: [TableMixin],
        data() {
            return {
                dataSet: [],
                preloader: false,
                loadMorePreloader: false,
                loadMoreDisabled: false,
                totalRow: 0,
                paginationRowLimit: 0,
                activePaginationPage: 1,
                dataOffset: 0,
                sortByKey: null,
                filterValues: {},
                search: null,
                orderBy: this.options.orderBy ? this.options.orderBy : 'desc',
                reloadSearch: false,
                originalDataSet: [],
                
                //Dynamic content
                dynamicContents: [],
                
                //Multiple row select
                selectedRows: [],
                
                //Sort by new
                dataTableColumns: [],
                isSort: false,
            }
        },
        created() {
            //this.setPreloader(true);
        },
        mounted() {
            setTimeout(() => {
                // init
                this.dataTableInit();                

                // hub
                this.reloadDataTable();
            });
            this.isSort = true;
        },
        watch: {
            'columns': {
                handler: 'setColumns',
                immediate: true
            }
        },
        methods: {
            getoptions(){
                console.log(this.options.name);
                console.log(this.options.url);
                console.log(this.columns);
                console.log(this.options);
            },
            // For multiple row select
            doSelectAllRow(e) {
                let ele = e.target;
                if (ele.checked) {
                    this.selectedRows = _.clone(this.dataSet);
                } else {
                    this.selectedRows = [];
                }
                this.sendSelectedRowData();
            },
            doSelectRow(e, row) {
                let ele = e.target;
                if (ele.checked) {
                    this.selectedRows.push(row);
                } else {
                    let index = this.selectedRows.indexOf(row);
                    this.selectedRows.splice(index, 1);
                }
                this.sendSelectedRowData();
            },
            includesInSelectedRow(value) {
                return this.selectedRows.includes(value);
            },
            sendSelectedRowData() {
                this.$hub.$emit('selectedRowsData-' + this.id, this.selectedRows);
            },
            
            /**
             * init datable for rander
             * */
            dataTableInit() {
                if (this.reloadSearch){
                    this.search = this.searchValue;
                    if (this.options.name=='PannesTable' || this.options.name=='AbonnementsTable'){
                        this.dataSet = this.searchEmails(this.originalDataSet,this.search);
                    }else this.dataSet = this.searchEmeteurs(this.originalDataSet,this.search);
                    this.reloadSearch = false;
                }
                else {
                    this.paginationRowLimit = this.options.rowLimit ? this.options.rowLimit : 10;
                    // this.orderBy = this.options.orderBy ? this.options.orderBy : 'DESC';
                    this.filterValues = this.filteredData;
                    this.dataSet = [];
                    this.dataOffset = 0;
                    this.getDataSet();
                }
            },

            /**
             * Get data from database
             * */
            getDataSet() {
                let filter = this.filterValues,
                    reqData = {},
                    url = this.options.url;
                filter.per_page = this.paginationRowLimit;
                filter.offset = this.dataOffset;
                filter.sortBy = this.sortByKey;
                filter.sortByOrder = this.sortByKeyOrder;
                filter.page = parseInt(this.activePaginationPage);
                filter.search = this.search;
                filter.orderBy = this.orderBy;

                reqData.params = filter;

                this.axiosGet(
                    url,
                    reqData
                ).then(response => {
                    if (this.options.paginationType === 'pagination') this.configureTableForPagination(response.data);
                    else this.configureTableForLoadMore(response.data);

                    this.totalRow = response.data.total;
                    this.dataOffset = this.dataSet.length;

                }).catch(({response}) => {

                    // trigger after error

                }).finally(() => {
                    
                    this.setPreloader(false);
                });
            },

            /**
             * when paginationType is load more
             * */
            configureTableForLoadMore(response) {
                this.loadMorePreloader = false;
                this.activePaginationPage = response.current_page;
                this.dataSet = [...this.dataSet, ...response.data];
            },

            /**
             * when paginationType is pagination
             * */
            configureTableForPagination(response) {
                this.dataSet = response;
                this.originalDataSet = response;
            },

            /**
             * @pram = boolean
             * set preloader for data table
             * */
            setPreloader(val) {
                this.preloader = val;
            },

            /**
             * for reload datatable
             * */
            reloadDataTable() {
                let name = 'reload-' + this.id;
                this.$hub.$on(name, (value = true) => {
                    if (value) {
                        this.activePaginationPage = 1;
                        this.selectedRows = [];
                        this.reloadSearch = true;
                        this.dataTableInit();
                    }
                });
                
                this.$hub.$on('DeletOrEdit', (value=true)=>{
                    if (value) {
                        this.activePaginationPage = 1;
                        this.selectedRows = [];
                        this.dataTableInit();
                    }
                });
            },

            /**
             * for load more emit
             * */
            loadMoreSubmit() {
                this.loadMorePreloader = true;
                this.activePaginationPage = Number(this.activePaginationPage) + Number(1);
                this.dataOffset += Number(this.paginationRowLimit);
                this.getDataSet();
            },

            /**
             * for pagination emit
             * */
            paginationSubmit(page) {
                this.activePaginationPage = page;
                this.getDataSet();
            },

            /**
             * get dynamic content form db
             * */
            getDynamicContent(key, dynamicContentObj) {
                this.setPreloader(true);

                this.axiosGet(dynamicContentObj.value)
                    .then(response => {

                        let obj = {
                            key: key,
                            value: response.data
                        }
                        this.dynamicContents.push(obj);

                    }).catch(({response}) => {

                    // trigger after error

                }).finally(() => {
                    this.setPreloader(false);
                });
            },

            /**
             * @parm key = String
             * get the dynamic content value by key
             * */
            getDynamicContentValueByKey(key) {
                let obj = this.dynamicContents.find(item => {
                    return item.key == key;
                });
                return !this.isUndefined(obj) ? obj.value : false;
            },

            /**
             * @parm row = Object
             * @parm column = Object
             * $emit from column type = butoon
             * */
            getButtonTypeValue(row, column) {
                this.getAction(row, column, true);
            },

            //Sort by
            sortByColumn(column, index) {
                this.isSort = false;
                if (this.sortByKey == column.key) {
                    if (this.orderBy == 'desc') {
                        this.setSortIcon('asc', 'up', index);
                    } else {
                        this.setSortIcon('desc', 'down', index);
                    }
                } else {
                    this.setSortIcon('asc', 'up', index);
                }


                this.dataTableColumns.filter((item, itemIndex) => {
                    if (index != itemIndex && item?.sortable) this.dataTableColumns[itemIndex].sortIcon = 'no-sort';
                });
                this.sortByKey = column.key;
                this.isSort = true;
                this.dataTableInit();
            },
            setColumns() {
                this.dataTableColumns = this.columns.filter((item, index) => {
                    item.sortIcon = item?.sortable ? 'no-sort' : '';
                    return item;
                })
            },
            setSortIcon(order, icon, index) {
                this.orderBy = order;
                this.dataTableColumns[index].sortIcon = icon;
            }
        }
    }
</script>

<!--would be removed as soon as possible-->
<style>
    .small-sort-icon svg {
        height: 10px !important;
    }
</style>

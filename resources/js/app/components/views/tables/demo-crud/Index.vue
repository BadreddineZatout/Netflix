<template>
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <app-breadcrumb :page-title="$t('functional')" :directory="$t('datatables')" :icon="'grid'"/>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="float-md-right mb-3 mb-sm-3 mb-md-0">
                    <button type="button"
                            class="btn btn-primary btn-with-shadow"
                            data-toggle="modal"
                            @click="openAddEditModal">
                        {{ $t('add') }}
                    </button>
                </div>
            </div>
        </div>

        <app-table :id="tableId" :options="options" @action="getListAction"/>

        <app-add-modal v-if="isAddEditModalActive"
                       :table-id="tableId"
                       :selected-url="selectedUrl"
                       @close-modal="closeAddEditModal"/>

        <dashboard-delete-modal v-if="deleteConfirmationModalActive"
                                :preloader="deleteLoader"
                                modal-id="demo-delete"
                                @confirmed="confirmed"
                                @cancelled="cancelled"/>
    </div>
</template>

<script>
    import CoreLibrary from "../../../../../core/helpers/CoreLibrary.js";
    import * as actions from "../../../../config/ApiUrl";
    import {TableHelpers} from "../mixins/TableHelpers";

    export default {
        extends: CoreLibrary,
        name: "DatatableWithFilter",
        mixins: [TableHelpers],
        data() {
            return {
                deleteLoader: false,
                isAddEditModalActive: false,
                deleteConfirmationModalActive: false,
                selectedUrl: '',
                tableId: 'demo-crud-table',
                rowData: {},
                options: {
                    url: actions.DATATABLE_DATA,
                    name: this.$t('demo_crud'),

                    showHeader: true,
                    columns: [],
                    actions: [
                        {
                            title: this.$t('edit'),
                            icon: 'edit',
                            type: 'none',
                            component: 'app-add-modal',
                            modalId: 'demo-add-edit-modal',

                        }, {
                            title: this.$t('delete'),
                            icon: 'trash',
                            type: 'none',
                            component: 'app-confirmation-modal',
                            modalId: 'demo-delete',
                        }
                    ],
                    showFilter: false,
                    showSearch: false,
                    paginationType: "pagination",
                    responsive: true,
                    rowLimit: 10,
                    showAction: true,
                    orderBy: 'desc',
                    actionType: "default",
                }
            }
        },
        created(){
            this.options.columns = [...this.tableColumns, this.actionObj];
        },
        methods: {
            /**
             * for open add edit modal
             */
            openAddEditModal() {
                this.isAddEditModalActive = true;
            },

            /**
             * for close add edit modal
             */
            closeAddEditModal() {
                $("#demo-add-edit-modal").modal('hide');
                this.isAddEditModalActive = false;
                this.reSetData();
            },

            /**
             * $emit form datatable action
             */
            getListAction(rowData, actionObj, active) {

                this.rowData = rowData;

                if (actionObj.title == 'Delete') {

                    this.openDeleteModal();
                } else if (actionObj.title == this.$t('edit')) {
                    this.selectedUrl = `${actions.DATATABLE_DATA}/${rowData.id}`;
                    this.openAddEditModal();
                }
            },

            /**
             * for open confirmation modal
             */
            openDeleteModal() {
                this.deleteConfirmationModalActive = true;
            },

            /**
             * confirmed $emit form confirmation modal
             */
            confirmed() {
                let url = `${actions.DATATABLE_DATA}/${this.rowData.id}`;
                this.deleteLoader=true;
                this.axiosDelete(url)
                    .then(response => {
                        this.deleteLoader= false;
                        $("#demo-delete").modal('hide');
                        this.cancelled();
                        this.$toastr.s(response.data.message);
                    }).catch(({error}) => {

                    //trigger after error
                }).finally(() => {

                    this.$hub.$emit('reload-' + this.tableId);
                });
            },

            /**
             * cancelled $emit form confirmation modal
             */
            cancelled() {
                this.deleteConfirmationModalActive = false;
                this.reSetData();
            },

            reSetData() {
                this.rowData = {};
                this.selectedUrl = '';
            }
        }
    }
</script>

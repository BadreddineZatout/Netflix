<template>
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <app-breadcrumb :page-title="title"/>
            </div>
        </div>

        <app-table :id="tableId" :options="options" @action="getListAction"/>

        <app-add-modal v-if="isAddEditModalActive && typeTable == 2"
                       :table-id="tableId"
                       :rowData ="rowData"
                       :selected-url="selectedUrl"
                       @close-modal="closeAddEditModal"/>
        <app-add-modalT v-if="isAddEditModalActive && typeTable == 1"
                       :table-id="tableId"
                       :rowData ="rowData"
                       :selected-url="selectedUrl"
                       @close-modal="closeAddEditModal"/>
        <app-add-modalP v-if="isAddEditModalActive && typeTable == 0"
                       :table-id="tableId"
                       :rowData ="rowData"
                       :selected-url="selectedUrl"
                       @close-modal="closeAddEditModal"/>
        <app-edit-panne v-if="isAddEditModalActive && typeTable == 3"
                       :table-id="tableId"
                       :rowData ="rowData"
                       :selected-url="selectedUrl"
                       @close-modal="closeAddEditModal"/>
        <app-edit-modalite v-if="isAddEditModalActive && typeTable == 4"
                       :table-id="tableId"
                       :rowData ="rowData"
                       :selected-url="selectedUrl"
                       @close-modal="closeAddEditModal"/>
        <app-edit-produit v-if="isAddEditModalActive && typeTable == 5"
                       :table-id="tableId"
                       :rowData ="rowData"
                       :selected-url="selectedUrl"
                       @close-modal="closeAddEditModal"/>
        <app-edit-charge v-if="isAddEditModalActive && typeTable == 6"
                       :table-id="tableId"
                       :rowData ="rowData"
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
    import CoreLibrary from "../../../../core/helpers/CoreLibrary.js";
    import * as actions from "../../../config/ApiUrl";
    import {TableHelpers} from './mixins/TableHelpers';

    export default {
        extends: CoreLibrary,
        name: "DatatableWithFilter",
        mixins: [TableHelpers],
        props:{
            title: String,
            typeTable: Number,
            options: {}
        },
        data() {
            return {
                isAddEditModalActive: false,
                deleteConfirmationModalActive: false,
                deleteLoader: false,
                selectedUrl: '',
                tableId: 'advance-table',
                rowData: {}
            }
        },

        created(){
            this.options.columns = [...this.TableType[this.typeTable], this.actionObj];
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
                //this.searchAndSelectFilterOptions();
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
                    switch (this.typeTable) {
                        case 0:
                            this.selectedUrl = `/update-panne-abonnement/${this.rowData.id}`;
                            break;
                        case 1:
                            this.selectedUrl = `/update-transaction/${this.rowData.id}`;
                            break;
                        case 2:
                            this.selectedUrl = `/update-abonnement/${this.rowData.id}`;
                            break;
                        case 3:
                            this.selectedUrl = `/update-panne/${this.rowData.id}`;
                            break;
                        case 4:
                            this.selectedUrl = `/update-modalite/${this.rowData.id}`;
                            break;
                        case 5:
                            this.selectedUrl = `/update-produit/${this.rowData.id}`;
                            break;
                        case 6:
                            this.selectedUrl = `/update-charge/${this.rowData.id}`;
                            break;
                    }
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
                let url;
                switch (this.typeTable) {
                        case 0:
                            url = `/delete-panne-abonnement/${this.rowData.id}`;
                            break;
                        case 1:
                            url = `/delete-transaction/${this.rowData.id}`;
                            break;
                        case 2:
                            url = `/delete-abonnement/${this.rowData.id}`;
                            break;
                        case 3:
                            url = `/delete-panne/${this.rowData.id}`;
                            break;
                        case 4:
                            url = `/delete-modalite/${this.rowData.id}`;
                            break;
                        case 5:
                            url = `/delete-produit/${this.rowData.id}`;
                            break;
                        case 6:
                            url = `/delete-charge/${this.rowData.id}`;
                            break;
                    }
                this.deleteLoader=true;
                this.axiosDelete(url)
                    .then(response => {
                        this.deleteLoader= false;
                        $("#demo-delete").modal('hide');
                        this.cancelled();
                        this.$toastr.s(response.data.message);
                        this.searchAndSelectFilterOptions();
                    }).catch(({error}) => {

                    //trigger after error
                }).finally(() => {
                    this.$hub.$emit('DeletOrEdit');
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
            },

            searchAndSelectFilterOptions(){
                this.axiosGet(actions.DATATABLE_SEARCH_SELECT).then(response => {

                    let name = this.options.filters.find(element => element.title === this.$t('search_and_select'));
                    console.log(name);
                    name.option = response.data.map(name => {
                        return {
                            id:name.name,
                            value:name.name
                        }
                    });
                });
            }
        },
    }
</script>

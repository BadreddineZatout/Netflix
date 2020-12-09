<template>
    <div class="container-fluid col mt-5">
        <div class="row justify-content-center">
            <app-edit-produit v-if="isEditProd"
                       :table-id="tableId"
                       :rowData ="rowData"
                       :selected-url="'/produits'"
                       @close-modal="closeAddEditModal"/>
            <div class="col-sm-12">
                <div class="float-md-right mb-3 mb-sm-3 mb-md-0">
                    <button type="button"
                            class="btn btn-primary btn-with-shadow"
                            @click="openProdModel"
                            data-toggle="modal">
                        {{ $t('Add Produit') }}
                    </button>
                </div>
            </div>
            <advance-datatable title="Produit" :options = "options_produits" :typeTable="tab[2]"></advance-datatable>
        </div>
        <div class="row justify-content-center">
            <app-edit-panne v-if="isEditPanne"
                       :table-id="tableId"
                       :rowData ="rowData"
                       :selected-url="'/pannes'"
                       @close-modal="closeAddEditModal"/>
            <div class="col-sm-12">
                <div class="float-md-right mb-3 mb-sm-3 mb-md-0">
                    <button type="button"
                            class="btn btn-primary btn-with-shadow"
                            @click="openPanneModel"
                            data-toggle="modal">
                        {{ $t('Add Panne') }}
                    </button>
                </div>
            </div>
            <advance-datatable title="Pannes" :options = "options_pannes" :typeTable="tab[0]"></advance-datatable>
        </div>
        <div class="row justify-content-center">
            <app-edit-modalite v-if="isEditMod"
                       :table-id="tableId"
                       :rowData ="rowData"
                       :selected-url="'/modalites'"
                       @close-modal="closeAddEditModal"/>
            <div class="col-sm-12">
                <div class="float-md-right mb-3 mb-sm-3 mb-md-0">
                    <button type="button"
                            class="btn btn-primary btn-with-shadow"
                            @click="openModModel"
                            data-toggle="modal">
                        {{ $t('Add Modalite De Paiement') }}
                    </button>
                </div>
            </div>
            <advance-datatable title="Modalites de Paiement" :options = "options_modalites" :typeTable="tab[1]"></advance-datatable>
        </div>
    </div>
        

</template>

<script>
import * as actions from '../../../config/ApiUrl';
import {FormMixin} from '../../../../core/mixins/form/FormMixin';
import AdvanceDatatable from '../tables/AdvanceDatatable';
import {TableHelpers} from '../tables/mixins/TableHelpers';

export default {
    components:{
            'advance-datatable': AdvanceDatatable
        },
    data(){
        return{
            isEditPanne: false,
            isEditMod: false,
            isEditProd: false,
            tableId: 'advance-table',
            rowData: {},
            tab: [3,4,5],
            options_produits: {
                    name: 'ProduitsTable',
                    url: actions.PRODUITS,
                    showHeader: true,
                    data: [],
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
                },
            options_pannes: {
                    name: 'PannesTable',
                    url: actions.PANNES,
                    showHeader: true,
                    data: [],
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
                },
            options_modalites: {
                    name: 'ModalitesTable',
                    url: actions.MODALITES,
                    showHeader: true,
                    data: [],
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
                },
            pannes: [],
            modalites: [],
            produit: []
        }
    },
    mixins: [FormMixin],
    created(){
        this.getProduits();
        this.getPanne();
        this.getModalite();
    },
    methods: {
        openPanneModel(){
            this.isEditPanne = true;
        },
        openModModel(){
            this.isEditMod = true;
        },
        openProdModel(){
            this.isEditProd = true;
        },
        getPanne(){
            let url = actions.PANNES;
                    this.axiosGet(url).then(response =>{
                        this.pannes = response.data;    
                    });
        },
        getModalite(){
            let url = actions.MODALITES;
                    this.axiosGet(url).then(response =>{
                        this.modalites = response.data;    
                    });
        },
        getProduits(){
                let url = actions.PRODUITS;
                    this.axiosGet(url).then(response =>{
                        this.produits = response.data;    
                    });
            },
        closeAddEditModal() {
            this.isEditPanne = false;
            this.isEditMod = false;             
            this.isEditProd = false;             
        }
    }
}
</script>
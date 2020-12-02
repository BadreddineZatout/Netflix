<template>
    <div class="container-fluid col mt-5">
        <div class="row justify-content-center">
            <div class="card row">
                <div class="card-header bg-primary text-white">
                    Ajouter un type de panne
                </div>
                <div class="card-body">
                        <form @submit="storePanne">
                            <div class="col-sm-6 mt-2">
                                <label for="panne">type de Panne</label>
                                <input type="text" id="panne" name="panne" v-model="dataPanne.data.panne">
                            </div>
                            <div class="form-group row ml-2 mt-2">
                                <div class="col-md-3 mt-2">
                                    <input type="radio" id="green" name="color" value="Green" v-model="dataPanne.data.color">
                                    <label for="green">Vert</label>
                                </div>
                                <div class="col-md-3 mt-2">
                                    <input type="radio" id="yellow" name="color" value="Yellow" v-model="dataPanne.data.color">
                                    <label for="yellow">Jaune</label>
                                </div>
                                <div class="col-md-3 mt-2">
                                    <input type="radio" id="red" name="color" value="Red" v-model="dataPanne.data.color">
                                    <label for="red">Rouge</label>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-2">
                                <button type="submit" class="btn btn-primary">Ajouter</button>
                            </div>
                        </form>
                </div>

            </div>
            <advance-datatable title="Pannes" :options = "options_pannes" :typeTable="tab[0]"></advance-datatable>
        </div>
        <div class="row justify-content-center">
            <div class="card row">
                <div class="card-header bg-primary text-white">
                    Ajouter une modalité de paiement
                </div>
                <div class="card-body">
                    <form @submit="storeModalite">
                        <div class="col-8 mt-2">
                            <label for="modalite">Modalite de paiement</label>
                            <input type="text" id="modalite" name="modalite" v-model="dataModalite.data.modalite">
                        </div>
                        <div class="col-6 mt-2">
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        </div>
                    </form>
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
            tab: [3,4],
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
            dataPanne: {
                url: actions.STORE_PANNES,
                data: {}
            },
            dataModalite: {
                url: actions.STORE_MODALITES,
                data: {}
            },
        }
    },
    mixins: [FormMixin],
    created(){
        this.getPanne();
        this.getModalite();
    },
    methods: {
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
        storePanne(e){
            e.preventDefault();
                axios.post(
                    this.dataPanne.url,this.dataPanne.data
                    ).then(function(response){
                        window.location.replace('/dashboard/settings');
                    });
        },
        storeModalite(e){
            e.preventDefault();
                axios.post(
                    this.dataModalite.url,this.dataModalite.data
                    ).then(function(response){
                        window.location.replace('/dashboard/settings');
                    });
        }
    }
}
</script>



<!-- <div class="row justify-content-center">
            <advance-datatable title="Pannes" :options = "options" :typeTable="0"></advance-datatable>
        </div> 
        
                
                 <div class="mt-5">
                    <table class="table table-bordered">
                        <thead>
                            <th> </th>
                            <th>Modalite de Paiment</th>
                        </thead>
                        <tbody>
                            <tr v-for="mod in modalites" v-bind:key="mod.id">
                                <td>{{mod.id}}</td>
                                <td>{{mod.modalitePaiement}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div> -->
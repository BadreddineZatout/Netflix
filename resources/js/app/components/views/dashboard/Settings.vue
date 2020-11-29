<template>
    <div class="container-fluid row py-5 mx-auto mt-5">
        <div class="row justify-content-center">
            <div class="col-sm-5 border border-primary p-3 ml-5">
                <div class="card">
                    <div class="card-header bg-primary text-white">Ajouter un type de panne</div>
                    <div class="card-body">
                        <form @submit="storePanne">
                            <div class="col-sm-6 mt-2">
                                <label for="panne">type de Panne</label>
                                <input type="text" id="panne" name="panne" v-model="options_pannes.data.panne">
                            </div>
                            <div class="form-group row ml-2 mt-2">
                                <div class="col-md-3 mt-2">
                                    <input type="radio" id="green" name="color" value="Green" v-model="options_pannes.data.color">
                                    <label for="green">Vert</label>
                                </div>
                                <div class="col-md-3 mt-2">
                                    <input type="radio" id="yellow" name="color" value="Yellow" v-model="options_pannes.data.color">
                                    <label for="yellow">Jaune</label>
                                </div>
                                <div class="col-md-3 mt-2">
                                    <input type="radio" id="red" name="color" value="Red" v-model="options_pannes.data.color">
                                    <label for="red">Rouge</label>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-2">
                                <button type="submit" class="btn btn-primary">Ajouter</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="mt-5">
                    <table class="table table-bordered">
                        <thead>
                            <th> </th>
                            <th>Panne</th>
                            <th>Color</th>
                        </thead>
                        <tbody>
                            <tr v-for="panne in pannes" v-bind:key="panne.id">
                                <td>{{panne.id}}</td>
                                <td>{{panne.panne}}</td>
                                <td class="pl-5">
                                    <button disabled="disabled" class="btn" :style="color + panne.color">
                                        {{panne.color}}
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        <div>

        </div>
            <div class="col-sm-5 border border-primary p-3 mx-5">
                <div class="card">
                    <div class="card-header bg-primary text-white">Ajouter une modalité de paiement</div>
                    <div class="card-body">
                        <form @submit="storeModalite">
                            <div class="col-8 mt-2">
                                <label for="modalite">Modalite de paiement</label>
                                <input type="text" id="modalite" name="modalite" v-model="options_modalites.data.modalite">
                            </div>
                            <div class="col-6 mt-2">
                                <button type="submit" class="btn btn-primary">Ajouter</button>
                            </div>
                        </form>
                    </div>
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
            </div>
        </div>
        
    </div>
</template>

<script>
import * as actions from '../../../config/ApiUrl';
import {FormMixin} from '../../../../core/mixins/form/FormMixin';

export default {
    data(){
        return{
            color: "background-color: ",
            pannes: [],
            modalites: [],
            options_pannes: {
                url: actions.STORE_PANNES,
                data: {}
            },
            options_modalites:{
                url: actions.STORE_MODALITES,
                data: {}
            }
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
                    this.options_pannes.url,this.options_pannes.data
                    ).then(function(response){
                        window.location.replace('/dashboard/settings');
                    });
        },
        storeModalite(e){
            e.preventDefault();
            console.log(this.options_modalites.url);
            console.log(this.options_modalites.data);
                axios.post(
                    this.options_modalites.url,this.options_modalites.data
                    ).then(function(response){
                        window.location.replace('/dashboard/settings');
                    });
        }
    }
}
</script>
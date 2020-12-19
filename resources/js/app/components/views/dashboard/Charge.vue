<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">Demande de Chargement</div>
                    <div class="card-body">
                        <form @submit="store">
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="prod">{{ $t('Modalite de Paiement') }}</label>
                                    <select name="prod" id="prod" v-model="options.data.modalite" class="form-control" required>
                                        <option value="0">Choisissez la modalité voulue</option>
                                        <option v-for="modalite in modalites" v-bind:key="modalite.id" :value="modalite.id" v-on:click="showNumero(modalite.NumeroCompte)">{{modalite.modalitePaiement}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="Numero">{{ $t('Numero du Compte') }}</label>
                                    <app-input type="text"
                                               v-model="options.data.numero"
                                               :placeholder="$t('Numero du compte CCP ou Paysera ...')"
                                               :required="false"
                                               :disabled="true"
                                    />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="somme">{{ $t('Somme') }}</label>
                                    <app-input type="text"
                                               v-model="options.data.somme"
                                               :placeholder="$t('Entrer la Somme voulue')"
                                               :required="true"
                                    />
                                </div>
                            </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary">Confirmer la demande</button>
                                </div>
                        </form>
                    </div>
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
            modalites: [],
            options:{
                url: actions.STORE_CHARGES,
                data:{
                    numero: "",
                    modalite: 0,
                },
            }
        }
    },
    mixins: [FormMixin],
    created(){
        this.getModalites();
    },
    methods: {
            getModalites(){
                let url = actions.MODALITES;
                    this.axiosGet(url).then(response =>{
                        this.modalites = response.data;    
                    });
            },
            showNumero(NumeroCompte){
                this.options.data.numero = NumeroCompte;
            },
            store(e){
                e.preventDefault();
                axios.post(
                    this.options.url,this.options.data
                    ).then(function(response){
                        window.location.replace('/dashboard/charge');
                    });
            }
        }
}
</script>
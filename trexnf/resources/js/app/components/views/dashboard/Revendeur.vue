<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">Choisir un offre</div>
                    <div class="card-body">
                        <form>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="email">{{ $t('Email') }}</label>
                                    <app-input type="text"
                                               v-model="options.data.email"
                                               :placeholder="$t('enter Email')"
                                               :required="true"
                                    />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="password">{{ $t('Password') }}</label>
                                    <app-input type="password"
                                               v-model="options.data.password"
                                               :placeholder="$t('enter Password')"
                                               :required="true"
                                    />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <label for="prod">{{ $t('Produit') }}</label>
                                    <select name="prod" id="prod" v-model="options.data.produit" class="form-control" required>
                                        <option v-for="produit in produits" v-bind:key="produit.id" :value="[produit.nom, produit.tarifVenteRevendeur]">{{produit.nom}} - {{produit.tarifVenteRevendeur}} DA</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <strong v-if="notfound" class="strong">
                                        Vous n'avez pas un solde suffisant !!!
                                    </strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary" v-on:click="store">Confirmer la demande</button>
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
            notfound: false,
            produits: [],
            options:{
                url: actions.STORE,
                data:{},
            }
        }
    },
    mixins: [FormMixin],
    created(){
        this.getProduits();
    },
    methods: {
            getProduits(){
                let url = actions.PRODUITS;
                    this.axiosGet(url).then(response =>{
                        this.produits = response.data;    
                    });
            },
            store(e){
                e.preventDefault();
                this.axiosGet('/balance').then(response=>{
                    let balance = response.data;
                    if (balance < this.options.data.produit[1]) this.notfound = true;
                    else{
                        this.notfound = false;
                        axios.post(
                            this.options.url,this.options.data
                            ).then(function(response){
                                window.location.replace('/dashboard/revendeur');
                            });

                    }
                });
            }
        }
}
</script>
<style>
.strong{
    color: red;
}
</style>
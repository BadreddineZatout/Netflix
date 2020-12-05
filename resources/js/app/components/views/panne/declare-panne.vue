<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">Declarer une panne</div>
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
                                    <label for="panne">{{ $t('Type de Panne') }}</label>
                                    <select name="panne" id="panne" v-model="options.data.panne" class="form-control" required>
                                        <option v-for="panne in pannes" v-bind:key="panne.id" :value="panne.panne">{{panne.panne}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-12">
                                    <button class="btn btn-primary" v-on:click="storePanne">Declarer la Panne</button>
                                </div>
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
            pannes: [],
            options:{
                url: actions.DECLARE_PANNE,
                data:{},
            }
        }
    },
    mixins: [FormMixin],
    created(){
        this.getpannes();
    },
    methods: {
            getpannes(){
                let url = actions.PANNES;
                    this.axiosGet(url).then(response =>{ 
                        this.pannes = response.data;
                    });
            },
            storePanne(e){
                e.preventDefault();
                let email = this.options.data.email;
                let pdw = this.options.data.password;
                this.axiosGet(`/declarePanne/email=${email}/pdw=${pdw}`).then(response =>{ 
                        if(response.data == 'non ok'){
                            alert("abonnement non exister");
                        }else{
                            axios.post(
                                 this.options.url,this.options.data
                            ).then(function(response){
                                    // console.log(response.data);
                                    window.location.replace(actions.DECLARE_PANNE);
                                });
                        }
                    });
            }
        }
}
</script>
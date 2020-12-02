<template>
    <dashboard-modal :modal-id="modalId"
                     :title="modalTitle"
                     :preloader="preloader"
                     @submit="submit"
                     @close-modal="closeModal">
        <template slot="body">
            <app-overlay-loader v-if="preloader"/>
            <form class="mb-0"
                  :class="{'loading-opacity': preloader}"
                  ref="form">
                  
                <div class="form-group row align-items-center">
                    <label for="inputs_email" class="col-sm-3 mb-0">
                        {{ $t('email') }}
                    </label>
                    <app-input id="inputs_email"
                               class="col-sm-9"
                               type="text"
                               v-model="inputs.email"
                               :placeholder="rowData.email"
                               :required="true"/>

                </div>
                <div class="form-group row align-items-center">
                    <label for="inputs_pdw" class="col-sm-3 mb-0">
                        {{ $t('password') }}
                    </label>
                    <app-input id="inputs_pdw"
                               class="col-sm-9"
                               type="text"
                               v-model="inputs.password"
                               :placeholder="rowData.password"
                               :required="true"/>

                </div>
                <div class="form-group row align-items-center">
                    <label class="col-sm-3 mb-0">Produits</label>
                    <div class="col-sm-9">
                        <select name="prod" id="prod" v-model="inputs.produit" class="form-control col-md-6 mt-2">
                            <option v-for="produit in produits" v-bind:key="produit.id" :value="produit.nom">{{produit.nom}}</option>
                        </select>
                    </div>
                    
                </div>
                <div class="form-group row align-items-center">
                    <label for="inputs_dd" class="col-sm-3 mb-0">
                        {{ $t('Date de debut') }}
                    </label>
                    <app-input id="inputs_dd"
                               class="col-sm-9"
                               type="text"
                               v-model="inputs.dateDebut"
                               :placeholder="rowData.dateDebut"
                               :required="true"/>
                </div>
                <div class="form-group row align-items-center">
                    <label class="col-sm-3 mb-0">
                        {{ $t('Resultat de creation') }}
                    </label>
                    <div class="col-sm-9">
                        <input type="radio" name="rc" id="rc1" value="pending" v-model="inputs.resultatcreation">
                        <label class="mr-3" for="rc1">Pending</label>
                        <input type="radio" name="rc" id="rc2" value="created" v-model="inputs.resultatcreation">
                        <label class="mr-3" for="rc2">Created</label>
                    </div>
                </div>
                <div class="form-group row align-items-center">
                    <label for="inputs_etat" class="col-sm-3 mb-0">
                        {{ $t('Etat') }}
                    </label>
                    <div class="col-sm-9">
                        <input type="radio" name="etat" id="e1" value="inactif" v-model="inputs.etat">
                        <label class="mr-3" for="e1">Inactif</label>
                        <input type="radio" name="etat" id="e2" value="actif" v-model="inputs.etat">
                        <label class="mr-3" for="e2">Actif</label>
                        <input type="radio" name="etat" id="e3" value="panne" v-model="inputs.etat">
                        <label class="mr-3" for="e3">Panne</label>
                    </div>
                </div>
            </form>
        </template>
    </dashboard-modal>
</template>

<script>
    import {FormMixin} from '../../../../../core/mixins/form/FormMixin.js';
    import {ModalMixin} from "../../../../Mixins/ModalMixin";

    export default {
        name: "AddModal",
        mixins: [FormMixin, ModalMixin],
        props: {
            tableId: String,
            rowData: {}
        },
        data() {
            return {
                preloader: true,
                inputs: {
                    
                },
                produits: [],
                modalId: 'demo-add-edit-modal',
                modalTitle: this.$t('add'),
            }
        },
        created() {
            this.getProduits();
            this.inputs = this.rowData;
            if (this.selectedUrl) {
                this.modalTitle = this.$t('edit');
                this.preloader = false;
            }
        },
        methods: {
            getProduits(){
                let url = 'default-dashboard-produits';
                    this.axiosGet(url).then(response =>{
                        this.produits = response.data;    
                    });
            },
            submit() {
                this.saveEdit(this.selectedUrl, this.inputs);
            },
            afterSuccess(response){
                this.$hub.$emit('DeletOrEdit');
                // this.$toastr.s(response.data.message);
                // setTimeout(this.$hub.$emit('DeletOrEdit'), 10000);
            },

            afterSuccessFromGetEditData(response) {
                if (response.data.phone) this.phone = response.data.phone;
                this.inputs = response.data;
                this.preloader = false;
            },
        },
    }
</script>

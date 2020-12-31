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
                    <label class="col-sm-3 mb-0">Emeteur</label>
                    <div class="col-sm-9">
                        <select name="emet" id="emet" v-model="inputs.emeteur" class="form-control col-md-6 mt-2">
                            <option v-for="emeteur in comptes" v-bind:key="emeteur.id" :value="emeteur.nom">{{emeteur.nom}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row align-items-center">
                    <label class="col-sm-3 mb-0">Emeteur</label>
                    <div class="col-sm-9">
                        <select name="recep" id="recep" v-model="inputs.recepteur" class="form-control col-md-6 mt-2">
                            <option v-for="recepteur in comptes" v-bind:key="recepteur.id" :value="recepteur.nom">{{recepteur.nom}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row align-items-center">
                    <label for="inputs_d" class="col-sm-3 mb-0">
                        {{ $t('Date') }}
                    </label>
                    <app-input id="inputs_d"
                               class="col-sm-9"
                               type="text"
                               v-model="inputs.date"
                               :placeholder="rowData.date"
                               :required="true"/>
                </div>
                <div class="form-group row align-items-center">
                    <label for="inputs_h" class="col-sm-3 mb-0">
                        {{ $t('Montant') }}
                    </label>
                    <app-input id="inputs_h"
                               class="col-sm-9"
                               type="text"
                               v-model="inputs.montant"
                               :placeholder="rowData.montant.toString()"
                               :required="true"/>
                </div>
                <div class="form-group row align-items-center">
                    <label class="col-sm-3 mb-0">Modalite de Paiement</label>
                    <div class="col-sm-9">
                        <select name="mod" id="mod" v-model="inputs.modalitePaiement" class="form-control col-md-6 mt-2">
                            <option v-for="modalite in modalites" v-bind:key="modalite.id" :value="modalite.modalitePaiement">{{modalite.modalitePaiement}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row align-items-center">
                    <label class="col-sm-3 mb-0">Modalite de Paiement</label>
                    <div class="col-sm-9">
                        <input type="radio" name="etat" id="e1" value="paye" v-model="inputs.etat">
                        <label class="mr-3" for="e1">Payé</label>
                        <input type="radio" name="etat" id="e2" value="non paye" v-model="inputs.etat">
                        <label class="mr-3" for="e2">Non Payé</label>
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
                modalites: [],
                comptes: [],
                modalId: 'demo-add-edit-modal',
                modalTitle: this.$t('add'),
            }
        },
        created() {
            this.getmodalites();
            this.getcomptes();
            this.inputs = this.rowData;
            if (this.selectedUrl) {
                this.modalTitle = this.$t('edit');
                this.preloader = false;
            }
        },
        methods: {
            getmodalites(){
                let url = 'default-dashboard-modalites';
                    this.axiosGet(url).then(response =>{
                        this.modalites = response.data;    
                    });
            },
            getcomptes(){
                let url = 'default-dashboard-comptes';
                    this.axiosGet(url).then(response =>{
                        this.comptes = response.data;    
                    });
            },
            submit() {
                this.saveEdit(this.selectedUrl, this.inputs);
            },
            afterSuccess(response) {
                this.$hub.$emit('DeletOrEdit')
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

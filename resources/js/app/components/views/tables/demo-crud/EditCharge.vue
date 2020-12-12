<template>
    <dashboard-modal :modal-id="modalId"
                     :title="modalTitle"
                     :preloader="preloader"
                     @submit="submit"
                     @close-modal="closeModal">
        <template slot="body">
            <!-- <app-overlay-loader v-if="preloader"/> -->
            <form class="mb-0">
                <div class="form-group row align-items-center">
                    <label class="col-sm-3 mb-0">{{ $t('Modalite de Paiement') }}</label>
                    <div class="col-sm-9">
                        <select name="mod" id="prod" v-model="inputs.modalitePaiement" class="form-control" required>
                            <option v-for="modalite in modalites" v-bind:key="modalite.id" :value="modalite.modalitePaiement">{{modalite.modalitePaiement}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row align-items-center">
                    <label for="inputs_numero" class="col-sm-3 mb-0">
                        {{ $t('Numero du Compte') }}
                    </label>
                    <app-input id="inputs_numero"
                               class="col-sm-9"
                               type="text"
                               v-model="inputs.NumeroCompte"
                               :placeholder="rowData.NumeroCompte"
                               :required="false"/>
                </div>
                <div class="form-group row align-items-center">
                    <label for="inputs_somme" class="col-sm-3 mb-0">
                        {{ $t('Somme') }}
                    </label>
                    <app-input id="inputs_somme"
                               class="col-sm-9"
                               type="text"
                               v-model="inputs.somme"
                               :placeholder="rowData.somme.toString()"
                               :required="true"/>
                </div>
                <div class="form-group row align-items-center">
                    <label for="inputs_etat" class="col-sm-3 mb-0">
                        {{ $t('Etat') }}
                    </label>
                    <div class="col-sm-9">
                        <input type="radio" name="etat" id="e1" value="pending" v-model="inputs.etat">
                        <label class="mr-3" for="e1">pending</label>
                        <input type="radio" name="etat" id="e2" value="paye" v-model="inputs.etat">
                        <label class="mr-3" for="e2">paye</label>
                    </div>
                </div>
                <div class="form-group row align-items-center">
                    <label for="inputs_date" class="col-sm-3 mb-0">
                        {{ $t('Date') }}
                    </label>
                    <app-input id="inputs_date"
                               class="col-sm-9"
                               type="text"
                               v-model="inputs.date"
                               :placeholder="rowData.date"
                               :required="true"/>
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
                modalId: 'demo-add-edit-modal',
                modalTitle: this.$t('add'),
            }
        },
        created() {
            this.getModalites();
            if (this.selectedUrl) {
                this.inputs = this.rowData;
                this.inputs.oldEtat = this.rowData.etat;
                this.modalTitle = this.$t('edit');
                this.preloader = false;
            }
        },
        methods: {
            getModalites(){
                let url = 'default-dashboard-modalites';
                    this.axiosGet(url).then(response =>{
                        this.modalites = response.data;    
                    });
            },
            submit() {
                if (this.selectedUrl=='/produits'){
                    this.savePost(this.selectedUrl, this.inputs);
                    setTimeout(location.reload(), 6000);
                }
                else this.saveEdit(this.selectedUrl, this.inputs);
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

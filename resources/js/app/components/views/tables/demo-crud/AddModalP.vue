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
                        {{ $t('Heure') }}
                    </label>
                    <app-input id="inputs_h"
                               class="col-sm-9"
                               type="text"
                               v-model="inputs.heure"
                               :placeholder="rowData.heure"
                               :required="true"/>
                </div>
                <div class="form-group row align-items-center">
                    <label class="col-sm-3 mb-0">Pannes</label>
                    <div class="col-sm-9">
                        <select name="panne" id="panne" v-model="inputs.panne" class="form-control col-md-6 mt-2">
                            <option v-for="panne in pannes" v-bind:key="panne.id" :value="panne.panne">{{panne.panne}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row align-items-center">
                    <label for="inputs_etat" class="col-sm-3 mb-0">
                        {{ $t('Etat') }}
                    </label>
                    <div class="col-sm-9">
                        <input type="radio" name="etat" id="e1" value="pending" v-model="inputs.Etat">
                        <label class="mr-3" for="e1">Pending</label>
                        <input type="radio" name="etat" id="e2" value="fixed" v-model="inputs.Etat">
                        <label class="mr-3" for="e2">Fixed</label>
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
                pannes: [],
                modalId: 'demo-add-edit-modal',
                modalTitle: this.$t('add'),
            }
        },
        created() {
            this.getPannes();
            this.inputs = this.rowData;
            if (this.selectedUrl) {
                this.modalTitle = this.$t('edit');
                this.preloader = false;
            }
        },
        methods: {
            getPannes(){
                let url = 'default-dashboard-pannes';
                    this.axiosGet(url).then(response =>{
                        this.pannes = response.data;    
                    });
            },
            submit() {
                this.saveEdit(this.selectedUrl, this.inputs);
            },
            afterSuccess(response) {
                // this.$toastr.s(response.data.message);
                this.$hub.$emit('DeletOrEdit');
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

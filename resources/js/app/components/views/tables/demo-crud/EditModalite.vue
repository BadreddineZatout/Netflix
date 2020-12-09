<template>
    <dashboard-modal :modal-id="modalId"
                     :title="modalTitle"
                     :preloader="preloader"
                     @submit="submit"
                     @close-modal="closeModal">
        <template slot="body">
            <!-- <app-overlay-loader v-if="preloader"/> -->
            <form class="mb-0"
                  ref="form">
                  
                <div class="form-group row align-items-center">
                    <label for="inputs_mod" class="col-sm-3 mb-0">
                        {{ $t('Modalite de Paiement') }}
                    </label>
                    <app-input id="inputs_mod"
                               class="col-sm-9"
                               type="text"
                               v-model="inputs.modalitePaiement"
                               :placeholder="rowData.modalitePaiement"
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
                produits: [],
                modalId: 'demo-add-edit-modal',
                modalTitle: this.$t('add'),
            }
        },
        created() {
            if (this.selectedUrl) {
                this.inputs = this.rowData;
                this.modalTitle = this.$t('edit');
                this.preloader = false;
            }
        },
        methods: {
            submit() {
                if (this.selectedUrl=='/modalites'){
                    alert("here");
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

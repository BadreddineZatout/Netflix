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
                    <label for="inputs_panne" class="col-sm-3 mb-0">
                        {{ $t('type de panne') }}
                    </label>
                    <app-input id="inputs_panne"
                               class="col-sm-9"
                               type="text"
                               v-model="inputs.panne"
                               :placeholder="rowData.panne"
                               :required="true"/>
                </div>
                <div class="form-group row align-items-center">
                    <label for="inputs_etat" class="col-sm-3 mb-0">
                        {{ $t('Etat') }}
                    </label>
                    <div class="col-sm-9">
                        <input type="radio" name="color" id="c1" value="Green" v-model="inputs.color">
                        <label class="mr-3" for="c1">Vert</label>
                        <input type="radio" name="color" id="c2" value="Yellow" v-model="inputs.color">
                        <label class="mr-3" for="c2">Jaune</label>
                        <input type="radio" name="color" id="c3" value="Red" v-model="inputs.color">
                        <label class="mr-3" for="c3">Rouje</label>
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
            if (this.selectedUrl) {
                this.inputs = this.rowData;
                this.modalTitle = this.$t('edit');
                this.preloader = false;
            }
        },
        methods: {
            submit() {
                if (this.selectedUrl=='/pannes'){
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

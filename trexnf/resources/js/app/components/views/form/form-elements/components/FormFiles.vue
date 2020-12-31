<template>
    <div class="card card-with-shadow border-0 mb-primary">
        <div class="card-header p-primary bg-transparent">
            <h5 class="card-title m-0">{{ $t('files_upload') }}</h5>
        </div>
        <app-overlay-loader v-if="preloader"/>
        <div class="card-body">
            <form ref="form" data-url="/form/files" class="mb-0" :class="{'loading-opacity': preloader}">
                <div class="form-group mb-primary row align-items-center">
                    <label class="col-sm-2 mb-sm-0">
                        {{ $t('default_upload') }}
                    </label>
                    <div class="col-sm-8">
                        <app-input type="file"
                                   :label="$t('upload_your_file')"
                                   v-model="inputs.default_file"/>
                    </div>
                </div>
                <div class="form-group row mb-0">
                    <label class="col-sm-2 mb-sm-0">
                        {{ $t('upload_with_preview') }}
                    </label>
                    <div class="col-sm-8">
                        <app-input type="custom-file-upload"
                                   :label="$t('upload_your_file')"
                                   v-model="inputs.custom_file"/>
                    </div>
                </div>
                <div class="mt-5">
                    <button type="submit" class="btn btn-primary mr-2" @click.prevent="submit">
                        {{ $t('upload') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import {FormMixin} from '../../../../../../core/mixins/form/FormMixin.js';

    export default {
        name: "FormFiles",
        mixins: [FormMixin],
        data() {
            return {
                preloader: false,
                inputs: {},
            }
        },

        methods: {
            beforeSubmit(){
                this.preloader = true;
            },
            submit() {
                let formData = new FormData();
                if (this.inputs.custom_file) {
                    formData.append("custom_file", this.inputs.custom_file);
                }
                if (this.inputs.default_file) {
                    formData.append("default_file", this.inputs.default_file);
                }
                this.save(formData);
            },
            afterSuccess(res) {
                this.$toastr.s(res.data.message);
            },
            afterFinalResponse() {
                this.preloader = false;
                this.inputs = {};
            },
            afterError(res) {
                this.$toastr.e(res.data.message);
            },
        }
    }
</script>

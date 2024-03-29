<template>
    <div class="content-wrapper">
        <app-breadcrumb :page-title="$t('modals')" :directory="$t('ui_elements')" :icon="'trello'"/>

        <!--Default Modals Centered Alignment-->
        <div class="card card-with-shadow border-0">
            <div class="card-header p-primary bg-transparent d-flex justify-content-between align-items-center">
                <h5 class="card-title m-0">{{ $t('centered_modal') }}</h5>
                <!--copy button-->
                <copy-button id="centered-modal" :value="centeredModalValue"/>
            </div>
            <div class="card-body">
                <!--small modal start-->
                <button type="button" class="btn btn-primary mr-2" @click="smallModalCentered = true">
                    {{ $t('small') }}
                </button>
                <app-modal v-if="smallModalCentered"
                           modal-id="small-modal-centered"
                           modal-alignment="center"
                           modal-size="small" @close-modal="closeModal">
                    <template slot="header">
                        <h5 class="modal-title">{{ $t('small') }}</h5>
                        <button type="button" class="close outline-none" data-dismiss="modal" aria-label="Close">
                            <span>
                                <app-icon :name="'x'"></app-icon>
                            </span>
                        </button>
                    </template>

                    <template slot="body">
                        <p class="text-justify">{{ $t('modal_content_2') }}</p>
                    </template>

                    <template slot="footer">
                        <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal" @click="closeModal">
                            {{ $t('close') }}
                        </button>
                        <button type="button" class="btn btn-primary">{{ $t('save_changes') }}</button>
                    </template>
                </app-modal>

                <!--Default Medium modal start-->
                <button type="button" class="btn btn-primary mr-2"
                        @click="defaultModalCentered = true">{{ $t('medium') }}
                </button>
                <app-modal v-if="defaultModalCentered" modal-id="default-modal-centered" modal-alignment="center"
                           modal-size="default" @close-modal="closeModal">
                    <template slot="header">
                        <h5 class="modal-title">{{ $t('medium') }}</h5>
                        <button type="button" class="close outline-none" data-dismiss="modal" aria-label="Close">
                            <span>
                                <app-icon :name="'x'"></app-icon>
                            </span>
                        </button>
                    </template>

                    <template slot="body">
                        <p class="text-justify">{{ $t('modal_content') }}</p>
                    </template>

                    <template slot="footer">
                        <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal" @click="closeModal">
                            {{ $t('close') }}
                        </button>
                        <button type="button" class="btn btn-primary">{{ $t('save_changes') }}</button>
                    </template>
                </app-modal>

                <!--large modal start-->
                <button type="button" class="btn btn-primary mr-2"
                        @click="largeModalCentered = true">{{ $t('large') }}
                </button>
                <app-modal v-if="largeModalCentered"
                           modal-id="large-modal-centered"
                           modal-alignment="center"
                           modal-size="large"
                           @close-modal="closeModal">
                    <template slot="header">
                        <h5 class="modal-title">{{ $t('large') }}</h5>
                        <button type="button" class="close outline-none" data-dismiss="modal" aria-label="Close">
                            <span>
                                <app-icon :name="'x'"></app-icon>
                            </span>
                        </button>
                    </template>

                    <template slot="body">
                        <p class="text-justify">{{ $t('modal_content') }}</p>
                    </template>

                    <template slot="footer">
                        <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal" @click="closeModal">
                            {{ $t('close') }}
                        </button>
                        <button type="button" class="btn btn-primary">{{ $t('save_changes') }}</button>
                    </template>
                </app-modal>

                <!--extra large modal start-->
                <button type="button" class="btn btn-primary mr-2" @click="xlModalCentered = true">
                    {{ $t('extra_large') }}
                </button>
                <app-modal v-if="xlModalCentered"
                           modal-id="xl-modal-centered"
                           modal-alignment="center"
                           modal-size="extra-large"
                           @close-modal="closeModal">
                    <template slot="header">
                        <h5 class="modal-title">{{ $t('extra_large') }}</h5>
                        <button type="button" class="close outline-none" data-dismiss="modal" aria-label="Close">
                            <span>
                                <app-icon :name="'x'"></app-icon>
                            </span>
                        </button>
                    </template>

                    <template slot="body">
                        <p class="text-justify">
                            {{ $t('modal_content') }}
                        </p>
                    </template>

                    <template slot="footer">
                        <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal" @click="closeModal">
                            {{ $t('close') }}
                        </button>
                        <button type="button" class="btn btn-primary">{{ $t('save_changes') }}</button>
                    </template>
                </app-modal>

                <!--Full width modal start-->
                <button type="button" class="btn btn-primary mr-2" @click="fullWidthModalCentered = true">
                    {{ $t('full_width') }}
                </button>
                <app-modal v-if="fullWidthModalCentered"
                           modal-id="full-width-modal-centered"
                           modal-alignment="center"
                           modal-size="full-width"
                           @close-modal="closeModal">
                    <template slot="header">
                        <h5 class="modal-title">{{ $t('full_width') }}</h5>
                        <button type="button" class="close outline-none" data-dismiss="modal" aria-label="Close">
                            <span>
                                <app-icon :name="'x'"></app-icon>
                            </span>
                        </button>
                    </template>

                    <template slot="body">
                        <p class="text-justify">
                            {{ $t('modal_content') }}
                        </p>
                    </template>

                    <template slot="footer">
                        <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal" @click="closeModal">
                            {{ $t('close') }}
                        </button>
                        <button type="button" class="btn btn-primary">{{ $t('save_changes') }}</button>
                    </template>
                </app-modal>
            </div>
        </div>

        <!--Default Modals Top Alignment-->
        <div class="card mt-4 card-with-shadow border-0">
            <div class="card-header p-primary bg-transparent d-flex justify-content-between align-items-center">
                <h5 class="card-title m-0">{{ $t('top_centered_modal') }}</h5>
                <!--copy button-->
                <copy-button id="top-centered-modal" :value="topCenteredModalValue"/>
            </div>
            <div class="card-body">
                <!--small modal start-->
                <button type="button" class="btn btn-primary mr-2" @click="smallModal = true">
                    {{ $t('small') }}
                </button>
                <app-modal v-if="smallModal"
                           modal-id="small-modal"
                           modal-size="small"
                           modal-alignment="top"
                           @close-modal="closeModal">
                    <template slot="header">
                        <h5 class="modal-title">{{ $t('small') }}</h5>
                        <button type="button" class="close outline-none" data-dismiss="modal" aria-label="Close">
                            <span>
                                <app-icon :name="'x'"></app-icon>
                            </span>
                        </button>
                    </template>

                    <template slot="body">
                        <p class="text-justify">{{ $t('modal_content_2') }}</p>
                    </template>

                    <template slot="footer">
                        <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal" @click="closeModal">
                            {{ $t('close') }}
                        </button>
                        <button type="button" class="btn btn-primary">{{ $t('save_changes') }}</button>
                    </template>
                </app-modal>

                <!--Default modal start-->
                <button type="button" class="btn btn-primary mr-2" @click="defaultModal = true">
                    {{ $t('medium') }}
                </button>
                <app-modal v-if="defaultModal"
                           modal-id="default-modal"
                           modal-size="default"
                           modal-alignment="top"
                           @close-modal="closeModal">
                    <template slot="header">
                        <h5 class="modal-title">{{ $t('medium') }}</h5>
                        <button type="button" class="close outline-none" data-dismiss="modal" aria-label="Close">
                            <span>
                                <app-icon :name="'x'"></app-icon>
                            </span>
                        </button>
                    </template>

                    <template slot="body">
                        <p class="text-justify">{{ $t('modal_content') }}</p>
                    </template>

                    <template slot="footer">
                        <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal" @click="closeModal">
                            {{ $t('close') }}
                        </button>
                        <button type="button" class="btn btn-primary">{{ $t('save_changes') }}</button>
                    </template>
                </app-modal>

                <!--large modal start-->
                <button type="button" class="btn btn-primary mr-2" @click="largeModal = true">
                    {{ $t('large') }}
                </button>
                <app-modal v-if="largeModal"
                           modal-id="large-modal"
                           modal-size="large"
                           modal-alignment="top"
                           @close-modal="closeModal">
                    <template slot="header">
                        <h5 class="modal-title">{{ $t('large') }}</h5>
                        <button type="button" class="close outline-none" data-dismiss="modal" aria-label="Close">
                            <span>
                                <app-icon :name="'x'"></app-icon>
                            </span>
                        </button>
                    </template>

                    <template slot="body">
                        <p class="text-justify">{{ $t('modal_content') }}</p>
                    </template>

                    <template slot="footer">
                        <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal" @click="closeModal">
                            {{ $t('close') }}
                        </button>
                        <button type="button" class="btn btn-primary">{{ $t('save_changes') }}</button>
                    </template>
                </app-modal>

                <!--extra large modal start-->
                <button type="button" class="btn btn-primary mr-2" @click="xlModal = true">
                    {{ $t('extra_large') }}
                </button>
                <app-modal v-if="xlModal"
                           modal-id="xl-modal"
                           modal-size="extra-large"
                           modal-alignment="top"
                           @close-modal="closeModal">
                    <template slot="header">
                        <h5 class="modal-title">{{ $t('extra_large') }}</h5>
                        <button type="button" class="close outline-none" data-dismiss="modal" aria-label="Close">
                            <span>
                                <app-icon :name="'x'"></app-icon>
                            </span>
                        </button>
                    </template>

                    <template slot="body">
                        <p class="text-justify">
                            {{ $t('modal_content') }}
                        </p>
                    </template>

                    <template slot="footer">
                        <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal" @click="closeModal">
                            {{ $t('close') }}
                        </button>
                        <button type="button" class="btn btn-primary">{{ $t('save_changes') }}</button>
                    </template>
                </app-modal>

                <!--Full height modal start-->
                <button type="button" class="btn btn-primary mr-2" @click="fullHeight = true">
                    {{ $t('full_height') }}
                </button>
                <app-modal v-if="fullHeight"
                           modal-id="full-height-modal"
                           modal-size="default"
                           modal-alignment="top"
                           @close-modal="closeModal">
                    <template slot="header">
                        <h5 class="modal-title">{{ $t('full_height') }}</h5>
                        <button type="button" class="close outline-none" data-dismiss="modal" aria-label="Close">
                            <span>
                                <app-icon :name="'x'"></app-icon>
                            </span>
                        </button>
                    </template>

                    <template slot="body">
                        <p class="text-justify">
                            {{ $t('modal_content')+$t('modal_content')+$t('modal_content') }}
                        </p>
                    </template>

                    <template slot="footer">
                        <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal" @click="closeModal">
                            {{ $t('close') }}
                        </button>
                        <button type="button" class="btn btn-primary">{{ $t('save_changes') }}</button>
                    </template>
                </app-modal>
            </div>
        </div>

        <!-- Special modals-->
        <div class="card mt-4 card-with-shadow border-0">
            <div class="card-header p-primary bg-transparent d-flex justify-content-between align-items-center">
                <h5 class="card-title m-0">{{ $t('special_modal') }}</h5>
                <!--copy button-->
                <copy-button id="special-modal" :value="specialModalValue"/>
            </div>
            <div class="card-body">
                <!--Full screen modal start-->
                <button type="button" class="btn btn-primary mr-2" @click="fullScreen = true">
                    {{ $t('full_screen') }}
                </button>
                <app-modal v-if="fullScreen"
                           modal-id="full-screen-modal"
                           modal-size="fullscreen"
                           @close-modal="closeModal">
                    <template slot="header">
                        <h5 class="modal-title">{{ $t('full_screen') }}</h5>
                        <button type="button" class="close outline-none" data-dismiss="modal" aria-label="Close">
                            <span>
                                <app-icon :name="'x'"></app-icon>
                            </span>
                        </button>
                    </template>

                    <template slot="body">
                        <p class="text-justify">
                            {{ $t('modal_content') }}
                        </p>
                    </template>

                    <template slot="footer">
                        <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal" @click="closeModal">
                            {{ $t('close') }}
                        </button>
                        <button type="button" class="btn btn-primary">{{ $t('save_changes') }}</button>
                    </template>
                </app-modal>

                <!--Confirmed modal start-->
                <button type="button" class="btn btn-success mr-2"
                        @click="confirmedModal = true">{{ $t('confirm') }}
                </button>
                <app-modal v-if="confirmedModal"
                           modal-id="confirm-modal"
                           modal-alignment="center"
                           modal-size="md"
                           @close-modal="closeModal">
                    <div class="modal-body d-flex flex-column justify-content-center modal-alert">
                        <div class="text-center">
                            <app-icon class="text-success text-center" :name="'check-circle'"/>
                        </div>
                        <h5 class="text-center font-weight-bold mt-4">{{ $t('congratulation') }}</h5>
                        <p class="text-center mb-primary p-0 font-size-90">{{ $t('confirm_text') }}</p>
                        <div class="text-center">
                            <a href="#" class="btn btn-success" data-dismiss="modal" @click="closeModal">{{ $t('continue') }}</a>
                        </div>
                    </div>
                </app-modal>

                <!--Alert modal start-->
                <button type="button" class="btn btn-warning mr-2" @click="alertModal = true">
                    {{ $t('alert') }}
                </button>
                <app-modal v-if="alertModal"
                           modal-id="alert-modal"
                           modal-alignment="center"
                           modal-size="md"
                           @close-modal="closeModal">
                    <div class="modal-body d-flex flex-column justify-content-center modal-alert">
                        <div class="text-center">
                            <app-icon class="text-warning" :name="'alert-triangle'"/>
                        </div>
                        <h5 class="text-center font-weight-bold mt-4">{{ $t('alert')+'!' }}</h5>
                        <p class="text-center mb-primary p-0  font-size-90">{{ $t('alert_text') }}</p>
                        <div class="text-center">
                            <a href="#" class="btn btn-warning" data-dismiss="modal" @click="closeModal">
                                {{ $t('continue') }}
                            </a>
                        </div>
                    </div>
                </app-modal>

                <!--Delete modal start-->
                <button type="button" class="btn btn-danger mr-2" @click="deleteModal=true">
                    {{ $t('delete')}}
                </button>
                <app-confirmation-modal v-if="deleteModal"
                                        modal-id="delete"
                                        @confirmed="confirmed"
                                        @cancelled="cancelled"/>
            </div>
        </div>
    </div>
</template>

<script>
    import CopyButton from "../CopyButton";
    import {UiModalMixins} from "./UiModalMixins";

    export default {
        name: "Modal",
        components:{CopyButton},
        mixins:[UiModalMixins],
        data() {
            return {
                smallModalCentered: false,
                defaultModalCentered: false,
                largeModalCentered: false,
                xlModalCentered: false,
                fullWidthModalCentered: false,
                smallModal: false,
                defaultModal: false,
                largeModal: false,
                xlModal: false,
                fullHeight: false,
                fullScreen: false,
                confirmedModal: false,
                alertModal: false,
                deleteModal: false,
            }
        },
        methods: {
            closeModal() {
                this.smallModalCentered = false;
                this.defaultModalCentered = false;
                this.largeModalCentered = false;
                this.xlModalCentered = false;
                this.fullWidthModalCentered = false;
                this.smallModal = false;
                this.defaultModal = false;
                this.largeModal = false;
                this.xlModal = false;
                this.fullHeight = false;
                this.showModal = false;
                this.fullScreen = false;
                this.confirmedModal = false;
                this.alertModal = false;
            },
            confirmed() {
                console.log('confirmed');
                this.deleteModal = false;
            },
            cancelled() {
                console.log('cancelled');
                this.deleteModal = false;
            }
        }
    }
</script>


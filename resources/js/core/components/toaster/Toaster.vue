<template>
    <div class="toast-wrapper" aria-live="polite" aria-atomic="true">
        <div :class="'toast '+toasterType" data-delay="1500" :data-autohide="toasterAutohide">
            <div class="toast-header">
                <app-icon v-if="toasterType === 'success'" :name="'check'" class="mr-2"/>
                <app-icon v-else-if="toasterType === 'warning'" :name="'alert-triangle'" class="mr-2"/>
                <app-icon v-else-if="toasterType === 'error'" :name="'x-circle'" class="mr-2"/>
                <span class="mr-auto">{{ toasterMessage }}</span>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">
                            <app-icon :name="'x'"/>
                        </span>
                </button>
            </div>
        </div>
        <!--<div class="toast warning" data-delay="1500">
            <div class="toast-header">
                <Icon :name="'alert-triangle'" class="mr-2"/>
                <span class="mr-auto">This is a warning toaster</span>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">
                            <Icon :name="'x'"/>
                        </span>
                </button>
            </div>
        </div>
        <div class="toast error" data-delay="1500">
            <div class="toast-header">
                <Icon :name="'x-circle'" class="mr-2"/>
                <span class="mr-auto">This is a error toaster</span>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">
                            <Icon :name="'x'"/>
                        </span>
                </button>
            </div>
        </div>-->
    </div>
</template>

<script>
    export default {
        name: "Toaster",
        props: {
            toasterType: {
                type: String,
                required: true
            },
            toasterMessage: {
                type: String,
                Default: true
            },
            toasterAutohide: {
                type: Boolean,
                Default: true
            }
        },
        methods: {
            showToast(selector) {
                $(selector).toast('show');
            }
        }
    }
</script>

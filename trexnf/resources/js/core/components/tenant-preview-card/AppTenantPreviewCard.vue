<template>
    <div class="card card-with-shadow border-0 p-primary tenant-preview-card mb-primary">
        <div class="d-flex justify-content-between">
            <img :src="getLogoUrl(tenant)"
                 class="img-fluid d-inline-block rounded mb-2"
                 width="50"
                 height="50"
                 alt="">
            <div v-if="showAction" class="dropdown options-dropdown">
                <button type="button"
                        class="btn-option btn d-flex align-items-center justify-content-center"
                        data-toggle="dropdown">
                    <app-icon name="more-horizontal"/>
                </button>
                <div class="dropdown-menu dropdown-menu-right py-2 mt-1">
                    <a class="dropdown-item px-4 py-2"
                       href="#"
                       v-for="(action,index) in actions"
                       :key="index"
                       v-if="checkIfVisible(action, tenant)"
                       @click.prevent="callAction(action)">
                        {{ action.title }}
                    </a>
                </div>
            </div>
        </div>
        <p class="mb-2">{{ tenant.name }}</p>
        <p class="mb-4 font-size-80 text-muted">{{ tenant.admin.full_name || tenant.admin.email }}</p>
        <div class="d-flex align-items-center mb-2">
            <span class="badge badge-lg badge-pill text-capitalize mr-2"
                  :class="{'badge-danger': tenant.status.name === 'status_inactive', 'badge-primary': tenant.status.name === 'status_active', 'badge-info': tenant.status.name === 'status_invited'}">
                {{ tenant.status.translated_name }}
            </span>
        </div>
        <div class="mb-4">
            <p class="mb-2">
                <span class="text-muted">{{ $t('invited_by') }}:</span> {{ tenant.created_by.full_name }}
            </p>
            <p class="mb-2">
                <span class="text-muted">{{ $t('short_name') }}:</span> {{ tenant.short_name }}
            </p>
            <p class="mb-0">
                <span class="text-muted">{{ $t('group') }}:</span> {{ tenant.tenant_group.name }}
            </p>
        </div>
        <a href="#" @click.prevent="clickedGoToDashboard" class="btn-to-tenant-dashboard">
            <app-icon name="arrow-right"/>
            <span>{{ $t('go_to_dashboard') }}</span>
        </a>
    </div>
</template>

<script>
import CoreLibrary from "../../helpers/CoreLibrary";

export default {
    name: "AppTenantPreviewCard",
    extends: CoreLibrary,
    props: {
        tenant: {
            type: Object,
            required: true
        },
        actions: {
            type: Array,
            require: true
        },
        showAction: {
            type: Boolean,
            default: true
        },
        id: {
            type: String,
            require: true
        }
    },
    methods: {
        clickedGoToDashboard(){
            let action = {
                'key': 'goto',
                'title': 'Go To Dashboard'
            };
            this.callAction(action);
        },
        callAction(action) {
            this.$emit('action-' + this.id, this.tenant, action, true)
        },
        checkIfVisible(action, tenant) {
            if (this.isFunction(action.modifier)) {
                return action.modifier(tenant);
            }
            return true;
        },
        getLogoUrl(tenant) {
            return this.getAppUrl(tenant.logo ? tenant.logo.value : 'images/default-tenant-image.png')
        }
    }
}
</script>

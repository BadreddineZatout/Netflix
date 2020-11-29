<template>
    <div class="dropdown options-dropdown d-inline-block">
        <button type="button" class="btn-option btn" data-toggle="dropdown" :title="$t('actions')">
            <app-icon name="more-vertical"/>
        </button>

        <div v-if="actions.length > 0"
             :key="'dropdown-'+actions.length"
             class="dropdown-menu dropdown-menu-right py-2 mt-1">
            <a v-for="(action, index) in actions"
               v-if="checkForVisible(action)"
               :key="index"
               class="dropdown-item px-4 py-2"
               :class="action.className"
               @click="callMethod('',action)"
               href="#">
                {{action.title}}
            </a>
        </div>
    </div>
</template>

<script>
    import {ActionMixin} from "./mixin/ActionMixin.js";

    export default {
        name: "DropdownAction",

        mixins: [ActionMixin],
    }
</script>

<template>
    <div v-if="actions.length > 0" class="btn-group btn-group-action" role="group" aria-label="Default action">
        <button v-for="(action, index) in actions" :key="index" type="button"
                v-if="checkForVisible(action)"
                class="btn"
                :class="action.className"
                data-toggle="tooltip"
                data-placement="top"
                :title="action.title"
                @click="callMethod('',action)">
            <app-icon v-if="action.icon" :name="action.icon"/>
            <span v-else>
                {{action.title}}
            </span>
        </button>
    </div>
</template>

<script>
    import {ActionMixin} from "./mixin/ActionMixin.js";

    export default {
        name: "DefaultAction",
        mixins: [ActionMixin],
        mounted() {
            setTimeout(function () {
                $('[data-toggle="tooltip"]').tooltip()
            }, 5000);
        },
    }
</script>

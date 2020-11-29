import CoreLibrary from "../../../helpers/CoreLibrary";

export const ActionMixin = {
    extends: CoreLibrary,
    props: {
        actions: {
            required: true,
            type: Array
        },
        uniqueKey: {
            required: true
        },
        rowData: null
    },
    data() {
        return {
            action: {},
            actionData: {}
        }
    },
    methods: {
        modal() {
            $(`#${this.action.modalId}`).modal('show');
        },
        pageRedirect(action) {
            const url = this.action.url + '/' + this.rowData[this.action.uniqueKey];
            window.location.replace(url);
        },
        callMethod(e, action) {
            //get data of specific that row from parent vue component
            this.actionData = this.rowData;
            this.action = action;

            if (action.type == "modal") this.modal()
            else if (action.type == "page") this.pageRedirect();

            this.closeModal();
        },
        closeModal() {
            this.$emit("action", this.actionData, this.action, true);
        },
        checkForVisible(action) {
            if (!this.isUndefined(action.title)) {
                if (!this.isUndefined(action.modifier)) {
                    return action.modifier(this.rowData)
                } else return true
            } else return false
        }
    }
};

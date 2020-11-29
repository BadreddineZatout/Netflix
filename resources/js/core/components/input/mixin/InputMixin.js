import coreLibrary from "../../../helpers/CoreLibrary";

export const InputMixin = {
    extends: coreLibrary,
    props: {
        data: {
            default: null
        },
        value: {}
    },
    data() {
        return {
            fieldValue: '',
            inputFieldId: '',
        }
    },
    computed: {
        name() {
            if (this.data.type === 'radio' || this.data.type === 'radio-buttons' || this.data.type === 'checkbox') {
                return this.data.radioCheckboxName ? this.data.radioCheckboxName : this.$parent.name;
            }
            return this.$parent.name;
        },
        listeners() {
            return {
                ...this.$listeners,
                input: event => {
                    if (this.data.type == 'file') {
                        const file = event.target.files[0];
                        this.fieldValue = file;
                        this.$emit('input', this.fieldValue);
                    } else if (this.data.type == 'custom-file-upload') {
                        this.getFile(event);
                    } else if (this.data.type == 'switch') {
                        this.$emit('input', event.target.checked);
                    } else
                        this.$emit('input', event.target.value);
                }
            }
        }
    },
    created() {
        this.inputFieldId = this.data.id ? this.data.id : this.name;
    },
};

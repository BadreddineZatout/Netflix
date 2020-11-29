import AppLibrary from "../helpers/AppLibrary";
export const TableWithoutWrapperMixin = {
    extends: AppLibrary,
    data(){
        return{
            search: '',
        }
    },
    methods: {
        getSearchValue(value) {
            this.search = value;
            setTimeout( () => {
                this.$hub.$emit('reload-' + this.tableId);
            });
        },
    }
};

import coreLibrary from '../../../helpers/CoreLibrary';

export const TableMixin = {
    extends: coreLibrary,
    props: {
        id: {
            type: String,
            required: true
        },
        options: {
            required: true,
            type: Object
        },
        columns: {
            required: true,
            type: Array
        },
        filteredData: {
            type: Object,
            default: function () {
                return {};
            }
        },
        searchValue: String
    },
    computed: {
        allColumnDisable() {
            let disabledColumns = this.columns.filter((column) => {
                return column.isVisible != false;
            });
            return disabledColumns.length <= 0;
        }
    },
    methods: {
        getAction(rowData, actionObj, active) {
            this.$emit("action", rowData, actionObj, active);
        },
        searchEmails(dataSet,search) {
            return dataSet.filter((item)=>{
                return item.email.match(search);
            });
        },
        searchEmeteurs(dataSet, search){
            return dataSet.filter((item)=>{
                return item.emeteur.match(search);
            });
        },
        searchUsers(dataSet, search){
            return dataSet.filter((item)=>{
                return item.first_name.match(search);
            });
        },
        searchRoles(dataSet, search){
            return dataSet.filter((item)=>{
                return item.name.match(search);
            });
        },
        filterStatus(dataSet, filter){
            if (filter=="") return dataSet;
            return dataSet.filter((item)=>{
                return item.status_id == filter;
            });
        },
    }
};

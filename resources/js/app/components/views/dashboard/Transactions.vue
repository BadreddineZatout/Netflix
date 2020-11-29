<template>
    <div class="content-wrapper">
        <advance-datatable title="Transactions" :options = "options" :typeTable="tab"></advance-datatable>
    </div>
</template>


<script>
    import {FormMixin} from '../../../../core/mixins/form/FormMixin';
    import * as actions from '../../../config/ApiUrl';
    import AdvanceDatatable from '../tables/AdvanceDatatable';
    import {TableHelpers} from '../tables/mixins/TableHelpers';

    export default {
        name: "TransactionsDashboard",
        mixins: [FormMixin],
        components:{
            'advance-datatable': AdvanceDatatable
        },
        data() {
            return {
                tab: 1,
                panne:{},
                options: {
                    name: 'TransactionsTable',
                    url: actions.TRANSACTIONS,
                    showHeader: true,
                    columns: [],
                    actions: [
                        {
                            title: this.$t('edit'),
                            icon: 'edit',
                            type: 'none',
                            component: 'app-add-modal',
                            modalId: 'demo-add-edit-modal',

                        }, {
                            title: this.$t('delete'),
                            icon: 'trash',
                            type: 'none',
                            component: 'app-confirmation-modal',
                            modalId: 'demo-delete',
                        }
                    ],
                    // filters: [
                    //     {
                    //         "title": this.$t('date'),
                    //         "type": "range-picker",
                    //         "key": "date",
                    //         "option": ["today", "thisMonth", "last7Days", "nextYear"]
                    //     },
                    //     {
                    //         "title": this.$t('age'),
                    //         "type": "range-filter",
                    //         "key": "age-range",
                    //         "maxTitle": this.$t('max_age'),
                    //         "minTitle": this.$t('min_age'),
                    //         "sign": ""
                    //     },
                    //     {
                    //         "title": this.$t('status'),
                    //         "type": "checkbox",
                    //         "key": "status",
                    //         "option": [
                    //             {id: 'active', value: 'Active'},
                    //             {id: 'inactive', value: 'Inactive'},
                    //             {id: 'invited', value: 'Invited'},
                    //         ],
                    //     },
                    //     {
                    //         "title": this.$t('gender'),
                    //         "type": "radio",
                    //         "key": "filter-with-gender",
                    //         "option": [
                    //             {id: 'male', value: 'Male'},
                    //             {id: 'female', value: 'Female'},
                    //             {id: 'other', value: 'Other'},
                    //         ],

                    //         "header": {
                    //             "title": this.$t('want_to_filter_your_list'),
                    //             "description": this.$t('you_can_filter_your_data_table_which_are_created_based_on_gender'),
                    //         },
                    //     },
                    //     {
                    //         "title": this.$t('search_and_select'),
                    //         "type": "drop-down-filter",
                    //         "key": "search select",
                    //         "option": [],
                    //     }
                    // ],
                    showFilter: true,
                    showSearch: true,
                    paginationType: "pagination",
                    responsive: true,
                    rowLimit: 10,
                    showAction: true,
                    orderBy: 'desc',
                    actionType: "default",
                }
            }
        },
        created(){
        },
        methods: {
            gettransactions(){
                let url = actions.TRANSACTIONS;
                    this.axiosGet(url).then(response =>{
                        //Vue.set(this.info, 'users' ,response.data);    
                        console.log(response.data);
                    });
            }
        }
    }
</script>

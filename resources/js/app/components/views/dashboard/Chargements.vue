<template>
    <div class="content-wrapper">
        <advance-datatable title="Chargements" :options = "options" :typeTable="tab"></advance-datatable>
    </div>
</template>

<script>
    import {FormMixin} from '../../../../core/mixins/form/FormMixin';
    import {DashboardPreloader} from "./mixins/DashboardPreloader";
    import AdvanceDatatable from '../tables/AdvanceDatatable';
    import * as actions from '../../../config/ApiUrl';

    export default {
        name: "AbonnementsDashboard",
        mixins: [FormMixin],
        components:{
            'advance-datatable': AdvanceDatatable
        },
        data() {
            return {
                tab: 6,
                panne:{},
                options: {
                    name: 'ChargesTable',
                    url: actions.CHARGES,
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
            getchargements(){
                let url = actions.CHARGES;
                    this.axiosGet(url).then(response =>{  
                        console.log(response.data);
                    });
            }
        }
    }
</script>

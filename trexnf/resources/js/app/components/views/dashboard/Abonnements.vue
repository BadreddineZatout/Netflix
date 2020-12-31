<template>
    <div class="content-wrapper">
        <advance-datatable title="Abonnements" :options = "options" :typeTable="tab"></advance-datatable>
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
                tab: 2,
                panne:{},
                options: {
                    name: 'AbonnementsTable',
                    url: actions.ABONNEMENTS,
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
            getabonnements(){
                let url = actions.ABONNEMENTS;
                    this.axiosGet(url).then(response =>{
                        //Vue.set(this.info, 'users' ,response.data);    
                        console.log(response.data);
                    });
            }
        }
    }
</script>

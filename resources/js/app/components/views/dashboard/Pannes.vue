<template>
    <div class="content-wrapper">
        <advance-datatable title="Pannes Abonnement" :options = "options" :typeTable="tab"></advance-datatable>
    </div>
</template>

<script>
    import {FormMixin} from '../../../../core/mixins/form/FormMixin';
    import * as actions from '../../../config/ApiUrl';
    import AdvanceDatatable from '../tables/AdvanceDatatable';
    import {TableHelpers} from '../tables/mixins/TableHelpers';

    export default {
        name: "PanneDashboard",
        mixins: [FormMixin],
        components:{
            'advance-datatable': AdvanceDatatable
        },
        data() {
            return {
                tab: 0,
                panne:{},
                options: {
                    name: 'PannesTable',
                    url: actions.PANNES_ABONNEMENT,
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
        methods: {
            getpanne(){
                let url = actions.PANNES_ABONNEMENT;
                    this.axiosGet(url).then(response =>{
                        //Vue.set(this.info, 'users' ,response.data);    
                        console.log(response.data);
                    });
            },
        }
    }
</script>

<template>
    <div class="position-relative">
        <div class="content-wrapper">
            <app-breadcrumb :page-title="$t('default')" :directory="$t('dashboard')" :icon="'pie-chart'"/>
            <div class="row" v-if="data.revendeur">
                <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3">
                    <app-widget class="mb-primary"
                                :type="'app-widget-with-icon'"
                                :label="'Balance Actuel'"
                                :number="balance"
                                :icon="'pie-chart'"/>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3">
                    <app-widget class="mb-primary"
                                :type="'app-widget-with-icon'"
                                :label="'Abonnements Pending'"
                                :number="AbonnPending"
                                :icon="'pie-chart'"/>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3">
                    <app-widget class="mb-primary"
                                :type="'app-widget-with-icon'"
                                :label="'Pannes Pending'"
                                :number="PannePending"
                                :icon="'pie-chart'"/>
                </div>
            </div>
            <div class="row" v-if="data.admin">
                <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3">
                    <app-widget class="mb-primary"
                                :type="'app-widget-with-icon'"
                                :label="'Nombre des Utilisateurs'"
                                :number="users"
                                :icon="'pie-chart'"/>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3">
                    <app-widget class="mb-primary"
                                :type="'app-widget-with-icon'"
                                :label="'Nombre des Produits'"
                                :number="produit"
                                :icon="'pie-chart'"/>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3">
                    <app-widget class="mb-primary"
                                :type="'app-widget-with-icon'"
                                :label="'Nombre Total des Abonnements'"
                                :number="AbonnTotal"
                                :icon="'pie-chart'"/>
                </div>
                <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3">
                    <app-widget class="mb-primary"
                                :type="'app-widget-with-icon'"
                                :label="'Nombre Total des Transactions'"
                                :number="TransTotal"
                                :icon="'pie-chart'"/>
                </div>
            </div>
            <div class="row" v-if="data.revendeur">
                <advance-datatable title="Pannes" :options = "options_panne" :typeTable="0"></advance-datatable>
            </div>
            <div class="row" v-if="data.revendeur">
                <advance-datatable title="Transactions" :options = "options_trans" :typeTable="1"></advance-datatable>
            </div>
            <div class="row" v-if="data.tables_admin">
                <advance-datatable title="Pannes" :options = "options_panne_admin" :typeTable="0"></advance-datatable>
            </div>
            <div class="row" v-if="data.tables_admin">
                <advance-datatable title="Abonnements" :options = "options_abonn" :typeTable="2"></advance-datatable>
            </div>
        </div>
    </div>
</template>

<script>
    import {FormMixin} from '../../../../core/mixins/form/FormMixin';
    import {DashboardPreloader} from "./mixins/DashboardPreloader";
    import * as actions from '../../../config/ApiUrl';
    import {TableHelpers} from '../tables/mixins/TableHelpers';

    export default {

        mixins: [FormMixin,DashboardPreloader],
        name: "Dashboard",
        props:{
            data: {}
        },
        data() {
            return {
                info: {},
                balance: 0,
                AbonnPending: 0,
                PannePending: 0,
                users: 0,
                AbonnTotal: 0,
                TransTotal: 0,
                produit: 0,
                options_panne: {
                    name: 'PannesTable',
                    url: '/default/panneuser',
                    showHeader: true,
                    columns: [],
                    showFilter: false,
                    showSearch: false,
                    paginationType: "pagination",
                    responsive: true,
                    rowLimit: 10,
                    showAction: false,
                    orderBy: 'desc',
                    actionType: "default",
                },
                options_trans: {
                    name: 'TransactionsTable',
                    url: '/default/transuser',
                    showHeader: true,
                    columns: [],
                    showFilter: false,
                    showSearch: false,
                    paginationType: "pagination",
                    responsive: true,
                    rowLimit: 10,
                    showAction: false,
                    orderBy: 'desc',
                    actionType: "default",
                },
                options_panne_admin: {
                    name: 'PannesTable',
                    url: '/default/panneadmin',
                    showHeader: true,
                    columns: [],
                    showFilter: false,
                    showSearch: false,
                    paginationType: "pagination",
                    responsive: true,
                    rowLimit: 10,
                    showAction: false,
                    orderBy: 'desc',
                    actionType: "default",
                },
                options_abonn: {
                    name: 'AbonnementsTable',
                    url: '/default/abonnadmin',
                    showHeader: true,
                    columns: [],
                    showFilter: false,
                    showSearch: false,
                    paginationType: "pagination",
                    responsive: true,
                    rowLimit: 10,
                    showAction: false,
                    orderBy: 'desc',
                    actionType: "default",
                },
            }
        },
        created() {
            this.getBalance();
            this.getAbonnPending();
            this.getPannePending();
            this.getUser();
            this.getProduit();
            this.getAbonnTotal();
            this.getTransTotal();
        },
        methods: {
            getBalance(){
                let url = '/default/balance';
                    this.axiosGet(url).then(response =>{ 
                        this.balance = response.data;
                    });
            },
            getAbonnPending(){
                let url = '/default/abonnement';
                    this.axiosGet(url).then(response =>{ 
                        this.AbonnPending = response.data;
                    });
            },
            getPannePending(){
                let url = '/default/panne';
                    this.axiosGet(url).then(response =>{ 
                        this.PannePending = response.data;
                    });
            },
            getUser(){
                let url = '/default/user';
                    this.axiosGet(url).then(response =>{ 
                        this.users = response.data;
                    });
            },
            getAbonnTotal(){
                let url = '/default/abonntotal';
                    this.axiosGet(url).then(response =>{ 
                        this.AbonnTotal = response.data;
                    });
            },
            getTransTotal(){
                let url = '/default/transtotal';
                    this.axiosGet(url).then(response =>{ 
                        this.TransTotal = response.data;
                    });
            },
            getProduit(){
                let url = '/default/produit';
                    this.axiosGet(url).then(response =>{ 
                        this.produit = response.data;
                    });
            },
            getPanneUser(){
                let url = '/default/panneuser';
                    this.axiosGet(url).then(response =>{ 
                        this.TransTotal = response.data;
                    });
            },
            getTransUser(){
                let url = '/default/transuser';
                    this.axiosGet(url).then(response =>{ 
                        this.TransTotal = response.data;
                    });
            },
            getPanneAdmin(){
                let url = '/default/panneadmin';
                    this.axiosGet(url).then(response =>{ 
                        this.TransTotal = response.data;
                    });
            },
            getAbonnAdmin(){
                let url = '/default/abonnadmin';
                    this.axiosGet(url).then(response =>{ 
                        this.TransTotal = response.data;
                    });
            },
        }
    }
</script>

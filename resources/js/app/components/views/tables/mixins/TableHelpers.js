export const TableHelpers = {
    data() {
        return {
            TableType : [

                //TablePanneColumns

                [
                    {
                        title: this.$t('email'),
                        type: 'text',
                        key: 'email'
                    },
                    {
                        title: this.$t('date'),
                        type: 'text',
                        key: 'date'
                    },
                    {
                        title: this.$t('heure'),
                        type: 'text',
                        key: 'heure'
                    },
                    {
                        title: this.$t('panne'),
                        type: 'text',
                        key: 'panne'
                    },
                    {
                        title: this.$t('Etat'),
                        type: 'text',
                        key: 'Etat'
                    },
                ],

                //TableTransactionsColumns

                [
                    {
                        title: this.$t('emeteur'),
                        type: 'text',
                        key: 'emeteur'
                    },
                    {
                        title: this.$t('recepteur'),
                        type: 'text',
                        key: 'recepteur'
                    },
                    {
                        title: this.$t('date'),
                        type: 'text',
                        key: 'date'
                    },
                    {
                        title: this.$t('heure'),
                        type: 'text',
                        key: 'heure'
                    },
                    {
                        title: this.$t('montant'),
                        type: 'text',
                        key: 'montant'
                    },
                    {
                        title: this.$t('modalitePaiement'),
                        type: 'text',
                        key: 'modalitePaiement'
                    },
                ],

                //TableAbonnmentsColumns

                [
                    {
                        title: this.$t('email'),
                        type: 'text',
                        key: 'email'
                    },
                    {
                        title: this.$t('password'),
                        type: 'text',
                        key: 'password'
                    },
                    {
                        title: this.$t('produit'),
                        type: 'text',
                        key: 'produit'
                    },
                    {
                        title: this.$t('dateDebut'),
                        type: 'text',
                        key: 'dateDebut'
                    },
                    {
                        title: this.$t('datefin'),
                        type: 'text',
                        key: 'datefin'
                    },
                    {
                        title: this.$t('resultatcreation'),
                        type: 'text',
                        key: 'resultatcreation'
                    },
                    {
                        title: this.$t('etat'),
                        type: 'text',
                        key: 'etat'
                    },
                ],


                //tableColumns

                [
                    {
                        title: this.$t('name'),
                        type: 'text',
                        key: 'name',
                
                    },
                    {
                        title: this.$t('email'),
                        type: 'text',
                        key: 'email',
                
                    },
                    {
                        title: this.$t('status'),
                        type: 'custom-html',
                        key: 'status',
                        isVisible: true,
                        modifier: (value) => {
                            if (value) {
                                let ClassName = 'danger';
    
                                if (value === 'active') ClassName = `success`;
                                else if (value === 'invited') ClassName = `warning`;
    
                                return `<span class="badge badge-sm badge-pill badge-${ClassName}">${this.$t(value)}</span>`;
                            }
                        }
                    },
                    {
                        title: this.$t('phone'),
                        type: 'text',
                        key: 'phone',
                    },
                    {
                        title: this.$t('age'),
                        type: 'text',
                        key: 'age',
                    },
                    {
                        title: this.$t('gender'),
                        type: 'custom-html',
                        key: 'gender',
                        modifier: (value) => {
                            return `<span>${this.$t(value)}</span>`
                
                        }
                    },
                ],
            ],
            actionObj : {
                title: this.$t('action'),
                type: 'action',
            }
        }
    },
}
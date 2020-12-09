export const TableHelpers = {
    data() {
        return {
            TableType : [

                //TablePanneColumns

                [
                    {
                        title: this.$t('Email'),
                        type: 'text',
                        key: 'email'
                    },
                    {
                        title: this.$t('Date'),
                        type: 'text',
                        key: 'date'
                    },
                    {
                        title: this.$t('Heure'),
                        type: 'text',
                        key: 'heure'
                    },
                    {
                        title: this.$t('Panne'),
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
                        title: this.$t('Emeteur'),
                        type: 'text',
                        key: 'emeteur'
                    },
                    {
                        title: this.$t('Recepteur'),
                        type: 'text',
                        key: 'recepteur'
                    },
                    {
                        title: this.$t('Date'),
                        type: 'text',
                        key: 'date'
                    },
                    {
                        title: this.$t('Heure'),
                        type: 'text',
                        key: 'heure'
                    },
                    {
                        title: this.$t('Montant'),
                        type: 'text',
                        key: 'montant'
                    },
                    {
                        title: this.$t('Modalite de Paiement'),
                        type: 'text',
                        key: 'modalitePaiement'
                    },
                ],

                //TableAbonnmentsColumns

                [
                    {
                        title: this.$t('Email'),
                        type: 'text',
                        key: 'email'
                    },
                    {
                        title: this.$t('Mot de Passe'),
                        type: 'text',
                        key: 'password'
                    },
                    {
                        title: this.$t('Produit'),
                        type: 'text',
                        key: 'produit'
                    },
                    {
                        title: this.$t('Date de Debut'),
                        type: 'text',
                        key: 'dateDebut'
                    },
                    {
                        title: this.$t('Date de Fin'),
                        type: 'text',
                        key: 'datefin'
                    },
                    {
                        title: this.$t('Resultat de Creation'),
                        type: 'text',
                        key: 'resultatcreation'
                    },
                    {
                        title: this.$t('Etat'),
                        type: 'text',
                        key: 'etat'
                    },
                ],

                //PanneTable

                [
                    {
                        title: this.$t('Panne'),
                        type:'text',
                        key: 'panne'
                    },
                    {
                        title: this.$t('Color'),
                        type:'text',
                        key: 'color'
                    },
                ],

                //ModaliteTable

                [
                    {
                        title: this.$t('Modalite de Paiement'),
                        type:'text',
                        key: 'modalitePaiement'
                    },
                ],

                //ProduitTable

                [
                    {
                        title: this.$t('Product Name'),
                        type:'text',
                        key: 'nom'
                    },
                    {
                        title: this.$t('durantion in months'),
                        type:'text',
                        key: 'duree'
                    },
                    {
                        title: this.$t('Tarif Vente Revendeur'),
                        type:'text',
                        key: 'tarifVenteRevendeur'
                    },
                    {
                        title: this.$t('Tarif Achat Euro'),
                        type:'text',
                        key: 'tarifAchatEuro'
                    },
                    {
                        title: this.$t('Tarif Achat Dinar'),
                        type:'text',
                        key: 'tarifAchatDinar'
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
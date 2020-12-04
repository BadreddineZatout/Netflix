<template>
<div class="content-wrapper">
    <h1>hello admin</h1>
</div>
</template>

<script>
    import {FormMixin} from '../../../../core/mixins/form/FormMixin';
    import * as actions from '../../../config/ApiUrl';

    export default {

        mixins: [FormMixin],
        name: "Dashboard",
        data() {
            return {
                info: {},
            }
        },
        // created() {
        //     this.getusers();
        // },
        // mounted(){
        //     this.affiche();
        // },
        // methods: {
        //     getusers(){
        //         let url = actions.ADMIN;
        //             this.axiosGet(url).then(response =>{
        //                 //Vue.set(this.info, 'users' ,response.data);    
        //                 console.log(response.data);
        //             });
        //     },
        //     affiche(){
        //         console.log(this.info);
        //         console.log(this.info.users);
        //     },
        // }
    }
</script>

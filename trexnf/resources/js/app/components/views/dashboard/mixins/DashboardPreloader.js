export const DashboardPreloader = {
    data(){
        return{
            countCreatedResponse: 0
        }
    },
    mounted(){
        this.loaderHeight();
    },
    methods: {
        loaderHeight() {
            let windowHeight = window.innerHeight;
            $(".dashboard-preloader").css({
                "height": (windowHeight - 100) + "px"
            });
        },
    }
}
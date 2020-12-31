<template>
    <sidebar :data="data" :logo-src="logo" :logo-icon-src="logoIcon"></sidebar>
</template>

<script>
    export default {
        name : 'DashboardSidebar',
        props: {
            data: {
                required: true
            },
            logo : {
                type : String,
            },
            logoIcon : {
                type : String,
            }
        }
    }
</script>

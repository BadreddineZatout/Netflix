<template>
    <app-navbar :logo-url="logo"
                :user="user.loggedInUser"
                :selected-language="userLanguage"
                :language-data="languageList"
                :notificationData="notificationList"
                :profile-data="profileData"
                :showIdentifier="showIdentifier"
                all-notification-url="/all-notifications"
                @clicked="readNotification"/>
</template>

<script>
    import {UserMixin} from '../../user/mixins/UserMixin';
    import * as actions from '../../../../config/ApiUrl';
    import {axiosPost} from "../../../../helpers/AxiosHelper";
    import {mapActions} from "vuex";
    import AppFunction from "../../../../../core/helpers/app/AppFunction";

    export default {
        name : 'DashboardNavbar',
        mixins: [UserMixin],
        props: {
            logo: {
                type: String,
                default: AppFunction.getAppUrl('images/icon.png')
            }
        },
        data(){
            return{
                profileData: [
                    {
                        optionName: 'My Profile',
                        optionIcon: 'user',
                        url: actions.MY_PROFILE
                    },
                    // {
                    //     optionName: 'Notifications',
                    //     optionIcon: 'bell',
                    //     url: actions.All_NOTIFICATION
                    // },
                    // {
                    //     optionName: 'Settings',
                    //     optionIcon: 'settings',
                    //     url: actions.APP_SETTINGS
                    // },
                    {
                        optionName: 'Logout',
                        optionIcon: 'log-out',
                        url: actions.LOGOUT
                    },
                ]
            }
        },
        created() {
            this.$store.dispatch('getSettings');
            this.$store.dispatch('getNotifications');
            this.$store.dispatch('setSelectedLanguage');
            this.$store.dispatch('getUser');
            this.$store.dispatch('getLanguages');
        },
        computed: {
            languageList() {
                return this.$store.state.settings.languages
            },
            userLanguage() {
                // console.log(window.appLanguage, 'window');
            },
            showIdentifier() {
                const notifications = this.$store.getters.notificationList;
                return !(notifications && notifications.length && notifications.total_unread) ? false : true;
            }
        },

        methods: {
            ...mapActions([
                'getNotifications'
            ]),
            readNotification(notification) {
                axiosPost(`admin/user/notifications/mark-as-read/${notification.id}`).then(({data}) => {
                    if (data.data.url) {
                        window.location = data.data.url;
                    }
                    this.getNotifications();
                });
            }
        }
    }
</script>
